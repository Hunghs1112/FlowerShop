<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductVariantRequest;
use App\Http\Requests\UpdateProductVariantRequest;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantImage;
use App\Repositories\ProductVariantRepository;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    protected ProductVariantRepository $variants;
    protected ImageStorageService $images;

    public function __construct(
        ProductVariantRepository $variants,
        ImageStorageService $images
    ) {
        $this->variants = $variants;
        $this->images = $images;
        
    }

    public function index(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $variants = $this->variants->getActiveForProduct($productId);
        
        // If AJAX request, return JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'variants' => $variants->map(function ($variant) {
                    return [
                        'id' => $variant->id,
                        'sku' => $variant->sku,
                        'name' => $variant->name,
                        'description' => $variant->description,
                        'color' => $variant->color,
                        'size' => $variant->size,
                        'price' => $variant->price,
                        'compare_at_price' => $variant->compare_at_price,
                        'stock' => $variant->stock,
                        'weight' => $variant->weight,
                        'dimensions' => $variant->dimensions,
                        'is_active' => $variant->is_active,
                        'sort_order' => $variant->sort_order,
                        'primary_image_url' => $variant->getPrimaryImageUrl(),
                        'images_count' => $variant->images()->count(),
                    ];
                })
            ]);
        }

        return view('admin.products.variants.index', compact('product', 'variants'));
    }

    public function create($productId)
    {
        $product = Product::findOrFail($productId);
        
        return view('admin.products.variants.create', compact('product'));
    }

    public function store(StoreProductVariantRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validated = $request->validated();
        $validated['product_id'] = $productId;
        $validated['is_active'] = $request->boolean('is_active', false);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $variant = $this->variants->create($validated);

        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('variants', 'public');
                
                ProductVariantImage::create([
                    'product_variant_id' => $variant->id,
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        // If AJAX request, return JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Variant đã được tạo thành công!',
                'variant' => [
                    'id' => $variant->id,
                    'sku' => $variant->sku,
                    'name' => $variant->name,
                    'description' => $variant->description,
                    'color' => $variant->color,
                    'size' => $variant->size,
                    'price' => $variant->price,
                    'stock' => $variant->stock,
                    'is_active' => $variant->is_active,
                    'primary_image_url' => $variant->getPrimaryImageUrl(),
                    'images_count' => $variant->images()->count(),
                ]
            ], 201);
        }

        return redirect()
            ->route('admin.products.variants.index', $productId)
            ->with('success', 'Variant đã được tạo thành công!');
    }

    public function edit($productId, $id)
    {
        $product = Product::findOrFail($productId);

        $variant = ProductVariant::where('product_id', $productId)->findOrFail($id);
        
        return view('admin.products.variants.edit', compact('product', 'variant'));
    }

    public function update(UpdateProductVariantRequest $request, $productId, $id)
    {
        $product = Product::findOrFail($productId);

        $variant = ProductVariant::where('product_id', $productId)->findOrFail($id);
        
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active', false);

        $variant->update($validated);

        // Delete selected images
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = ProductVariantImage::find($imageId);
                if ($image && $image->product_variant_id == $variant->id) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        // Add new images
        if ($request->hasFile('images')) {
            $maxOrder = $variant->images()->max('sort_order') ?? -1;
            
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('variants', 'public');
                
                ProductVariantImage::create([
                    'product_variant_id' => $variant->id,
                    'image_path' => $path,
                    'sort_order' => $maxOrder + $index + 1,
                ]);
            }
        }

        // If AJAX request, return JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Variant đã được cập nhật thành công!',
                'variant' => [
                    'id' => $variant->id,
                    'sku' => $variant->sku,
                    'name' => $variant->name,
                    'description' => $variant->description,
                    'color' => $variant->color,
                    'size' => $variant->size,
                    'price' => $variant->price,
                    'stock' => $variant->stock,
                    'is_active' => $variant->is_active,
                    'compare_at_price' => $variant->compare_at_price,
                    'weight' => $variant->weight,
                    'dimensions' => $variant->dimensions,
                    'sort_order' => $variant->sort_order,
                    'primary_image_url' => $variant->getPrimaryImageUrl(),
                    'images_count' => $variant->images()->count(),
                ]
            ]);
        }

        return redirect()
            ->route('admin.products.variants.index', $productId)
            ->with('success', 'Variant đã được cập nhật thành công!');
    }

    public function destroy(Request $request, $productId, $id)
    {
        $product = Product::findOrFail($productId);

        $variant = ProductVariant::where('product_id', $productId)->findOrFail($id);
        
        // Delete all images
        foreach ($variant->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
        
        $this->variants->delete($variant->id);

        // If AJAX request, return JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Variant đã được xóa thành công!'
            ]);
        }

        return redirect()
            ->route('admin.products.variants.index', $productId)
            ->with('success', 'Variant đã được xóa thành công!');
    }

    public function uploadImages(Request $request, $productId, $variantId)
    {
        $product = Product::findOrFail($productId);

        $variant = ProductVariant::where('product_id', $productId)->findOrFail($variantId);
        
        $validated = $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $uploaded = [];

        if ($request->hasFile('images')) {
            $maxOrder = $variant->images()->max('sort_order') ?? -1;
            
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('variants', 'public');
                
                $variantImage = ProductVariantImage::create([
                    'product_variant_id' => $variant->id,
                    'image_path' => $path,
                    'sort_order' => $maxOrder + $index + 1,
                ]);
                
                $uploaded[] = [
                    'id' => $variantImage->id,
                    'image_url' => $variantImage->image_url,
                    'sort_order' => $variantImage->sort_order,
                ];
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Ảnh đã được upload thành công!',
                'images' => $uploaded,
                'count' => count($uploaded),
            ], 201);
        }

        return redirect()
            ->route('admin.products.variants.index', $productId)
            ->with('success', 'Ảnh đã được upload thành công!');
    }
}
