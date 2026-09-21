<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /** @var ImageStorageService */
    protected $images;

    public function __construct(ImageStorageService $images)
    {
        $this->images = $images;
    }

    // ============================================================
    // AJAX: Auto-save single field
    // ============================================================
    public function autoSave(Request $request, Category $category)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        // Validate field name to prevent mass assignment
        $allowedFields = [
            'name', 'slug', 'description', 'icon', 'is_active', 'sort_order'
        ];

        if (!in_array($field, $allowedFields)) {
            return response()->json([
                'success' => false,
                'message' => 'Trường không hợp lệ'
            ], 422);
        }

        // Validate specific fields
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
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

        // Handle boolean fields
        if ($field === 'is_active') {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }

        // Auto-generate slug from name if name changed
        if ($field === 'name' && !empty($value) && empty($category->slug)) {
            $value = Str::slug($value);
        }

        $category->update([$field => $value]);

        return response()->json([
            'success' => true,
            'message' => 'Đã lưu ' . $field,
            'data' => [
                $field => $category->$field
            ]
        ]);
    }

    // ============================================================
    // AJAX: Upload category image
    // ============================================================
    public function uploadImage(Request $request, Category $category)
    {
        $maxKb = (int) config('upload.limits.category_image.max_size', 2048);

        $request->validate([
            'file' => "required|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}"
        ]);

        $oldImage = $category->image;

        try {
            $path = $this->images->upload(
                $request->file('file'),
                config('upload.disks.folders.category', 'categories'),
                $oldImage
            );

            $category->update(['image' => $path]);

            return response()->json([
                'success' => true,
                'message' => 'Đã tải lên ảnh mới',
                'imageUrl' => asset('storage/' . $path),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tải lên: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================================
    // AJAX: Upload category hover image
    // ============================================================
    public function uploadHoverImage(Request $request, Category $category)
    {
        $maxKb = (int) config('upload.limits.category_image.max_size', 2048);

        $request->validate([
            'file' => "required|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}"
        ]);

        $oldImage = $category->hover_image;

        try {
            $path = $this->images->upload(
                $request->file('file'),
                config('upload.disks.folders.category', 'categories'),
                $oldImage
            );

            $category->update(['hover_image' => $path]);

            return response()->json([
                'success' => true,
                'message' => 'Đã tải lên ảnh hover',
                'imageUrl' => asset('storage/' . $path),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tải lên: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================================
    // AJAX: Delete category image
    // ============================================================
    public function deleteImage(Category $category)
    {
        $imagePath = $category->image;

        if ($imagePath) {
            $category->update(['image' => null]);
            $this->images->delete($imagePath);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa ảnh'
        ]);
    }

    // ============================================================
    // AJAX: Delete category hover image
    // ============================================================
    public function deleteHoverImage(Category $category)
    {
        $imagePath = $category->hover_image;

        if ($imagePath) {
            $category->update(['hover_image' => null]);
            $this->images->delete($imagePath);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa ảnh hover'
        ]);
    }

    public function index(Request $request)
    {
        $query = Category::withCount(['products', 'subcategories']);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $categories = $query->orderBy('sort_order')->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $maxKb = (int) config('upload.limits.category_image.max_size', 2048);
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:50',
            'image'       => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
            'is_active'   => 'boolean',
            'sort_order'  => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active']  = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? Category::max('sort_order') + 1;

        try {
            DB::transaction(function () use ($request, &$validated) {
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $validated['image'] = $this->images->upload(
                        $file,
                        config('upload.disks.folders.category', 'categories')
                    );
                }

                Category::create($validated);
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

    public function update(Request $request, Category $category)
    {
        $maxKb = (int) config('upload.limits.category_image.max_size', 2048);
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:50',
            'image'       => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
            'is_active'   => 'boolean',
            'sort_order'  => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active');

        $oldImage = $category->image;

        try {
            DB::transaction(function () use ($request, $category, &$validated, $oldImage) {
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $validated['image'] = $this->images->upload(
                        $file,
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