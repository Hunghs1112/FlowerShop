<?php

namespace App\Repositories;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Collection;

/**
 * Subcategory Repository
 * 
 * Handles:
 * - Subcategory search and filtering
 * - Category filtering
 * - Product-related queries
 * - Sorting by order
 * - Active/inactive filtering
 */
class SubcategoryRepository extends BaseRepository
{
    protected function getModel(): string
    {
        return Subcategory::class;
    }

    protected function getSearchFields(): array
    {
        return ['name', 'description'];
    }

    /**
     * Filter by category
     */
    public function byCategory(int $categoryId): self
    {
        return $this->setQuery($this->newQuery()->where('category_id', $categoryId));
    }

    /**
     * Filter by multiple categories
     */
    public function byCategories(array $categoryIds): self
    {
        return $this->setQuery($this->newQuery()->whereIn('category_id', $categoryIds));
    }

    /**
     * Get subcategories with category relationship
     */
    public function withCategory(): self
    {
        return $this->setQuery($this->newQuery()->with('category'));
    }

    /**
     * Get subcategories with product count
     */
    public function withProductCount(): self
    {
        return $this->setQuery($this->newQuery()->withCount('products'));
    }

    /**
     * Get subcategories with category and product count
     */
    public function withRelations(): self
    {
        return $this->setQuery($this->newQuery()
            ->with('category')
            ->withCount('products'));
    }

    /**
     * Get active subcategories only
     */
    public function activeOnly(): self
    {
        return $this->setQuery($this->newQuery()->where('is_active', true));
    }

    /**
     * Get inactive subcategories
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
     * Get subcategories ordered by category and sort order
     */
    public function ordered(): self
    {
        return $this->setQuery($this->newQuery()
            ->orderBy('category_id', 'asc')
            ->orderBy('sort_order', 'asc'));
    }

    /**
     * Get subcategories with their products
     */
    public function getWithProducts(int $id): ?Subcategory
    {
        return $this->query()
            ->with(['category', 'products'])
            ->find($id);
    }

    /**
     * Get subcategories for a category
     */
    public function getForCategory(int $categoryId): Collection
    {
        return $this->query()
            ->where('category_id', $categoryId)
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    /**
     * Get active subcategories by category
     */
    public function getActiveByCategoryId(int $categoryId): Collection
    {
        return $this->query()
            ->where('category_id', $categoryId)
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
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
     * Get options for select dropdown grouped by category
     */
    public function selectOptionsGrouped(): array
    {
        $subcategories = $this->query()
            ->where('is_active', true)
            ->with('category')
            ->orderBy('category_id', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        $grouped = [];
        foreach ($subcategories as $sub) {
            $categoryName = $sub->category?->name ?? 'Other';
            if (!isset($grouped[$categoryName])) {
                $grouped[$categoryName] = [];
            }
            $grouped[$categoryName][$sub->id] = $sub->name;
        }

        return $grouped;
    }

    /**
     * Check if subcategory has products
     */
    public function hasProducts(int $id): bool
    {
        return $this->query()
            ->where('id', $id)
            ->has('products')
            ->exists();
    }

    /**
     * Get subcategory by slug
     */
    public function findBySlug(string $slug): ?Subcategory
    {
        return $this->query()->where('slug', $slug)->first();
    }
}
