<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService,
        protected ProductService $productService
    ) {}

    public function index()
    {
        $categories = Category::active()
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $bannerKey = 'categories';

        return view('categories.index', compact('categories', 'bannerKey'));
    }

    public function show(string $slug, Request $request)
    {
        // Support both EN and VI slugs
        $category = Category::where('slug', $slug)
            ->orWhere('slug_en', $slug)
            ->active()
            ->with(['children'])
            ->firstOrFail();

        // Get all descendant category IDs for filtering
        $categoryIds = $this->categoryService->getDescendantIds($category);

        // CRITICAL: Pass authenticated user for VIP filtering
        $user = auth()->user();

        $filters = [
            'category_ids' => $categoryIds,
            'subcategory_ids' => $request->input('subcategories', []),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'in_stock' => $request->boolean('in_stock'),
            'search' => $request->input('q') ?: $request->input('search'),
            'sort_by' => $request->input('sort_by', 'latest'),
            'per_page' => 12,
            'user' => $user,
        ];

        $products = $this->productService->filterProducts($filters);
        $breadcrumb = $this->categoryService->getBreadcrumb($category);

        // Get all categories for filter sidebar
        $categories = $this->categoryService->getActiveCategories();
        
        // Get subcategories with product counts
        $subcategories = \App\Models\Subcategory::where('is_active', true)
            ->with('category')
            ->withCount('products')
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();

        // Get active filter chips
        $activeFilterChips = $this->getActiveFilterChips($request, $categoryIds, $category);

        $bannerKey = 'categories';
        $activeCategory = $category;
        $bannerImage = $category->banner_image ? $category->banner_image_url : null;

        return view('products.index', compact(
            'category', 
            'products', 
            'breadcrumb', 
            'filters', 
            'bannerKey',
            'categories',
            'subcategories',
            'activeCategory',
            'bannerImage',
            'activeFilterChips'
        ));
    }

    /**
     * Get active filter chips for category page
     */
    protected function getActiveFilterChips(Request $request, array $categoryIds, Category $category): array
    {
        $chips = [];
        
        // Add the current category as a filter chip
        $chips[] = [
            'type' => 'category',
            'label' => $category->display_name,
            'value' => $category->id,
            'param' => 'categories',
        ];
        
        // Search query
        $searchQuery = $request->input('q') ?: $request->input('search');
        if ($searchQuery) {
            $chips[] = [
                'type' => 'search',
                'label' => 'Tìm: "' . e($searchQuery) . '"',
                'value' => $searchQuery,
                'param' => 'q',
            ];
        }
        
        // Subcategories
        $subcategoryIds = $request->input('subcategories', []);
        if (!empty($subcategoryIds)) {
            $subcategories = \App\Models\Subcategory::whereIn('id', $subcategoryIds)->with('category')->get();
            foreach ($subcategories as $subcategory) {
                $chips[] = [
                    'type' => 'subcategory',
                    'label' => $subcategory->category->name . ' → ' . $subcategory->name,
                    'value' => $subcategory->id,
                    'param' => 'subcategories',
                ];
            }
        }
        
        // Price range
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        
        if ($minPrice !== null || $maxPrice !== null) {
            $label = '';
            if ($minPrice !== null && $maxPrice !== null) {
                $label = number_format($minPrice / 1000, 0, ',', '.') . 'K - ' 
                       . number_format($maxPrice / 1000, 0, ',', '.') . 'K';
            } elseif ($minPrice !== null) {
                $label = 'Từ ' . number_format($minPrice / 1000, 0, ',', '.') . 'K';
            } else {
                $label = 'Đến ' . number_format($maxPrice / 1000, 0, ',', '.') . 'K';
            }
            $chips[] = [
                'type' => 'price',
                'label' => $label,
                'value' => 'custom',
                'param' => 'price',
            ];
        }
        
        // In stock filter
        if ($request->boolean('in_stock')) {
            $chips[] = [
                'type' => 'stock',
                'label' => 'Còn hàng',
                'value' => '1',
                'param' => 'in_stock',
            ];
        }
        
        return $chips;
    }
}
