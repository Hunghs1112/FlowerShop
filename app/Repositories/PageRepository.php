<?php

namespace App\Repositories;

use App\Models\Page;

/**
 * Page Repository
 */
class PageRepository extends BaseRepository
{
    protected function getModel(): string
    {
        return Page::class;
    }

    protected function getSearchFields(): array
    {
        return ['title', 'content', 'meta_title', 'meta_description'];
    }

    /**
     * Get by slug
     */
    public function findBySlug(string $slug): ?Page
    {
        return $this->query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get select options
     */
    public function selectOptions()
    {
        return $this->query()
            ->where('is_active', true)
            ->orderBy('title')
            ->pluck('title', 'id');
    }
}
