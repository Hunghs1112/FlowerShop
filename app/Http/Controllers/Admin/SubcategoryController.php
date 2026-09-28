<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Requests\UpdateSubcategoryRequest;
use App\Models\Category;
use App\Models\Subcategory;
use App\Repositories\SubcategoryRepository;
use App\Services\ImageStorageService;
use App\Services\AjaxFieldService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    protected SubcategoryRepository $subcategories;
    protected ImageStorageService $images;
    protected AjaxFieldService $ajaxFieldService;

    public function __construct(
        SubcategoryRepository $subcategories,
        ImageStorageService $images,
        AjaxFieldService $ajaxFieldService
    ) {
        $this->subcategories = $subcategories;
        $this->images = $images;
        $this->ajaxFieldService = $ajaxFieldService;
        
    }

    public function index(Request $request)
    {
        $filters = [
            'search'      => $request->input('search'),
            'category_id' => $request->input('category_id'),
            'is_active'   => $request->input('status') === 'active' ? true :
                            ($request->input('status') === 'inactive' ? false : null),
        ];

        $query = Subcategory::with('category')->withCount('products');

        if ($filters['search']) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }
        if ($filters['category_id']) {
            $query->where('category_id', $filters['category_id']);
        }
        if ($filters['is_active'] !== null) {
            $query->where('is_active', $filters['is_active']);
        }

        $subcategories = $query->orderBy('sort_order')->paginate(50);
        $categories    = Category::orderBy('name')->get();

        return view('admin.subcategories.index', compact('subcategories', 'categories', 'filters'));
    }

    public function create()
    {
        
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(StoreSubcategoryRequest $request)
    {

        $validated = $request->validated();

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? Subcategory::max('sort_order') + 1;

        try {
            DB::transaction(function () use ($request, &$validated) {
                if ($request->hasFile('image')) {
                    $validated['image'] = $this->images->upload(
                        $request->file('image'),
                        config('upload.disks.folders.category', 'categories')
                    );
                }

                $this->subcategories->create($validated);
            });
        } catch (\Throwable $e) {
            if (!empty($validated['image'])) {
                $this->images->delete($validated['image']);
            }
            throw $e;
        }

        return redirect()->route('admin.catalog.index', ['tab' => 'subcategories'])
            ->with('success', 'Tạo danh mục phụ thành công');
    }

    public function edit(Subcategory $subcategory)
    {
        
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(UpdateSubcategoryRequest $request, Subcategory $subcategory)
    {

        $validated = $request->validated();

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active');
        $oldImage = $subcategory->image;

        try {
            DB::transaction(function () use ($request, $subcategory, &$validated, $oldImage) {
                if ($request->hasFile('image')) {
                    $validated['image'] = $this->images->upload(
                        $request->file('image'),
                        config('upload.disks.folders.category', 'categories')
                    );
                }

                $subcategory->update($validated);
            });

            if (!empty($validated['image']) && $validated['image'] !== $oldImage) {
                $this->images->delete($oldImage);
            }
        } catch (\Throwable $e) {
            if (!empty($validated['image']) && $validated['image'] !== $oldImage) {
                $this->images->delete($validated['image']);
            }
            throw $e;
        }

        return redirect()->route('admin.catalog.index', ['tab' => 'subcategories'])
            ->with('success', 'Cập nhật danh mục phụ thành công');
    }

    public function destroy(Subcategory $subcategory)
    {

        if ($subcategory->products()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Không thể xóa danh mục phụ đang có sản phẩm');
        }

        $imagePath = $subcategory->image;
        $subcategory->delete();

        if ($imagePath) {
            $this->images->delete($imagePath);
        }

        return redirect()->route('admin.catalog.index', ['tab' => 'subcategories'])
            ->with('success', 'Xóa danh mục phụ thành công');
    }

    public function autoSave(Request $request, Subcategory $subcategory)
    {

        $field = $request->input('field');
        $value = $request->input('value');

        $fieldConfig = [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:subcategories,slug,' . $subcategory->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ];

        return $this->ajaxFieldService->handleAjaxFieldUpdate(
            $subcategory,
            $field,
            $value,
            $fieldConfig
        );
    }

    // ============================================================
    // AJAX: Upload subcategory image
    // ============================================================
    public function uploadImage(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'images' => 'required|array|max:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            $oldImage = $subcategory->image;
            $imagePath = null;
            
            $imagePath = $this->images->upload(
                $request->file('images')[0],
                config('upload.disks.folders.category', 'categories')
            );

            $subcategory->update(['image' => $imagePath]);
            $this->images->delete($oldImage);

            return response()->json([
                'success' => true,
                'message' => 'Đã tải ảnh lên',
                'image_url' => $subcategory->image_url
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
    // AJAX: Delete subcategory image
    // ============================================================
    public function deleteImage(Subcategory $subcategory)
    {
        if (!$subcategory->image) {
            return response()->json([
                'success' => false,
                'message' => 'Danh mục phụ không có ảnh'
            ], 404);
        }

        $imagePath = $subcategory->image;
        $subcategory->update(['image' => null]);
        $this->images->delete($imagePath);

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa ảnh'
        ]);
    }
}
