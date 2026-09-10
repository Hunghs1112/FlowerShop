<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected CategoryService $categoryService
    ) {}

    public function index(Request $request)
    {
        // Resolve category IDs from various input formats:
        // - ?categories[]=1&categories[]=2  (array of IDs — from filter sidebar)
        // - ?category=some-slug             (single slug — from navbar/footer links)
        $categoryIds = $request->input('categories', []);

        if (empty($categoryIds) && $request->filled('category')) {
            $slugOrId = $request->input('category');
            $found = \App\Models\Category::active()
                ->where('slug', $slugOrId)
                ->orWhere('id', is_numeric($slugOrId) ? $slugOrId : 0)
                ->first();
            if ($found) {
                $categoryIds = [$found->id];
            }
        }

        // Map sort_by values from the sort dropdown to the service's expected keys
        $sortMap = [
            'newest'     => 'latest',
            'bestseller' => 'best_selling',
            'price-asc'  => 'price_asc',
            'price-desc' => 'price_desc',
            'default'    => 'latest',
        ];
        $rawSort = $request->input('sort_by', 'latest');
        $sortBy = $sortMap[$rawSort] ?? $rawSort;

        // Map price range aliases to actual min/max values
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        if ($request->filled('price_range')) {
            switch ($request->input('price_range')) {
                case 'under-500k':  $maxPrice = 500000; break;
                case '500k-1m':     $minPrice = 500000;  $maxPrice = 1000000; break;
                case '1m-2m':       $minPrice = 1000000; $maxPrice = 2000000; break;
                case 'over-2m':     $minPrice = 2000000; break;
            }
        }

        $filters = [
            'category_ids' => $categoryIds,
            'min_price'    => $minPrice,
            'max_price'    => $maxPrice,
            'in_stock'     => $request->boolean('in_stock'),
            'search'       => $request->input('search'),
            'sort_by'      => $sortBy,
            'per_page'     => 12,
        ];

        $products   = $this->productService->filterProducts($filters);
        $categories = $this->categoryService->getActiveCategories();

        // Active category for display in hero
        $activeCategory = null;
        if (!empty($categoryIds)) {
            $activeCategory = \App\Models\Category::find($categoryIds[0]);
        }

        return view('products.index', compact('products', 'categories', 'filters', 'activeCategory'));
    }

    public function show(string $identifier)
    {
        // Try to find by ID first (if numeric), otherwise by slug (EN or VI)
        if (is_numeric($identifier)) {
            $product = Product::where('id', $identifier)
                ->active()
                ->with(['productImages', 'category'])
                ->firstOrFail();
        } else {
            // Support both EN and VI slugs
            $product = Product::where('slug', $identifier)
                ->orWhere('slug_en', $identifier)
                ->active()
                ->with(['productImages', 'category'])
                ->firstOrFail();
        }

        // Get recommended products (same category or featured)
        $recommendedProducts = Product::active()
            ->inStock()
            ->where('id', '!=', $product->id)
            ->where(function($query) use ($product) {
                $query->where('category_id', $product->category_id)
                      ->orWhere('is_featured', true);
            })
            ->with('productImages')
            ->limit(4)
            ->get();

        // Get recently viewed or random products
        $recentlyViewed = Product::active()
            ->inStock()
            ->where('id', '!=', $product->id)
            ->with('productImages')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('products.detail', compact('product', 'recommendedProducts', 'recentlyViewed'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');
        
        if (strlen($query) < 2) {
            return response()->json(['products' => []]);
        }

        $products = $this->productService->search($query, 10);

        return response()->json(['products' => $products]);
    }
}
