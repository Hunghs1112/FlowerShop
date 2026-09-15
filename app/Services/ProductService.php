<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ProductService
{
    /**
     * Get featured products
     */
    public function getFeaturedProducts(int $limit = 8): Collection
    {
        return Product::active()
            ->featured()
            ->with(['productImages', 'category'])
            ->inStock()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get best selling products
     */
    public function getBestSellingProducts(int $limit = 8, ?int $categoryId = null): Collection
    {
        $query = Product::active()
            ->bestSelling()
            ->with(['productImages', 'category'])
            ->inStock();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return $query->limit($limit)->get();
    }

    /**
     * Get new arrival products
     */
    public function getNewArrivalProducts(int $limit = 8, ?int $categoryId = null): Collection
    {
        $query = Product::active()
            ->newArrival()
            ->with(['productImages', 'category'])
            ->inStock();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return $query->limit($limit)->get();
    }

    /**
     * Get products by category
     */
    public function getProductsByCategory(int $categoryId, int $limit = 8): Collection
    {
        return Product::active()
            ->where('category_id', $categoryId)
            ->with(['productImages', 'category'])
            ->inStock()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Filter and paginate products with search and filter support
     * 
     * @param array $filters Filter options including:
     *   - category_ids: array of category IDs
     *   - min_price: minimum price
     *   - max_price: maximum price
     *   - search: search term (sanitized)
     *   - sort_by: sort option (latest, price_asc, price_desc, best_selling, name)
     *   - in_stock: boolean
     *   - per_page: items per page
     * @return LengthAwarePaginator
     */
    public function filterProducts(array $filters = []): LengthAwarePaginator
    {
        $query = Product::active()
            ->with(['productImages', 'category']);

        // Category filter - include child categories if needed
        if (!empty($filters['category_ids'])) {
            // Optionally include child categories
            if (!empty($filters['include_child_categories'])) {
                $categoryIds = $this->getCategoryWithDescendants($filters['category_ids']);
                $query->whereIn('category_id', $categoryIds);
            } else {
                $query->whereIn('category_id', $filters['category_ids']);
            }
        }

        // Price range filter
        if (isset($filters['min_price']) && is_numeric($filters['min_price']) && $filters['min_price'] > 0) {
            $query->where('price', '>=', (float) $filters['min_price']);
        }
        if (isset($filters['max_price']) && is_numeric($filters['max_price']) && $filters['max_price'] > 0) {
            $query->where('price', '<=', (float) $filters['max_price']);
        }

        // Stock filter
        if (!empty($filters['in_stock'])) {
            $query->inStock();
        }

        // Search filter - uses the model's search scope for safety
        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        // Sort
        $sortBy = $filters['sort_by'] ?? 'latest';
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'best_selling':
                $query->orderBy('sales_count', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'latest':
            default:
                // Check if there's a latest_arrival_date for true "newest" sorting
                $query->latest();
                break;
        }

        return $query->paginate($filters['per_page'] ?? 12);
    }

    /**
     * Get all category IDs including their descendants
     */
    protected function getCategoryWithDescendants(array $categoryIds): array
    {
        $allIds = [];
        
        foreach ($categoryIds as $categoryId) {
            $category = Category::find($categoryId);
            if ($category) {
                $allIds[] = $categoryId;
                // Add descendant IDs recursively
                $allIds = array_merge($allIds, $this->getDescendantIds($category));
            }
        }
        
        return array_unique($allIds);
    }

    /**
     * Get all descendant category IDs
     */
    protected function getDescendantIds(Category $category): array
    {
        $ids = [];
        
        foreach ($category->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->getDescendantIds($child));
        }
        
        return $ids;
    }

    /**
     * Get related products
     */
    public function getRelatedProducts(Product $product, int $limit = 4): Collection
    {
        return Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['productImages'])
            ->inStock()
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /**
     * Search products with autocomplete support
     * 
     * @param string $query Search query (should be pre-sanitized)
     * @param int $limit Maximum number of results
     * @param bool $autocomplete Whether to return results optimized for autocomplete
     * @return Collection
     */
    public function search(string $query, int $limit = 20, bool $autocomplete = false): Collection
    {
        $query = trim($query);
        
        // Minimum 2 characters for search
        if (strlen($query) < 2) {
            return collect([]);
        }

        $builder = Product::active()
            ->search($query)
            ->with(['productImages', 'category']);

        // For autocomplete, limit results but keep all needed relations
        if ($autocomplete) {
            $builder->select('id', 'name', 'slug', 'price', 'short_description');
            // productImages is loaded via with() above, select() only limits base table cols
        }

        return $builder->limit($limit)->get();
    }

    /**
     * Search products optimized for autocomplete dropdown
     * Returns lighter data for faster response
     */
    public function autocomplete(string $query, int $limit = 8): array
    {
        $products = $this->search($query, $limit, true);

        return $products->map(function ($product) {
            // Load image for autocomplete (separate query to avoid bloating main select)
            $image = $product->productImages()->first()?->image_url
                ?? asset('images/products/placeholder.jpg');

            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'formatted_price' => number_format($product->price, 0, ',', '.') . 'đ',
                'image' => $image,
                'url' => route('products.show', $product->slug),
            ];
        })->toArray();
    }

    /**
     * Get product count by category
     */
    public function getCountByCategory(int $categoryId): int
    {
        return Product::active()
            ->where('category_id', $categoryId)
            ->inStock()
            ->count();
    }

    /**
     * Check if a search has results
     */
    public function hasResults(string $query): bool
    {
        return Product::active()
            ->search($query)
            ->exists();
    }

    /**
     * Get suggested categories when search returns no results
     */
    public function getSuggestedCategories(string $query, int $limit = 3): Collection
    {
        // Search in category names
        return Category::active()
            ->where('name', 'like', '%' . $query . '%')
            ->limit($limit)
            ->get();
    }

    /**
     * Get popular/recent products for "no results" suggestions
     */
    public function getSuggestionProducts(int $limit = 4): Collection
    {
        return Product::active()
            ->inStock()
            ->featured()
            ->with(['productImages'])
            ->limit($limit)
            ->get();
    }
}
