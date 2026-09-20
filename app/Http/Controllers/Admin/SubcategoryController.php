<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    protected $images;

    public function __construct(ImageStorageService $images)
    {
        $this->images = $images;
    }

    public function index(Request $request)
    {
        $query = Subcategory::with('category')->withCount('products');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $subcategories = $query->orderBy('sort_order')->paginate(20);
        $categories = Category::orderBy('name')->get();

        return view('admin.subcategories.index', compact('subcategories', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $maxKb = (int) config('upload.limits.category_image.max_size', 2048);
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:subcategories,slug',
            'description' => 'nullable|string',
            'image'       => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
            'is_active'   => 'boolean',
            'sort_order'  => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active']  = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? Subcategory::max('sort_order') + 1;

        try {
            DB::transaction(function () use ($request, &$validated) {
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $validated['image'] = $this->images->upload(
                        $file,
                        config('upload.disks.folders.category', 'categories')
                    );
                }

                Subcategory::create($validated);
            });
        } catch (\Throwable $e) {
            if (!empty($validated['image'])) {
                $this->images->delete($validated['image']);
            }
            throw $e;
        }

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Tạo danh mục phụ thành công');
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $maxKb = (int) config('upload.limits.category_image.max_size', 2048);
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:subcategories,slug,' . $subcategory->id,
            'description' => 'nullable|string',
            'image'       => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
            'is_active'   => 'boolean',
            'sort_order'  => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active');

        $oldImage = $subcategory->image;

        try {
            DB::transaction(function () use ($request, $subcategory, &$validated, $oldImage) {
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $validated['image'] = $this->images->upload(
                        $file,
                        config('upload.disks.folders.category', 'categories'),
                        $oldImage
                    );
                }

                $subcategory->update($validated);
            });
        } catch (\Throwable $e) {
            if (!empty($validated['image']) && $validated['image'] !== $oldImage) {
                $this->images->delete($validated['image']);
            }
            throw $e;
        }

        return redirect()->route('admin.subcategories.index')
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

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Xóa danh mục phụ thành công');
    }

    public function autoSave(Request $request, Subcategory $subcategory)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        $allowedFields = [
            'category_id', 'name', 'slug', 'description', 'is_active', 'sort_order'
        ];

        if (!in_array($field, $allowedFields)) {
            return response()->json([
                'success' => false,
                'message' => 'Trường không hợp lệ'
            ], 422);
        }

        $rules = [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:subcategories,slug,' . $subcategory->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ];

        if (isset($rules[$field])) {
            $validator = validator(['value' => $value], ['value' => $rules[$field]]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first('value')
                ], 422);
            }
        }

        if ($field === 'is_active') {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        $subcategory->update([$field => $value]);

        return response()->json([
            'success' => true,
            'message' => 'Đã lưu tự động',
            'value' => $value
        ]);
    }
}
