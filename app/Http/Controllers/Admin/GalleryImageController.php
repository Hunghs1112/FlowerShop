<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;

class GalleryImageController extends Controller
{
    public function __construct(private ImageStorageService $images) {}

    public function index(Request $request)
    {
        $query = GalleryImage::query()->orderBy('sort_order');
        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(fn ($q) => $q->where('title', 'like', "%{$search}%")
                ->orWhere('caption', 'like', "%{$search}%"));
        }

        return view('admin.gallery-images.index', ['items' => $query->paginate(20)]);
    }

    public function create()
    {
        return view('admin.gallery-images.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['image'] = $this->images->upload($request->file('image'), 'gallery-images');
        GalleryImage::create($data);

        return redirect()->route('admin.gallery-images.index')->with('success', 'Đã thêm ảnh gallery.');
    }

    public function edit(GalleryImage $galleryImage)
    {
        return view('admin.gallery-images.edit', ['item' => $galleryImage]);
    }

    public function update(Request $request, GalleryImage $galleryImage)
    {
        $data = $this->validated($request, false);
        $data['is_active'] = $request->boolean('is_active');
        $oldImage = $galleryImage->image;

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->upload($request->file('image'), 'gallery-images', $oldImage);
        }

        $galleryImage->update($data);
        return redirect()->route('admin.gallery-images.index')->with('success', 'Đã cập nhật ảnh gallery.');
    }

    public function destroy(GalleryImage $galleryImage)
    {
        $image = $galleryImage->image;
        $galleryImage->delete();
        if (!str_starts_with($image, 'images/')) {
            $this->images->delete($image);
        }

        return redirect()->route('admin.gallery-images.index')->with('success', 'Đã xóa ảnh gallery.');
    }

    private function validated(Request $request, bool $imageRequired = true): array
    {
        return $request->validate([
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:255',
            'alt_text' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'image' => ($imageRequired ? 'required|' : 'nullable|') . 'image|mimes:jpeg,png,jpg,gif,webp|max:8192',
        ]);
    }
}
