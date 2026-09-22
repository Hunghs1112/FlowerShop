<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * User Repository
 * 
 * Handles:
 * - User search and filtering
 * - Role-based queries
 * - VIP level queries
 * - Active/inactive filtering
 * - Soft delete support
 */
class UserRepository extends BaseRepository
{
    protected function getModel(): string
    {
        return User::class;
    }

    protected function getSearchFields(): array
    {
        return ['name', 'email', 'phone'];
    }

    /**
     * Filter by role
     */
    public function byRole(string $role): self
    {
        return $this->setQuery($this->newQuery()->where('role', $role));
    }

    /**
     * Get admin users
     */
    public function admins(): self
    {
        return $this->byRole('admin');
    }

    /**
     * Get customer users
     */
    public function customers(): self
    {
        return $this->byRole('customer');
    }

    /**
     * Get active users only
     */
    public function activeUsers(): self
    {
        return $this->setQuery($this->newQuery()->where('is_active', true));
    }

    /**
     * Get inactive users
     */
    public function inactiveUsers(): self
    {
        return $this->setQuery($this->newQuery()->where('is_active', false));
    }

    /**
     * Filter by VIP level
     */
    public function byVipLevel(int $vipLevelId): self
    {
        return $this->setQuery($this->newQuery()->where('vip_level_id', $vipLevelId));
    }

    /**
     * Get users with VIP level
     */
    public function withVipLevel(): self
    {
        return $this->setQuery($this->newQuery()->with('vipLevel'));
    }

    /**
     * Get users without VIP level
     */
    public function withoutVipLevel(): self
    {
        return $this->setQuery($this->newQuery()->whereNull('vip_level_id'));
    }

    /**
     * Filter by email
     */
    public function byEmail(string $email): ?User
    {
        return $this->query()->where('email', $email)->first();
    }

    /**
     * Get users by email domain
     */
    public function byEmailDomain(string $domain): self
    {
        return $this->setQuery($this->newQuery()->where('email', 'like', "%@{$domain}"));
    }

    /**
     * Get users with relationships
     */
    public function getWithRelations(int $id): ?User
    {
        return $this->query()
            ->with(['vipLevel', 'favorites', 'inquiries'])
            ->find($id);
    }

    /**
     * Get options for select dropdown
     */
    public function selectOptions(): Collection
    {
        return $this->query()
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');
    }

    /**
     * Check if user exists by email
     */
    public function existsByEmail(string $email): bool
    {
        return $this->query()->where('email', $email)->exists();
    }

    /**
     * Search users by keyword across name, email, phone
     */
    public function searchUsers(string $keyword, int $perPage = 15)
    {
        $query = $this->query();

        if (!empty($keyword)) {
            $query = $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Get verified users only
     */
    public function verified(): self
    {
        return $this->setQuery($this->newQuery()->whereNotNull('email_verified_at'));
    }

    /**
     * Get unverified users
     */
    public function unverified(): self
    {
        return $this->setQuery($this->newQuery()->whereNull('email_verified_at'));
    }
}
