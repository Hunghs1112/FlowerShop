<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function __construct(private readonly ImageStorageService $images)
    {
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = array_key_exists((string) $request->input('category'), Post::CATEGORIES)
            ? $request->input('category')
            : null;

        $query = fn () => Post::published()
            ->with('author')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('excerpt', 'like', '%' . $search . '%');
                });
            });

        $postsQuery = $query();
        $showingFeedbackFallback = false;

        if ($category) {
            $postsQuery->where('category', $category);

            if ($category !== 'du-an' && ! (clone $postsQuery)->exists()) {
                $feedbackQuery = $query()->where('category', 'du-an');

                if ((clone $feedbackQuery)->exists()) {
                    $postsQuery = $feedbackQuery;
                    $showingFeedbackFallback = true;
                }
            }
        }

        $posts = $postsQuery
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $bannerKey = 'blog';

        return view('blog.index', compact('posts', 'search', 'category', 'showingFeedbackFallback', 'bannerKey'));
    }

    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request)
    {
        $maxKb = (int) config('upload.limits.post_thumbnail.max_size', 2048);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'category' => ['required', Rule::in(array_keys(Post::CATEGORIES))],
            'content' => 'required|string',
            'thumbnail' => "required|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
        ]);

        $baseSlug = Str::slug($validated['title']) ?: 'bai-viet';
        $slug = $baseSlug;
        for ($suffix = 2; Post::where('slug', $slug)->exists(); $suffix++) {
            $slug = $baseSlug . '-' . $suffix;
        }

        $validated += [
            'slug' => $slug,
            'author_id' => $request->user()->id,
            'is_published' => true,
            'published_at' => now(),
        ];

        try {
            $post = DB::transaction(function () use ($request, &$validated) {
                if ($request->hasFile('thumbnail')) {
                    $validated['thumbnail'] = $this->images->upload(
                        $request->file('thumbnail'),
                        config('upload.disks.folders.post', 'posts')
                    );
                }

                return Post::create($validated);
            });
        } catch (\Throwable $exception) {
            if (! empty($validated['thumbnail'])) {
                $this->images->delete($validated['thumbnail']);
            }
            throw $exception;
        }

        return redirect()->route('blog.show', $post->slug)
            ->with('success', 'Bài viết của bạn đã được đăng.');
    }

    public function uploadContentImage(Request $request)
    {
        $maxKb = (int) config('upload.limits.post_thumbnail.max_size', 2048);
        $request->validate([
            'image' => "required|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
        ]);

        $path = $this->images->upload($request->file('image'), 'posts/content');

        return response()->json(['url' => $this->images->url($path)]);
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->with('author')
            ->published()
            ->firstOrFail();

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        $bannerKey = 'blog';

        return view('blog.show', compact('post', 'relatedPosts', 'bannerKey'));
    }
}
