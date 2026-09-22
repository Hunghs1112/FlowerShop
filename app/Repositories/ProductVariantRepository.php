<?php

namespace App\Repositories;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Collection;

/**
 * ProductVariant Repository
 * 
 * Handles:
 * - Product variant search and filtering
 * - Product-based queries
 * - Stock filtering
 * - Color/size filtering
 * - Active/inactive filtering
 * - Price range queries
 */
class ProductVariantRepository extends BaseRepository
{
    protected function getModel(): string
    {
        return ProductVariant::class;
    }

    protected function getSearchFields(): array
    {
        return ['name', 'sku', 'description', 'short_description'];
    }

    /**
     * Filter by product
     */
    public function byProduct(int $productId): self
    {
        return $this->setQuery($this->newQuery()->where('product_id', $productId));
    }

    /**
     * Filter by multiple products
     */
    public function byProducts(array $productIds): self
    {
        return $this->setQuery($this->newQuery()->whereIn('product_id', $productIds));
    }

    /**
     * Get variants with product relationship
     */
    public function withProduct(): self
    {
        return $this->setQuery($this->newQuery()->with('product'));
    }

    /**
     * Get variants with product and images
     */
    public function withRelations(): self
    {
        return $this->setQuery($this->newQuery()->with(['product', 'images']));
    }

    /**
     * Filter by stock status (in stock)
     */
    public function inStock(): self
    {
        return $this->setQuery($this->newQuery()->where('stock', '>', 0));
    }

    /**
     * Filter by stock status (out of stock)
     */
    public function outOfStock(): self
    {
        return $this->setQuery($this->newQuery()->where('stock', '<=', 0));
    }

    /**
     * Filter by low stock threshold
     */
    public function lowStock(int $threshold = 10): self
    {
        return $this->setQuery($this->newQuery()
            ->where('stock', '>', 0)
            ->where('stock', '<=', $threshold));
    }

    /**
     * Filter by color
     */
    public function byColor(string $color): self
    {
        return $this->setQuery($this->newQuery()->where('color', $color));
    }

    /**
     * Filter by multiple colors
     */
    public function byColors(array $colors): self
    {
        return $this->setQuery($this->newQuery()->whereIn('color', $colors));
    }

    /**
     * Filter by size
     */
    public function bySize(string $size): self
    {
        return $this->setQuery($this->newQuery()->where('size', $size));
    }

    /**
     * Filter by multiple sizes
     */
    public function bySizes(array $sizes): self
    {
        return $this->setQuery($this->newQuery()->whereIn('size', $sizes));
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
     * Get active variants only
     */
    public function activeOnly(): self
    {
        return $this->setQuery($this->newQuery()->where('is_active', true));
    }

    /**
     * Get inactive variants
     */
    public function inactiveOnly(): self
    {
        return $this->setQuery($this->newQuery()->where('is_active', false));
    }

    /**
     * Sort by sort order
     */
    public function bySortOrder(): self
    {
        return $this->setQuery($this->newQuery()->orderBy('sort_order', 'asc'));
    }

    /**
     * Get variants with images
     */
    public function getWithImages(int $id): ?ProductVariant
    {
        return $this->query()
            ->with(['product', 'images'])
            ->find($id);
    }

    /**
     * Get variants for product
     */
    public function getForProduct(int $productId): Collection
    {
        return $this->query()
            ->where('product_id', $productId)
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    /**
     * Get active variants for product
     */
    public function getActiveForProduct(int $productId): Collection
    {
        return $this->query()
            ->where('product_id', $productId)
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->with('images')
            ->get();
    }

    /**
     * Get options for select dropdown
     */
    public function selectOptions(): Collection
    {
        return $this->query()
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->pluck('name', 'id');
    }

    /**
     * Get options for select dropdown by product
     */
    public function selectOptionsForProduct(int $productId): Collection
    {
        return $this->query()
            ->where('product_id', $productId)
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->pluck('name', 'id');
    }

    /**
     * Check if variant has images
     */
    public function hasImages(int $id): bool
    {
        return $this->query()
            ->where('id', $id)
            ->has('images')
            ->exists();
    }

    /**
     * Get available colors for product
     */
    public function getColorsForProduct(int $productId): Collection
    {
        return $this->query()
            ->where('product_id', $productId)
            ->where('is_active', true)
            ->distinct()
            ->pluck('color')
            ->filter();
    }

    /**
     * Get available sizes for product
     */
    public function getSizesForProduct(int $productId): Collection
    {
        return $this->query()
            ->where('product_id', $productId)
            ->where('is_active', true)
            ->distinct()
            ->pluck('size')
            ->filter();
    }

    /**
     * Get variant by SKU
     */
    public function findBySku(string $sku): ?ProductVariant
    {
        return $this->query()->where('sku', $sku)->first();
    }

    /**
     * Search variants by SKU or name
     */
    public function searchBySKUOrName(string $keyword, int $perPage = 15)
    {
        $query = $this->query();

        if (!empty($keyword)) {
            $query = $query->where(function ($q) use ($keyword) {
                $q->where('sku', 'like', "%{$keyword}%")
                    ->orWhere('name', 'like', "%{$keyword}%");
            });
        }

        return $query->paginate($perPage);
    }
}
