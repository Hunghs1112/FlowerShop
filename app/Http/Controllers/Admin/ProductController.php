<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
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
    public function updateField(Request $request, Product $product)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        // Validate field name to prevent mass assignment
        $allowedFields = [
            'name', 'slug', 'sku', 'category_id', 'price', 'stock',
            'description', 'short_description', 'is_active', 'is_featured'
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
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
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

        // Auto-generate slug from name if name changed and slug is empty
        if ($field === 'name' && empty($value)) {
            return response()->json([
                'success' => false,
                'message' => 'Tên sản phẩm không được trống'
            ], 422);
        }

        if ($field === 'name' && !empty($value)) {
            $slugField = $request->input('slug_field');
            if (!empty($slugField)) {
                $product->slug = Str::slug($value);
            }
        }

        // Handle boolean fields
        if (in_array($field, ['is_active', 'is_featured'])) {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }

        $product->update([$field => $value]);

        return response()->json([
            'success' => true,
            'message' => 'Đã lưu ' . $field,
            'data' => [
                $field => $product->$field
            ]
        ]);
    }

    // ============================================================
    // AJAX: Upload file for field
    // ============================================================
    public function uploadFile(Request $request, Product $product)
    {
        $field = $request->input('field', 'images');

        if ($field === 'images') {
            return $this->uploadProductImages($request, $product);
        }

        return response()->json([
            'success' => false,
            'message' => 'Field không hỗ trợ'
        ], 422);
    }

    protected function uploadProductImages(Request $request, Product $product)
    {
        $maxKb = (int) config('upload.limits.product_images.max_size', 2048);
        $maxCnt = (int) config('upload.limits.product_images.max_count', 10);

        $request->validate([
            'file' => "required|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}"
        ]);

        $currentCount = $product->productImages()->count();
        if ($currentCount >= $maxCnt) {
            return response()->json([
                'success' => false,
                'message' => "Tối đa {$maxCnt} ảnh"
            ], 422);
        }

        try {
            $folder = config('upload.disks.folders.product', 'products');
            $path = $this->images->upload(
                $request->file('file'),
                $folder,
                'product_images'
            );

            $maxSortOrder = $product->productImages()->max('sort_order') ?? -1;

            $image = ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'sort_order' => $maxSortOrder + 1,
                'is_primary' => $currentCount === 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đã tải lên ảnh mới',
                'imageUrl' => asset('storage/' . $path),
                'image' => [
                    'id' => $image->id,
                    'path' => $path,
                    'is_primary' => $image->is_primary,
                    'sort_order' => $image->sort_order,
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tải lên: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================================
    // AJAX: Delete product image
    // ============================================================
    public function deleteImage(Product $product, ProductImage $image)
    {
        // Security: ensure image belongs to this product
        if ($image->product_id !== $product->id) {
            return response()->json([
                'success' => false,
                'message' => 'Ảnh không thuộc sản phẩm này'
            ], 403);
        }

        $path = $image->image_path;
        $image->delete();
        $this->images->delete($path);

        // Auto-set new primary if needed
        if ($product->productImages()->count() > 0 && !$product->productImages()->where('is_primary', true)->exists()) {
            $firstImage = $product->productImages()->orderBy('sort_order')->first();
            $firstImage->update(['is_primary' => true]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa ảnh'
        ]);
    }

    // ============================================================
    // AJAX: Set primary image
    // ============================================================
    public function setPrimaryImage(Request $request, Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            return response()->json([
                'success' => false,
                'message' => 'Ảnh không thuộc sản phẩm này'
            ], 403);
        }

        ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Đã đặt làm ảnh chính'
        ]);
    }

    public function index(Request $request)
    {
        $query = Product::with(['category', 'productImages']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->latest()->paginate(20);
        $categories = Category::active()->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        $maxImages = (int) config('upload.limits.product_images.max_count', 10);
        return view('admin.products.create', compact('categories', 'maxImages'));
    }

    public function store(Request $request)
    {
        $maxKb   = (int) config('upload.limits.product_images.max_size', 2048);
        $maxCnt  = (int) config('upload.limits.product_images.max_count', 10);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:products,slug',
            'sku'         => 'nullable|string|max:100|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
            'is_featured' => 'boolean',
            // Hard upper bound on image count + MIME whitelist per file.
            'images'      => "nullable|array|max:{$maxCnt}",
            'images.*'    => "file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active']   = $request->boolean('is_active', true);
        $validated['is_featured'] = $request->boolean('is_featured', false);

        $product = null;

        try {
            DB::transaction(function () use ($request, &$validated, &$product) {
                $product = Product::create($validated);

                // Upload each image via the centralized service. Any failure
                // rolls back the DB insert + deletes any partial uploads.
                if ($request->hasFile('images')) {
                    $folder = config('upload.disks.folders.product', 'products');
                    $paths  = $this->images->uploadMany(
                        $request->file('images'),
                        $folder,
                        'product_images'
                    );

                    foreach ($paths as $index => $path) {
                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_path' => $path,
                            'sort_order' => $index,
                            'is_primary' => $index === 0,
                        ]);
                    }
                }
            });
        } catch (\Throwable $e) {
            // uploadMany() guarantees either all succeed or it throws BEFORE
            // writing, but if Product::create() fails after we already saved
            // files we still need to clean up. Rollback handler above deletes
            // any DB rows; cleanup of files happens defensively.
            if ($product) {
                foreach ($product->productImages()->get() as $img) {
                    $this->images->delete($img->image_path);
                }
            }
            throw $e;
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Tạo sản phẩm thành công');
    }

    public function edit(Product $product)
    {
        $product->load('productImages');
        $categories = Category::active()->orderBy('name')->get();
        $maxImages  = (int) config('upload.limits.product_images.max_count', 10);

        return view('admin.products.edit', compact('product', 'categories', 'maxImages'));
    }

    public function update(Request $request, Product $product)
    {
        $maxKb  = (int) config('upload.limits.product_images.max_size', 2048);
        $maxCnt = (int) config('upload.limits.product_images.max_count', 10);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'sku'         => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
            'is_featured' => 'boolean',
            'images'      => "nullable|array|max:{$maxCnt}",
            'images.*'    => "file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
            'delete_images'   => 'nullable|array',
            'delete_images.*' => 'exists:product_images,id',
            'primary_image'   => 'nullable|exists:product_images,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active']   = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        $deletedPaths = [];
        $newPaths = [];

        try {
            DB::transaction(function () use ($request, $product, &$validated, &$deletedPaths, &$newPaths) {
                $product->update($validated);

                // ---- Delete marked images (files + DB rows in one tx) ----
                if ($request->has('delete_images')) {
                    foreach ($request->input('delete_images') as $imageId) {
                        $image = ProductImage::find($imageId);
                        // Ownership check: never delete another product's photo.
                        if ($image && $image->product_id === $product->id) {
                            $deletedPaths[] = $image->image_path;
                            $image->delete();
                        }
                    }
                }

                // ---- Add new images ----
                if ($request->hasFile('images')) {
                    $folder = config('upload.disks.folders.product', 'products');
                    $paths  = $this->images->uploadMany(
                        $request->file('images'),
                        $folder,
                        'product_images'
                    );

                    $maxSortOrder = $product->productImages()->max('sort_order') ?? -1;
                    $currentCount = $product->productImages()->count();

                    foreach ($paths as $i => $path) {
                        $newPaths[] = $path;
                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_path' => $path,
                            'sort_order' => $maxSortOrder + $i + 1,
                            // First image becomes primary only if no images
                            // remain after deletion.
                            'is_primary' => $currentCount === 0 && $i === 0,
                        ]);
                    }
                }

                // ---- Set primary image (single source of truth) ----
                if ($request->filled('primary_image')) {
                    $primaryId = (int) $request->input('primary_image');
                    $primary   = ProductImage::find($primaryId);
                    if ($primary && $primary->product_id === $product->id) {
                        ProductImage::where('product_id', $product->id)
                            ->update(['is_primary' => false]);
                        $primary->update(['is_primary' => true]);
                    }
                }
            });
        } catch (\Throwable $e) {
            // Rollback already happened. Clean up any files we wrote before
            // the transaction failed.
            foreach (array_merge($deletedPaths, $newPaths) as $p) {
                $this->images->delete($p);
            }
            throw $e;
        }

        // Files for deleted images are removed *after* the transaction so we
        // only touch disk when the DB write succeeded. Failures here are
        // non-fatal (orphan file is better than orphan DB row).
        foreach ($deletedPaths as $path) {
            $this->images->delete($path);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Cập nhẩt sản phẩm thành công');
    }

    public function destroy(Product $product)
    {
        // Capture paths so we can clean up after the DB delete commits.
        $paths = $product->productImages->pluck('image_path')->all();

        $product->delete();

        foreach ($paths as $path) {
            $this->images->delete($path);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Xóa sản phẩm thành công');
    }
}