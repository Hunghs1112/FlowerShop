<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    public function index(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $variants = $product->variants()->orderBy('sort_order')->get();
        
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

    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        $validated = $request->validate([
            'sku' => 'required|string|max:100|unique:product_variants,sku',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:50',
            'price' => 'nullable|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['product_id'] = $productId;
        $validated['is_active'] = $request->input('is_active', 0) ? 1 : 0;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $variant = ProductVariant::create($validated);

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

    public function update(Request $request, $productId, $id)
    {
        $product = Product::findOrFail($productId);
        $variant = ProductVariant::where('product_id', $productId)->findOrFail($id);
        
        $validated = $request->validate([
            'sku' => 'required|string|max:100|unique:product_variants,sku,' . $id,
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:50',
            'price' => 'nullable|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:product_variant_images,id',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

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
        
        $variant->delete();

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
}
