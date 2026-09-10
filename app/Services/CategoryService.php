<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    /**
     * Get all active categories with their children
     */
    public function getActiveCategories(): Collection
    {
        return Category::active()
            ->topLevel()
            ->with(['children' => function ($query) {
                $query->active();
            }])
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get category tree for admin
     */
    public function getCategoryTree(): Collection
    {
        return Category::with('children')
            ->topLevel()
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get breadcrumb for a category
     */
    public function getBreadcrumb(Category $category): array
    {
        $breadcrumb = [];
        $current = $category;

        while ($current) {
            array_unshift($breadcrumb, [
                'name' => $current->display_name,
                'slug' => $current->display_slug,
                'url' => route('categories.show', $current->display_slug),
            ]);
            $current = $current->parent;
        }

        return $breadcrumb;
    }

    /**
     * Get all descendants of a category (for filtering products)
     */
    public function getDescendantIds(Category $category): array
    {
        $ids = [$category->id];
        
        foreach ($category->children as $child) {
            $ids = array_merge($ids, $this->getDescendantIds($child));
        }

        return $ids;
    }
}
