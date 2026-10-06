<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    public function getProducts(Request $request)
    {
        $validated = $request->validate([
            'type' => ['nullable', 'in:best-selling,new-arrival,category'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:24'],
        ]);
        $type = $validated['type'] ?? 'best-selling';
        $categoryId = $validated['category_id'] ?? null;
        $limit = $validated['limit'] ?? 8;
        $user = auth()->user();

        $products = match ($type) {
            'best-selling' => $this->productService->getBestSellingProducts($limit, $categoryId, $user),
            'new-arrival' => $this->productService->getNewArrivalProducts($limit, $categoryId, $user),
            'category' => $categoryId ? $this->productService->getProductsByCategory($categoryId, $limit, $user) : collect(),
        };

        return ProductResource::collection($products)->additional(['success' => true]);
    }
}
