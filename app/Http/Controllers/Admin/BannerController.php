<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    protected ImageStorageService $images;

    public function __construct(ImageStorageService $images)
    {
        $this->images = $images;
    }

    public function index()
    {
        $banners = Banner::ordered()->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ], [
            'image.required' => 'Vui lòng chọn ảnh banner.',
            'image.image' => 'File phải là ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpg, jpeg, png, gif, webp.',
            'image.max' => 'Ảnh không được vượt quá 4MB.',
            'button_link.url' => 'Link phải là URL hợp lệ.',
        ]);

        // Upload image
        $imagePath = $this->images->upload(
            $request->file('image'),
            'banners'
        );

        $banner = Banner::create([
            'title' => $validated['title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'image_path' => $imagePath,
            'button_text' => $validated['button_text'] ?? null,
            'button_link' => $validated['button_link'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'location' => 'home',
        ]);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner đã được tạo thành công.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ], [
            'image.image' => 'File phải là ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpg, jpeg, png, gif, webp.',
            'image.max' => 'Ảnh không được vượt quá 4MB.',
            'button_link.url' => 'Link phải là URL hợp lệ.',
        ]);

        $data = [
            'title' => $validated['title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_link' => $validated['button_link'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        // Upload new image if provided
        if ($request->hasFile('image')) {
            $data['image_path'] = $this->images->upload(
                $request->file('image'),
                'banners',
                $banner->image_path // Old path for deletion
            );
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner đã được cập nhật.');
    }

    public function destroy(Banner $banner)
    {
        // Delete image file
        if ($banner->image_path) {
            $this->images->delete($banner->image_path);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner đã được xóa.');
    }

    // AJAX: Update field (for inline editing)
    public function updateField(Request $request, Banner $banner)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        $allowedFields = ['title', 'subtitle', 'button_text', 'button_link', 'sort_order', 'is_active'];

        if (!in_array($field, $allowedFields)) {
            return response()->json([
                'success' => false,
                'message' => 'Trường không hợp lệ'
            ], 422);
        }

        // Handle boolean fields
        if ($field === 'is_active') {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }

        // Handle sort_order
        if ($field === 'sort_order') {
            $value = max(0, (int) $value);
        }

        $banner->update([$field => $value]);

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật',
        ]);
    }

    // AJAX: Upload image
    public function uploadImage(Request $request, Banner $banner)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
        ]);

        $imagePath = $this->images->upload(
            $request->file('file'),
            'banners',
            $banner->image_path
        );

        $banner->update(['image_path' => $imagePath]);

        return response()->json([
            'success' => true,
            'message' => 'Đã tải ảnh lên',
            'image_url' => $banner->image_url,
        ]);
    }
}
