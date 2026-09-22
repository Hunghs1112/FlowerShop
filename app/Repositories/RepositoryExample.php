<?php

namespace App\Repositories;

/**
 * EXAMPLE: Using the Repository Pattern
 * 
 * This file demonstrates how to use repositories in controllers and services
 * to centralize query logic and avoid code duplication.
 */

/**
 * ============================================================================
 * BASIC USAGE IN CONTROLLER
 * ============================================================================
 * 
 * use App\Repositories\ProductRepository;
 * 
 * class ProductController extends Controller
 * {
 *     protected ProductRepository $products;
 * 
 *     public function __construct(ProductRepository $products)
 *     {
 *         $this->products = $products;
 *     }
 * 
 *     // List with pagination
 *     public function index(Request $request)
 *     {
 *         $products = $this->products->search(
 *             $request->input('search'),
 *             $request->input('per_page', 15)
 *         );
 * 
 *         return view('products.index', ['products' => $products]);
 *     }
 * }
 */

/**
 * ============================================================================
 * ADVANCED FILTERING
 * ============================================================================
 * 
 * public function filteredSearch(Request $request)
 * {
 *     $products = $this->products->getFiltered([
 *         'search' => $request->input('q'),
 *         'filters' => [
 *             'category_id' => $request->input('category'),
 *             'is_active' => true,
 *         ],
 *         'sort' => ['created_at', 'desc'],
 *         'per_page' => 20,
 *     ]);
 * 
 *     return view('products.index', ['products' => $products]);
 * }
 */

/**
 * ============================================================================
 * CHAINING FILTERS
 * ============================================================================
 * 
 * use App\Repositories\CategoryRepository;
 * 
 * public function showCategory(int $categoryId)
 * {
 *     $repo = new CategoryRepository();
 *     $category = $repo
 *         ->active()
 *         ->sort('name')
 *         ->first();
 * 
 *     // Or chain methods
 *     $categories = $repo
 *         ->active()
 *         ->sort('sort_order')
 *         ->paginate(15);
 * 
 *     return view('categories.show', compact('category', 'categories'));
 * }
 */

/**
 * ============================================================================
 * CUSTOM REPOSITORY METHODS
 * ============================================================================
 * 
 * use App\Repositories\BaseRepository;
 * use App\Models\Order;
 * 
 * class OrderRepository extends BaseRepository
 * {
 *     protected function getModel(): string
 *     {
 *         return Order::class;
 *     }
 * 
 *     protected function getSearchFields(): array
 *     {
 *         return ['order_number', 'customer_name', 'customer_email'];
 *     }
 * 
 *     // Custom method for recent orders
 *     public function recentOrders(int $days = 7)
 *     {
 *         return $this->query()
 *             ->where('created_at', '>=', now()->subDays($days))
 *             ->orderBy('created_at', 'desc')
 *             ->get();
 *     }
 * 
 *     // Custom method for high-value orders
 *     public function highValue(float $minAmount)
 *     {
 *         return $this->query()
 *             ->where('total', '>=', $minAmount)
 *             ->orderBy('total', 'desc')
 *             ->paginate();
 *     }
 * }
 */

/**
 * ============================================================================
 * IN SERVICE LAYER
 * ============================================================================
 * 
 * use App\Repositories\ProductRepository;
 * 
 * class ProductService
 * {
 *     protected ProductRepository $products;
 * 
 *     public function __construct(ProductRepository $products)
 *     {
 *         $this->products = $products;
 *     }
 * 
 *     // Get popular products
 *     public function getPopular(int $limit = 10)
 *     {
 *         return $this->products
 *             ->active()
 *             ->inStock()
 *             ->sort('sold_count', 'desc')
 *             ->get()
 *             ->take($limit);
 *     }
 * 
 *     // Get products by price range
 *     public function getByPriceRange(float $min, float $max)
 *     {
 *         return $this->products
 *             ->active()
 *             ->priceRange($min, $max)
 *             ->sort('price', 'asc')
 *             ->get();
 *     }
 * 
 *     // Search with all filters
 *     public function searchProducts(array $filters)
 *     {
 *         $repo = $this->products;
 * 
 *         if ($filters['category'] ?? null) {
 *             $repo = $repo->byCategories((array) $filters['category']);
 *         }
 * 
 *         if ($filters['min_price'] ?? null || $filters['max_price'] ?? null) {
 *             $repo = $repo->priceRange(
 *                 $filters['min_price'] ?? null,
 *                 $filters['max_price'] ?? null
 *             );
 *         }
 * 
 *         if ($filters['in_stock'] ?? false) {
 *             $repo = $repo->inStock();
 *         }
 * 
 *         return $repo->get();
 *     }
 * }
 */

/**
 * ============================================================================
 * DEPENDENCY INJECTION WITH SERVICE PROVIDER
 * ============================================================================
 * 
 * // In AppServiceProvider
 * 
 * use App\Repositories\ProductRepository;
 * use App\Repositories\CategoryRepository;
 * 
 * public function register()
 * {
 *     $this->app->bind(ProductRepository::class, function ($app) {
 *         return new ProductRepository();
 *     });
 * 
 *     $this->app->bind(CategoryRepository::class, function ($app) {
 *         return new CategoryRepository();
 *     });
 * 
 *     // Then inject in controller constructor
 * }
 */

/**
 * ============================================================================
 * QUERY INSPECTION (for debugging)
 * ============================================================================
 * 
 * // Get the built query without executing it
 * $repo = new ProductRepository();
 * $query = $repo
 *     ->active()
 *     ->byCategory(1)
 *     ->priceRange(100000, 500000);
 * 
 * // Inspect SQL
 * echo $query->toSql();      // SELECT * FROM products WHERE ...
 * 
 * // Get results
 * $results = $query->get();
 */

class RepositoryExample
{
    // This is just a demonstration file - not a real class
}
