<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterProductRequest;
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

    /**
     * Display product listing with filters and search
     */
    public function index(FilterProductRequest $request)
    {
        // Build filters array from validated request
        $filters = [
            'category_ids' => $request->getCategoryIds(),
            'subcategory_ids' => $request->input('subcategories', []),
            'min_price' => $request->getPriceRange()['min'],
            'max_price' => $request->getPriceRange()['max'],
            'in_stock' => $request->boolean('in_stock'),
            'search' => $request->getSearchQuery(),
            'sort_by' => $request->getSortOption(),
            'per_page' => 12,
            'user' => auth()->user(), // Pass authenticated user for VIP filtering
        ];

        // Get filtered products
        $products = $this->productService->filterProducts($filters);
        
        // Get categories for filter sidebar with product counts
        $categories = $this->categoryService->getActiveCategories();
        
        // Get subcategories with product counts
        $subcategories = \App\Models\Subcategory::where('is_active', true)
            ->with('category')
            ->withCount('products')
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();
        
        // Active category for display in hero
        $activeCategory = null;
        $categoryIds = $filters['category_ids'];
        if (!empty($categoryIds)) {
            $activeCategory = \App\Models\Category::find($categoryIds[0]);
        }
        
        // Get active filter chips for display
        $activeFilterChips = $request->getActiveFilterChips();
        
        // Check if this is an AJAX request for autocomplete results
        if ($request->wantsJson() && $request->has('autocomplete')) {
            return response()->json([
                'success' => true,
                'data' => $this->productService->autocomplete($request->getSearchQuery() ?? ''),
            ]);
        }

        // Get banner image for the page
        $bannerImage = null;
        if ($activeCategory && $activeCategory->banner_image) {
            // Use category banner if available
            $bannerImage = $activeCategory->banner_image_url;
        }

        return view('products.index', compact(
            'products', 
            'categories',
            'subcategories',
            'filters', 
            'activeCategory', 
            'bannerImage',
            'activeFilterChips'
        ));
    }

    /**
     * Display a single product
     */
    public function show(string $identifier)
    {
        // A numeric slug is valid (for example, a product named "123").
        // Prefer an ID match for legacy links, then fall back to either slug.
        $product = Product::where(function ($query) use ($identifier) {
                if (is_numeric($identifier)) {
                    $query->where('id', $identifier);
                }

                $query->orWhere('slug', $identifier)
                    ->orWhere('slug_en', $identifier);
            })
            ->active()
            ->with(['productImages', 'category', 'subcategory.category', 'variants' => function($query) {
                $query->where('is_active', true)->with('images');
            }])
            ->firstOrFail();

        // CRITICAL: Backend VIP authorization check
        $user = auth()->user();
        if ($user && $user->vip_level_id) {
            // Check if user's VIP level has access to this product
            $hasAccess = $product->vipLevels()->where('vip_levels.id', $user->vip_level_id)->exists();
            if (!$hasAccess) {
                abort(404); // Product not found for this VIP level
            }
        }

        // Get recommended products (same subcategory first, then same category, or featured)
        $recommendedQuery = Product::active()
            ->inStock()
            ->where('id', '!=', $product->id)
            ->where(function($query) use ($product) {
                if ($product->subcategory_id) {
                    // Prioritize same subcategory
                    $query->where('subcategory_id', $product->subcategory_id);
                } else {
                    // Fall back to category or featured
                    $query->where('category_id', $product->category_id)
                          ->orWhere('is_featured', true);
                }
            })
            ->with('productImages');

        // Apply VIP filtering to recommended products
        if ($user) {
            $recommendedQuery->visibleToUser($user);
        }

        $recommendedProducts = $recommendedQuery->limit(4)->get();

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

    /**
     * API endpoint for product search (autocomplete)
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        
        // Minimum 2 characters
        if (strlen($query) < 2) {
            return response()->json(['products' => []]);
        }
        
        // Sanitize
        $query = trim(preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $query));
        
        $products = $this->productService->search($query, 10);

        return response()->json(['products' => $products]);
    }
}
