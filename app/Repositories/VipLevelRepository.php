<?php

namespace App\Repositories;

use App\Models\VipLevel;
use Illuminate\Database\Eloquent\Collection;

/**
 * VipLevel Repository
 * 
 * Handles:
 * - VIP level search and filtering
 * - Priority-based queries
 * - User/product relationship queries
 * - Active/inactive filtering
 */
class VipLevelRepository extends BaseRepository
{
    protected function getModel(): string
    {
        return VipLevel::class;
    }

    protected function getSearchFields(): array
    {
        return ['name', 'description'];
    }

    /**
     * Get active VIP levels only
     */
    public function activeOnly(): self
    {
        return $this->setQuery($this->newQuery()->where('is_active', true));
    }

    /**
     * Get inactive VIP levels
     */
    public function inactiveOnly(): self
    {
        return $this->setQuery($this->newQuery()->where('is_active', false));
    }

    /**
     * Sort by priority
     */
    public function byPriority(): self
    {
        return $this->setQuery($this->newQuery()->orderBy('priority', 'asc'));
    }

    /**
     * Get VIP levels with user count
     */
    public function withUserCount(): self
    {
        return $this->setQuery($this->newQuery()
            ->withCount('users')
            ->orderBy('priority', 'asc'));
    }

    /**
     * Get VIP levels with user and product counts
     */
    public function withCounts(): self
    {
        return $this->setQuery($this->newQuery()
            ->withCount(['users', 'products'])
            ->orderBy('priority', 'asc'));
    }

    /**
     * Filter by priority range
     */
    public function byPriorityRange(int $minPriority, int $maxPriority): self
    {
        return $this->setQuery($this->newQuery()
            ->where('priority', '>=', $minPriority)
            ->where('priority', '<=', $maxPriority));
    }

    /**
     * Get VIP level with relationships
     */
    public function getWithRelations(int $id): ?VipLevel
    {
        return $this->query()
            ->with(['users', 'products'])
            ->find($id);
    }

    /**
     * Get options for select dropdown
     */
    public function selectOptions(): Collection
    {
        return $this->query()
            ->where('is_active', true)
            ->orderBy('priority', 'asc')
            ->pluck('name', 'id');
    }

    /**
     * Get highest priority VIP level
     */
    public function getHighestPriority(): ?VipLevel
    {
        return $this->query()
            ->where('is_active', true)
            ->orderBy('priority', 'asc')
            ->first();
    }

    /**
     * Get lowest priority VIP level
     */
    public function getLowestPriority(): ?VipLevel
    {
        return $this->query()
            ->where('is_active', true)
            ->orderBy('priority', 'desc')
            ->first();
    }

    /**
     * Check if VIP level has users
     */
    public function hasUsers(int $id): bool
    {
        return $this->query()
            ->where('id', $id)
            ->has('users')
            ->exists();
    }

    /**
     * Get VIP levels ordered by priority (active first)
     */
    public function getOrdered(): Collection
    {
        return $this->query()
            ->where('is_active', true)
            ->orderBy('priority', 'asc')
            ->get();
    }
}
