<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Responses\AjaxResponse;
use App\Models\Product;
use App\Models\ProductImage;
use App\Repositories\ProductRepository;
use App\Services\ImageStorageService;
use App\Services\AjaxFieldService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected ProductRepository $products;
    protected ImageStorageService $images;
    protected AjaxFieldService $ajaxFieldService;

    public function __construct(
        ProductRepository $products,
        ImageStorageService $images,
        AjaxFieldService $ajaxFieldService
    ) {
        $this->products = $products;
        $this->images = $images;
        $this->ajaxFieldService = $ajaxFieldService;
        
    }

    // ============================================================
    // AJAX: Update single field
    // ============================================================
    public function updateField(Request $request, Product $product)
    {

        $field = $request->input('field');
        $value = $request->input('value');

        // Define allowed fields with validation rules
        $fieldConfig = [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];

        // Use AjaxFieldService for standardized handling
        return $this->ajaxFieldService->handleAjaxFieldUpdate(
            $product,
            $field,
            $value,
            $fieldConfig,
            [
                'subcategory_id' => function ($product, $value) {
                    // Auto-assign category when subcategory changes
                    if (!empty($value)) {
                        $subcategory = \App\Models\Subcategory::find($value);
                        if ($subcategory) {
                            $product->update([
                                'subcategory_id' => $value,
                                'category_id' => $subcategory->category_id
                            ]);
                        }
                    }
                }
            ]
        );
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

        if ($field === 'videos') {
            return $this->uploadProductVideos($request, $product);
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

        // Debug logging
        \Log::info('Upload attempt', [
            'product_id' => $product->id,
            'has_images' => $request->hasFile('images'),
            'has_file' => $request->hasFile('file'),
            'all_files' => array_keys($request->allFiles()),
            'all_keys' => array_keys($request->all())
        ]);

        // Check if multiple files or single file
        $hasMultiple = $request->hasFile('images') || $request->has('images');
        $hasSingle = $request->hasFile('file');

        if ($hasMultiple) {
            try {
                $request->validate([
                    'images' => 'required|array|max:10',
                    'images.*' => "required|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}"
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                \Log::error('Validation failed', ['errors' => $e->errors()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error: ' . json_encode($e->errors())
                ], 422);
            }

            $files = $request->file('images');
            $currentCount = $product->productImages()->count();
            
            if ($currentCount + count($files) > $maxCnt) {
                return response()->json([
                    'success' => false,
                    'message' => "Tối đa {$maxCnt} ảnh (hiện có {$currentCount})"
                ], 422);
            }

            try {
                $folder = config('upload.disks.folders.product', 'products');
                $maxSortOrder = $product->productImages()->max('sort_order') ?? -1;
                $uploadedImages = [];

                foreach ($files as $index => $file) {
                    $path = $this->images->upload($file, $folder, 'product_images');

                    $image = ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'mime_type' => $file->getMimeType(),
                        'media_type' => 'image',
                        'sort_order' => $maxSortOrder + $index + 1,
                        'is_primary' => ($currentCount === 0 && $index === 0),
                    ]);

                    $uploadedImages[] = [
                        'id' => $image->id,
                        'path' => $path,
                        'url' => asset('storage/' . $path),
                        'is_primary' => $image->is_primary,
                    ];
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Đã tải lên ' . count($uploadedImages) . ' ảnh',
                    'images' => $uploadedImages
                ]);
            } catch (\Throwable $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lỗi khi tải lên: ' . $e->getMessage()
                ], 500);
            }
        } elseif ($hasSingle) {
            // Legacy single file upload
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
                    'mime_type' => $request->file('file')->getMimeType(),
                    'media_type' => 'image',
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
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy file để tải lên'
            ], 422);
        }
    }

    protected function uploadProductVideos(Request $request, Product $product)
    {
        $maxKb = (int) config('upload.limits.product_videos.max_size', 51200); // 50MB default
        $maxCnt = (int) config('upload.limits.product_videos.max_count', 5);

        $request->validate([
            'file' => "required|file|mimes:mp4,webm,mov,avi|max:{$maxKb}"
        ]);

        $currentVideoCount = $product->productImages()->where('media_type', 'video')->count();
        if ($currentVideoCount >= $maxCnt) {
            return response()->json([
                'success' => false,
                'message' => "Tối đa {$maxCnt} video"
            ], 422);
        }

        try {
            $file = $request->file('file');
            $path = $file->store('products/videos', 'public');

            $maxSortOrder = $product->productImages()->max('sort_order') ?? -1;

            $video = ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'mime_type' => $file->getMimeType(),
                'media_type' => 'video',
                'sort_order' => $maxSortOrder + 1,
                'is_primary' => false,
            ]);

            return response()->json([
                'success' => true,
                'video' => [
                    'id' => $video->id,
                    'url' => asset('storage/' . $path),
                    'mime_type' => $video->mime_type,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload thất bại: ' . $e->getMessage()
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

        // Only allow deleting images, not videos
        if ($image->media_type === 'video') {
            return response()->json([
                'success' => false,
                'message' => 'Sử dụng endpoint xóa video'
            ], 400);
        }

        $path = $image->image_path;
        $image->delete();
        $this->images->delete($path);

        // Auto-set new primary if needed
        if ($product->productImages()->where('media_type', 'image')->count() > 0 && 
            !$product->productImages()->where('is_primary', true)->exists()) {
            $firstImage = $product->productImages()->where('media_type', 'image')->orderBy('sort_order')->first();
            if ($firstImage) {
                $firstImage->update(['is_primary' => true]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa ảnh'
        ]);
    }

    // ============================================================
    // AJAX: Delete product video
    // ============================================================
    public function deleteVideo(Product $product, ProductImage $video)
    {
        if ($video->product_id !== $product->id) {
            return response()->json([
                'success' => false,
                'message' => 'Video không thuộc sản phẩm này'
            ], 403);
        }

        if ($video->media_type !== 'video') {
            return response()->json([
                'success' => false,
                'message' => 'Đây không phải video'
            ], 400);
        }

        $path = $video->image_path;
        $video->delete();
        
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa video'
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

        $filters = [
            'search' => $request->input('search'),
            'category_id' => $request->input('category_id'),
            'is_active' => $request->input('is_active'),
        ];

        $query = Product::with(['category', 'productImages']);

        if ($filters['search']) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('sku', 'like', '%' . $filters['search'] . '%');
            });
        }
        if ($filters['category_id']) {
            $query->where('category_id', $filters['category_id']);
        }
        if ($filters['is_active'] !== null) {
            $query->where('is_active', $filters['is_active']);
        }

        $products = $query->latest()->paginate(15);
        $categories = \App\Models\Category::active()->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'filters'));
    }

    public function create()
    {

        $subcategories = \App\Models\Subcategory::with('category')
            ->where('is_active', true)
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();
        
        $maxImages = (int) config('upload.limits.product_images.max_count', 10);
        
        return view('admin.products.create', compact('subcategories', 'maxImages'));
    }

    public function store(StoreProductRequest $request)
    {

        $validated = $request->validated();

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Auto-assign category from subcategory
        if (isset($validated['subcategory_id'])) {
            $subcategory = \App\Models\Subcategory::find($validated['subcategory_id']);
            if ($subcategory) {
                $validated['category_id'] = $subcategory->category_id;
            }
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_featured'] = $request->boolean('is_featured', false);

        $product = null;

        try {
            DB::transaction(function () use ($request, &$validated, &$product) {
                $product = $this->products->create($validated);

                // Upload images
                if ($request->hasFile('images')) {
                    $folder = config('upload.disks.folders.product', 'products');
                    $paths = $this->images->uploadMany(
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
        
        $subcategories = \App\Models\Subcategory::with('category')
            ->where('is_active', true)
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();
        
        $maxImages = (int) config('upload.limits.product_images.max_count', 10);

        return view('admin.products.edit', compact('product', 'subcategories', 'maxImages'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {

        $validated = $request->validated();

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Auto-assign category from subcategory
        if (isset($validated['subcategory_id'])) {
            $subcategory = \App\Models\Subcategory::find($validated['subcategory_id']);
            if ($subcategory) {
                $validated['category_id'] = $subcategory->category_id;
            }
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        $deletedPaths = [];
        $newPaths = [];

        try {
            DB::transaction(function () use ($request, $product, &$validated, &$deletedPaths, &$newPaths) {
                $product->update($validated);

                // Delete marked images
                if ($request->has('delete_images')) {
                    foreach ($request->input('delete_images') as $imageId) {
                        $image = ProductImage::find($imageId);
                        if ($image && $image->product_id === $product->id) {
                            $deletedPaths[] = $image->image_path;
                            $image->delete();
                        }
                    }
                }

                // Add new images
                if ($request->hasFile('images')) {
                    $folder = config('upload.disks.folders.product', 'products');
                    $paths = $this->images->uploadMany(
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
                            'is_primary' => $currentCount === 0 && $i === 0,
                        ]);
                    }
                }

                // Set primary image
                if ($request->filled('primary_image')) {
                    $primaryId = (int) $request->input('primary_image');
                    $primary = ProductImage::find($primaryId);
                    if ($primary && $primary->product_id === $product->id) {
                        ProductImage::where('product_id', $product->id)
                            ->update(['is_primary' => false]);
                        $primary->update(['is_primary' => true]);
                    }
                }
            });
        } catch (\Throwable $e) {
            foreach (array_merge($deletedPaths, $newPaths) as $p) {
                $this->images->delete($p);
            }
            throw $e;
        }

        // Clean up deleted image files after transaction commits
        foreach ($deletedPaths as $path) {
            $this->images->delete($path);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công');
    }

    public function destroy(Product $product)
    {

        $paths = $product->productImages->pluck('image_path')->all();
        $product->delete();

        foreach ($paths as $path) {
            $this->images->delete($path);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Xóa sản phẩm thành công');
    }
}