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

                $this->categories->create($validated);
            });
        } catch (\Throwable $e) {
            if (!empty($validated['image'])) {
                $this->images->delete($validated['image']);
            }
            throw $e;
        }

        return redirect()->route('admin.categories.index')
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

        try {
            DB::transaction(function () use ($request, $category, &$validated, $oldImage) {
                if ($request->hasFile('image')) {
                    $validated['image'] = $this->images->upload(
                        $request->file('image'),
                        config('upload.disks.folders.category', 'categories'),
                        $oldImage
                    );
                }

                $category->update($validated);
            });
        } catch (\Throwable $e) {
            if (!empty($validated['image']) && $validated['image'] !== $oldImage) {
                $this->images->delete($validated['image']);
            }
            throw $e;
        }

        return redirect()->route('admin.categories.index')
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
        $category->delete();

        if ($imagePath) {
            $this->images->delete($imagePath);
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Xóa danh mục thành công');
    }
}