<?php

namespace App\Services;

use App\Models\Product;
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
     * Filter and paginate products
     */
    public function filterProducts(array $filters = []): LengthAwarePaginator
    {
        $query = Product::active()
            ->with(['productImages', 'category']);

        // Category filter
        if (!empty($filters['category_ids'])) {
            $query->whereIn('category_id', $filters['category_ids']);
        }

        // Price range filter
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        // Stock filter
        if (!empty($filters['in_stock'])) {
            $query->inStock();
        }

        // Search filter
        if (!empty($filters['search'])) {
            $query->where(function (Builder $q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('short_description', 'like', '%' . $filters['search'] . '%');
            });
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
            default:
                $query->latest();
        }

        return $query->paginate($filters['per_page'] ?? 12);
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
     * Search products
     */
    public function search(string $query, int $limit = 20): Collection
    {
        return Product::active()
            ->where(function (Builder $q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('short_description', 'like', '%' . $query . '%');
            })
            ->with(['productImages', 'category'])
            ->limit($limit)
            ->get();
    }
}
