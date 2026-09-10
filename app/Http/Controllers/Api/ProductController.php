<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    /**
     * Get products by type (best-selling, new-arrival, category)
     */
    public function getProducts(Request $request): JsonResponse
    {
        $type = $request->input('type', 'best-selling');
        $categoryId = $request->input('category_id');
        $limit = $request->input('limit', 8);

        $products = match($type) {
            'best-selling' => $this->productService->getBestSellingProducts($limit, $categoryId),
            'new-arrival' => $this->productService->getNewArrivalProducts($limit, $categoryId),
            'category' => $categoryId 
                ? $this->productService->getProductsByCategory($categoryId, $limit)
                : collect([]),
            default => $this->productService->getBestSellingProducts($limit, $categoryId),
        };

        return response()->json([
            'success' => true,
            'data' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'formatted_price' => number_format($product->price, 0, ',', '.') . 'đ',
                    'short_description' => $product->short_description,
                    'image' => $product->productImages->first()?->image_url ?? asset('storage/placeholder.jpg'),
                    'secondary_image' => $product->productImages->count() > 1 ? $product->productImages[1]->image_url : null,
                    'category' => $product->category?->name,
                    'url' => route('products.show', $product),
                ];
            }),
        ]);
    }
}
