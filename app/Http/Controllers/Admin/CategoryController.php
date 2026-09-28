<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Responses\AjaxResponse;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Services\ImageStorageService;
use App\Services\AjaxFieldService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected CategoryRepository $categories;
    protected ImageStorageService $images;
    protected AjaxFieldService $ajaxFieldService;

    public function __construct(
        CategoryRepository $categories,
        ImageStorageService $images,
        AjaxFieldService $ajaxFieldService
    ) {
        $this->categories = $categories;
        $this->images = $images;
        $this->ajaxFieldService = $ajaxFieldService;
        
    }

    // ============================================================
    // AJAX: Auto-save single field
    // ============================================================
    public function autoSave(Request $request, Category $category)
    {

        $field = $request->input('field');
        $value = $request->input('value');

        // Define allowed fields with validation rules
        $fieldConfig = [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ];

        return $this->ajaxFieldService->handleAjaxFieldUpdate(
            $category,
            $field,
            $value,
            $fieldConfig
        );
    }
    public function index(Request $request)
    {

        $filters = [
            'search' => $request->input('search'),
            'is_active' => $request->input('status') === 'active' ? true :
                          ($request->input('status') === 'inactive' ? false : null),
        ];

        $query = Category::withCount(['products', 'subcategories']);

        if ($filters['search']) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }
        if ($filters['is_active'] !== null) {
            $query->where('is_active', $filters['is_active']);
        }

        $categories = $query->orderBy('sort_order')->paginate(50);

        return view('admin.categories.index', compact('categories', 'filters'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {

        $validated = $request->validated();

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? Category::max('sort_order') + 1;

        try {
            DB::transaction(function () use ($request, &$validated) {
                if ($request->hasFile('image')) {
                    $validated['image'] = $this->images->upload(
                        $request->file('image'),
                        config('upload.disks.folders.category', 'categories')
                    );
                }

                if ($request->hasFile('banner_image')) {
                    $validated['banner_image'] = $this->images->upload(
                        $request->file('banner_image'),
                        config('upload.disks.folders.category', 'categories')
                    );
                }

                $this->categories->create($validated);
            });
        } catch (\Throwable $e) {
            if (!empty($validated['image'])) {
                $this->images->delete($validated['image']);
            }
            if (!empty($validated['banner_image'])) {
                $this->images->delete($validated['banner_image']);
            }
            throw $e;
        }

        return redirect()->route('admin.catalog.index', ['tab' => 'categories'])
            ->with('success', 'Tạo danh mục thành công');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {

        $validated = $request->validated();

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active');
        $oldImage = $category->image;
        $oldHoverImage = $category->hover_image;
        $oldBannerImage = $category->banner_image;

        try {
            DB::transaction(function () use ($request, $category, &$validated, $oldImage, $oldHoverImage, $oldBannerImage) {
                if ($request->hasFile('image')) {
                    $validated['image'] = $this->images->upload(
                        $request->file('image'),
                        config('upload.disks.folders.category', 'categories')
                    );
                }

                if ($request->hasFile('hover_image')) {
                    $validated['hover_image'] = $this->images->upload(
                        $request->file('hover_image'),
                        config('upload.disks.folders.category', 'categories')
                    );
                }

                if ($request->hasFile('banner_image')) {
                    $validated['banner_image'] = $this->images->upload(
                        $request->file('banner_image'),
                        config('upload.disks.folders.category', 'categories')
                    );
                }

                $category->update($validated);
            });

            if (!empty($validated['image']) && $validated['image'] !== $oldImage) {
                $this->images->delete($oldImage);
            }
            if (!empty($validated['hover_image']) && $validated['hover_image'] !== $oldHoverImage) {
                $this->images->delete($oldHoverImage);
            }
            if (!empty($validated['banner_image']) && $validated['banner_image'] !== $oldBannerImage) {
                $this->images->delete($oldBannerImage);
            }
        } catch (\Throwable $e) {
            if (!empty($validated['image']) && $validated['image'] !== $oldImage) {
                $this->images->delete($validated['image']);
            }
            if (!empty($validated['hover_image']) && $validated['hover_image'] !== $oldHoverImage) {
                $this->images->delete($validated['hover_image']);
            }
            if (!empty($validated['banner_image']) && $validated['banner_image'] !== $oldBannerImage) {
                $this->images->delete($validated['banner_image']);
            }
            throw $e;
        }

        return redirect()->route('admin.catalog.index', ['tab' => 'categories'])
            ->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy(Category $category)
    {

        if ($category->products()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Không thể xóa danh mục đang có sản phẩm');
        }

        if ($category->subcategories()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Không thể xóa danh mục đang có danh mục phụ');
        }

        $imagePath = $category->image;
        $hoverImagePath = $category->hover_image;
        $bannerImagePath = $category->banner_image;
        $category->delete();

        if ($imagePath) {
            $this->images->delete($imagePath);
        }
        
        if ($hoverImagePath) {
            $this->images->delete($hoverImagePath);
        }

        if ($bannerImagePath) {
            $this->images->delete($bannerImagePath);
        }

        return redirect()->route('admin.catalog.index', ['tab' => 'categories'])
            ->with('success', 'Xóa danh mục thành công');
    }

    // ============================================================
    // AJAX: Upload category image
    // ============================================================
    public function uploadImage(Request $request, Category $category)
    {
        $request->validate([
            'images' => 'required|array|max:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            $oldImage = $category->image;
            $imagePath = null;
            
            $imagePath = $this->images->upload(
                $request->file('images')[0],
                config('upload.disks.folders.category', 'categories')
            );

            $category->update(['image' => $imagePath]);
            $this->images->delete($oldImage);

            return response()->json([
                'success' => true,
                'message' => 'Đã tải ảnh lên',
                'image_url' => $category->image_url
            ]);
        } catch (\Exception $e) {
            $this->images->delete($imagePath);
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tải ảnh: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================================
    // AJAX: Delete category image
    // ============================================================
    public function deleteImage(Category $category)
    {
        if (!$category->image) {
            return response()->json([
                'success' => false,
                'message' => 'Danh mục không có ảnh'
            ], 404);
        }

        $imagePath = $category->image;
        $category->update(['image' => null]);
        $this->images->delete($imagePath);

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa ảnh'
        ]);
    }

    // ============================================================
    // AJAX: Upload category hover image
    // ============================================================
    public function uploadHoverImage(Request $request, Category $category)
    {
        $request->validate([
            'images' => 'required|array|max:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            $oldHoverImage = $category->hover_image;
            $imagePath = null;
            
            $imagePath = $this->images->upload(
                $request->file('images')[0],
                config('upload.disks.folders.category', 'categories')
            );

            $category->update(['hover_image' => $imagePath]);
            $this->images->delete($oldHoverImage);

            return response()->json([
                'success' => true,
                'message' => 'Đã tải ảnh hover lên',
                'image_url' => $category->hover_image_url
            ]);
        } catch (\Exception $e) {
            $this->images->delete($imagePath);
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tải ảnh hover: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================================
    // AJAX: Delete category hover image
    // ============================================================
    public function deleteHoverImage(Category $category)
    {
        if (!$category->hover_image) {
            return response()->json([
                'success' => false,
                'message' => 'Danh mục không có ảnh hover'
            ], 404);
        }

        $hoverImagePath = $category->hover_image;
        $category->update(['hover_image' => null]);
        $this->images->delete($hoverImagePath);

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa ảnh hover'
        ]);
    }

    // ============================================================
    // AJAX: Upload category banner image
    // ============================================================
    public function uploadBannerImage(Request $request, Category $category)
    {
        $request->validate([
            'images' => 'required|array|max:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            $oldBannerImage = $category->banner_image;
            $imagePath = null;
            
            $imagePath = $this->images->upload(
                $request->file('images')[0],
                config('upload.disks.folders.category', 'categories')
            );

            $category->update(['banner_image' => $imagePath]);
            $this->images->delete($oldBannerImage);

            return response()->json([
                'success' => true,
                'message' => 'Đã tải ảnh banner lên',
                'image_url' => $category->banner_image_url
            ]);
        } catch (\Exception $e) {
            $this->images->delete($imagePath);
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tải ảnh banner: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================================
    // AJAX: Delete category banner image
    // ============================================================
    public function deleteBannerImage(Category $category)
    {
        if (!$category->banner_image) {
            return response()->json([
                'success' => false,
                'message' => 'Danh mục không có ảnh banner'
            ], 404);
        }

        $bannerImagePath = $category->banner_image;
        $category->update(['banner_image' => null]);
        $this->images->delete($bannerImagePath);

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa ảnh banner'
        ]);
    }
}
