<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\ImageStorageService;
use App\Services\AjaxFieldService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected PostRepository $posts;
    protected ImageStorageService $images;
    protected AjaxFieldService $ajaxFieldService;

    public function __construct(
        PostRepository $posts,
        ImageStorageService $images,
        AjaxFieldService $ajaxFieldService
    ) {
        $this->posts = $posts;
        $this->images = $images;
        $this->ajaxFieldService = $ajaxFieldService;
        
    }

    // ============================================================
    // AJAX: Auto-save single field
    // ============================================================
    public function autoSave(Request $request, Post $post)
    {
        return $this->updateField($request, $post);
    }

    // ============================================================
    // AJAX: Update single field
    // ============================================================
    public function updateField(Request $request, Post $post)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        // The editor submits a display status, while the model stores is_published.
        if ($field === 'status') {
            $request->validate(['value' => 'required|in:draft,published']);

            $post->update([
                'is_published' => $value === 'published',
                'published_at' => $value === 'published'
                    ? ($post->published_at ?? now())
                    : null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đã lưu trạng thái bài viết',
            ]);
        }

        // Define allowed fields with validation rules
        $fieldConfig = [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $post->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ];

        return $this->ajaxFieldService->handleAjaxFieldUpdate(
            $post,
            $field,
            $value,
            $fieldConfig
        );
    }

    /** Upload or replace a post thumbnail from the edit screen. */
    public function uploadThumbnail(Request $request, Post $post)
    {
        $maxKb = (int) config('upload.limits.post_thumbnail.max_size', 2048);
        $request->validate([
            'file' => "required|image|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
        ]);

        try {
            $path = $this->images->upload(
                $request->file('file'),
                config('upload.disks.folders.post', 'posts'),
                $post->thumbnail,
                'thumbnail'
            );
            $post->update(['thumbnail' => $path]);

            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật ảnh bài viết',
                'url' => $post->fresh()->image_url,
            ]);
        } catch (\Throwable $e) {
            \Log::error('Post thumbnail upload failed', ['post_id' => $post->id, 'error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Không thể tải ảnh lên'], 500);
        }
    }

    /** Remove a post thumbnail without deleting the post. */
    public function deleteThumbnail(Post $post)
    {
        $thumbnail = $post->thumbnail;
        $post->update(['thumbnail' => null]);
        if ($thumbnail) {
            $this->images->delete($thumbnail);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa ảnh bài viết',
        ]);
    }

    public function index(Request $request)
    {

        $filters = [
            'search' => $request->input('search'),
            'is_published' => $request->input('status') === 'published' ? true :
                             ($request->input('status') === 'draft' ? false : null),
        ];

        $query = Post::query();

        if ($filters['search']) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('excerpt', 'like', '%' . $filters['search'] . '%');
            });
        }
        if ($filters['is_published'] !== null) {
            $query->where('is_published', $filters['is_published']);
        }

        $posts = $query->latest()->paginate(15);

        return view('admin.posts.index', compact('posts', 'filters'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(StorePostRequest $request)
    {

        $validated = $request->validated();

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_published'] = $validated['status'] === 'published';
        $validated['published_at'] = $validated['is_published']
            ? ($validated['published_at'] ?? now())
            : null;
        unset($validated['status']);
        $validated['author_id'] = auth()->id();

        try {
            DB::transaction(function () use ($request, &$validated) {
                if ($request->hasFile('thumbnail')) {
                    $validated['thumbnail'] = $this->images->upload(
                        $request->file('thumbnail'),
                        config('upload.disks.folders.post', 'posts')
                    );
                }
                $this->posts->create($validated);
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

    public function update(UpdatePostRequest $request, Post $post)
    {

        $validated = $request->validated();

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_published'] = $validated['status'] === 'published';
        $validated['published_at'] = $validated['is_published']
            ? ($validated['published_at'] ?? $post->published_at ?? now())
            : null;
        unset($validated['status']);
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

    public function uploadThumbnail(Request $request, Post $post)
    {
        $request->validate([
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'file' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'images' => 'nullable|array|max:1',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $file = $request->file('thumbnail')
            ?? $request->file('file')
            ?? $request->file('images.0');

        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn một ảnh hợp lệ',
            ], 422);
        }

        $oldThumbnail = $post->thumbnail;
        $thumbnail = $this->images->upload(
            $file,
            config('upload.disks.folders.post', 'posts'),
            $oldThumbnail
        );

        $post->update(['thumbnail' => $thumbnail]);

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật ảnh đại diện',
            'url' => $post->fresh()->image_url,
        ]);
    }

    public function deleteThumbnail(Post $post)
    {
        $thumbnail = $post->thumbnail;

        if (!$thumbnail) {
            return response()->json([
                'success' => false,
                'message' => 'Bài viết chưa có ảnh đại diện',
            ], 422);
        }

        $post->update(['thumbnail' => null]);
        $this->images->delete($thumbnail);

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa ảnh đại diện',
        ]);
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
