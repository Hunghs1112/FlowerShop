<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /** @var ImageStorageService */
    protected $images;

    public function __construct(ImageStorageService $images)
    {
        $this->images = $images;
    }

    // ============================================================
    // AJAX: Update single field
    // ============================================================
    public function updateField(Request $request, Post $post)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        // Validate field name to prevent mass assignment
        $allowedFields = [
            'title', 'slug', 'excerpt', 'content', 'status', 'published_at',
            'meta_title', 'meta_description', 'is_published'
        ];

        if (!in_array($field, $allowedFields)) {
            return response()->json([
                'success' => false,
                'message' => 'Trường không hợp lệ'
            ], 422);
        }

        // Validate specific fields
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $post->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make([$field => $value], [
            $field => $rules[$field] ?? 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first($field),
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        // Auto-generate slug from title if title changed
        if ($field === 'title' && !empty($value) && empty($post->slug)) {
            $value = Str::slug($value);
        }

        // Handle status -> is_published conversion
        if ($field === 'status') {
            $post->is_published = $value === 'published' ? 1 : 0;
            $post->save();
        } else {
            $post->update([$field => $value]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã lưu ' . $field,
            'data' => [
                $field => $field === 'status' ? ($post->is_published ? 'published' : 'draft') : $post->$field
            ]
        ]);
    }

    // ============================================================
    // AJAX: Upload post thumbnail
    // ============================================================
    public function uploadThumbnail(Request $request, Post $post)
    {
        $maxKb = (int) config('upload.limits.post_thumbnail.max_size', 2048);

        $request->validate([
            'file' => "required|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}"
        ]);

        $oldThumbnail = $post->thumbnail;

        try {
            $path = $this->images->upload(
                $request->file('file'),
                config('upload.disks.folders.post', 'posts'),
                $oldThumbnail
            );

            $post->update(['thumbnail' => $path]);

            return response()->json([
                'success' => true,
                'message' => 'Đã tải lên ảnh mới',
                'imageUrl' => $post->image_url,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tải lên: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================================
    // AJAX: Delete post thumbnail
    // ============================================================
    public function deleteThumbnail(Post $post)
    {
        $thumbnail = $post->thumbnail;

        if ($thumbnail) {
            $post->update(['thumbnail' => null]);
            $this->images->delete($thumbnail);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa ảnh'
        ]);
    }

    public function index(Request $request)
    {
        $query = Post::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%');
            });
        }

        if ($status = $request->input('status')) {
            if ($status === 'published') {
                $query->published();
            } elseif ($status === 'draft') {
                $query->whereNull('published_at');
            }
        }

        $posts = $query->latest()->paginate(20);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $maxKb = (int) config('upload.limits.post_thumbnail.max_size', 2048);
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:posts,slug',
            'excerpt'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'thumbnail'        => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
            'status'           => 'required|in:draft,published',
            'published_at'     => 'nullable|date',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_published'] = $validated['status'] === 'published';
        $validated['author_id']    = auth()->id();

        try {
            DB::transaction(function () use ($request, &$validated) {
                if ($request->hasFile('thumbnail')) {
                    $validated['thumbnail'] = $this->images->upload(
                        $request->file('thumbnail'),
                        config('upload.disks.folders.post', 'posts')
                    );
                }
                Post::create($validated);
            });
        } catch (\Throwable $e) {
            if (!empty($validated['thumbnail'])) {
                $this->images->delete($validated['thumbnail']);
            }
            throw $e;
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Tạo bài viết thành công');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $maxKb = (int) config('upload.limits.post_thumbnail.max_size', 2048);
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:posts,slug,' . $post->id,
            'excerpt'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'thumbnail'        => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
            'status'           => 'required|in:draft,published',
            'published_at'     => 'nullable|date',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_published'] = $validated['status'] === 'published';

        $oldThumbnail = $post->thumbnail;

        try {
            DB::transaction(function () use ($request, $post, &$validated, $oldThumbnail) {
                if ($request->hasFile('thumbnail')) {
                    $validated['thumbnail'] = $this->images->upload(
                        $request->file('thumbnail'),
                        config('upload.disks.folders.post', 'posts'),
                        $oldThumbnail
                    );
                }
                $post->update($validated);
            });
        } catch (\Throwable $e) {
            if (!empty($validated['thumbnail']) && $validated['thumbnail'] !== $oldThumbnail) {
                $this->images->delete($validated['thumbnail']);
            }
            throw $e;
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Cập nhật bài viết thành công');
    }

    public function destroy(Post $post)
    {
        $thumbnail = $post->thumbnail;
        $post->delete();
        if ($thumbnail) {
            $this->images->delete($thumbnail);
        }
        return redirect()->route('admin.posts.index')
            ->with('success', 'Xóa bài viết thành công');
    }
}