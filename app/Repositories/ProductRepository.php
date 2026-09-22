<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Product Repository
 * 
 * Handles:
 * - Product search and filtering
 * - Category and subcategory filtering
 * - Price range filtering
 * - Stock filtering
 * - Sorting (featured, best-selling, etc)
 */
class ProductRepository extends BaseRepository
{
    protected function getModel(): string
    {
        return Product::class;
    }

    protected function getSearchFields(): array
    {
        return ['name', 'description', 'short_description'];
    }

    /**
     * Filter by category
     */
    public function byCategory(int $categoryId): self
    {
        return $this->setQuery($this->newQuery()->where('category_id', $categoryId));
    }

    /**
     * Filter by categories (multiple)
     */
    public function byCategories(array $categoryIds): self
    {
        return $this->setQuery($this->newQuery()->whereIn('category_id', $categoryIds));
    }

    /**
     * Filter by subcategory
     */
    public function bySubcategory(int $subcategoryId): self
    {
        return $this->setQuery($this->newQuery()->where('subcategory_id', $subcategoryId));
    }

    /**
     * Filter by subcategories (multiple)
     */
    public function bySubcategories(array $subcategoryIds): self
    {
        return $this->setQuery($this->newQuery()->whereIn('subcategory_id', $subcategoryIds));
    }

    /**
     * Filter by price range
     */
    public function priceRange(?float $minPrice, ?float $maxPrice): self
    {
        $query = $this->query();

        if ($minPrice !== null) {
            $query = $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query = $query->where('price', '<=', $maxPrice);
        }

        $this->model = $query;
        return $this;
    }

    /**
     * Filter by stock availability
     */
    public function inStock(): self
    {
        return $this->setQuery($this->newQuery()->where('stock', '>', 0));
    }

    /**
     * Filter out of stock
     */
    public function outOfStock(): self
    {
        return $this->setQuery($this->newQuery()->where('stock', '<=', 0));
    }

    /**
     * Filter featured products
     */
    public function featured(): self
    {
        return $this->setQuery($this->newQuery()->where('is_featured', true));
    }

    /**
     * Get best-selling products
     */
    public function bestSelling(int $limit = 10): Collection
    {
        return $this->query()
            ->where('is_active', true)
            ->orderBy('sold_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get new products
     */
    public function newProducts(int $limit = 10): Collection
    {
        return $this->query()
            ->where('is_active', true)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get product with relations
     */
    public function getWithRelations(int $id): ?Product
    {
        return $this->query()
            ->with(['category', 'subcategory', 'productImages', 'variants'])
            ->find($id);
    }

    /**
     * Search and filter combined
     */
    public function searchAndFilter(array $options = []): LengthAwarePaginator
    {
        return $this->getFiltered($options);
    }

    /**
     * Get available products for selection
     */
    public function selectOptions(): Collection
    {
        return $this->query()
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');
    }
}
