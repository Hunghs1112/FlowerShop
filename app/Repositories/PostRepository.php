<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

/**
 * Post Repository
 * 
 * Handles:
 * - Blog post search and filtering
 * - Published/draft status
 * - Author filtering
 */
class PostRepository extends BaseRepository
{
    protected function getModel(): string
    {
        return Post::class;
    }

    protected function getSearchFields(): array
    {
        return ['title', 'excerpt', 'content'];
    }

    /**
     * Get published posts only
     */
    public function published(): self
    {
        return $this->setQuery($this->newQuery()->where('is_published', true));
    }

    /**
     * Get draft posts only
     */
    public function drafts(): self
    {
        return $this->setQuery($this->newQuery()->where('is_published', false));
    }

    /**
     * Filter by author
     */
    public function byAuthor(int $authorId): self
    {
        return $this->setQuery($this->newQuery()->where('author_id', $authorId));
    }

    /**
     * Get published posts paginated
     */
    public function publishedPaginated(int $perPage = 10): Paginator
    {
        return $this->query()
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get recent published posts
     */
    public function recentPublished(int $limit = 10): Collection
    {
        return $this->query()
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get related posts (same category/topic)
     */
    public function related(Post $post, int $limit = 5): Collection
    {
        return $this->query()
            ->where('id', '!=', $post->id)
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get post with author details
     */
    public function getWithAuthor(int $id): ?Post
    {
        return $this->query()
            ->with('author')
            ->find($id);
    }

    /**
     * Get by slug
     */
    public function findBySlug(string $slug): ?Post
    {
        return $this->query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();
    }
}
