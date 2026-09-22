<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

/**
 * Category Repository
 * 
 * Handles:
 * - Category search and listing
 * - Hierarchical queries
 * - Sort order management
 */
class CategoryRepository extends BaseRepository
{
    protected function getModel(): string
    {
        return Category::class;
    }

    protected function getSearchFields(): array
    {
        return ['name', 'description'];
    }

    /**
     * Get all active categories
     */
    public function allActive(): Collection
    {
        return $this->query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get categories with subcategories
     */
    public function withSubcategories(): Collection
    {
        return $this->query()
            ->with('subcategories')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get category with all relations
     */
    public function getWithRelations(int $id): ?Category
    {
        return $this->query()
            ->with(['subcategories' => function ($q) {
                $q->where('is_active', true)->orderBy('sort_order');
            }, 'products'])
            ->find($id);
    }

    /**
     * Get paginated list with search
     */
    public function listPaginated(int $perPage = 15, string $search = null): Paginator
    {
        $query = $this->query()->orderBy('sort_order');

        if ($search) {
            $query = $this->applySearchToQuery($query, $search);
        }

        return $query->paginate($perPage);
    }

    /**
     * Get select options
     */
    public function selectOptions(): Collection
    {
        return $this->query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->pluck('name', 'id');
    }

    /**
     * Get by slug
     */
    public function findBySlug(string $slug): ?Category
    {
        return $this->query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();
    }
}
