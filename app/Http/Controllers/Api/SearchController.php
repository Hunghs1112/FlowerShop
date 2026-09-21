<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    /**
     * Autocomplete search - returns products matching the query
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function autocomplete(Request $request): JsonResponse
    {
        $query = $request->input('q', '');
        
        // Minimum 2 characters for search
        if (strlen(trim($query)) < 2) {
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Query too short',
            ]);
        }
        
        // Sanitize query
        $query = trim(preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $query));
        
        // Limit query length
        if (strlen($query) > 255) {
            $query = mb_substr($query, 0, 255);
        }
        
        // CRITICAL: Pass authenticated user for VIP filtering
        $user = auth()->user();
        
        try {
            $results = $this->productService->autocomplete($query, 8, $user);
            
            return response()->json([
                'success' => true,
                'data' => $results,
                'count' => count($results),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Search error',
                'data' => [],
            ], 500);
        }
    }

    /**
     * Full search with pagination
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q', '');
        
        // Minimum 2 characters for search
        if (strlen(trim($query)) < 2) {
            return response()->json([
                'success' => true,
                'data' => [],
            ]);
        }
        
        // Sanitize
        $query = trim(preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $query));
        
        // Limit query length
        if (strlen($query) > 255) {
            $query = mb_substr($query, 0, 255);
        }
        
        // CRITICAL: Pass authenticated user for VIP filtering
        $user = auth()->user();
        
        try {
            $products = $this->productService->search($query, 20, false, $user);
            
            $data = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'formatted_price' => number_format($product->price, 0, ',', '.') . 'đ',
                    'short_description' => $product->short_description,
                    'image' => $product->productImages->first()?->image_url ?? asset('storage/placeholder.jpg'),
                    'category' => $product->category?->name,
                    'url' => route('products.show', $product->slug),
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'count' => $data->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Search error',
                'data' => [],
            ], 500);
        }
    }
}
