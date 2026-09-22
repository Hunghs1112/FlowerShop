<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * User Policy
 * 
 * Handles authorization for user management
 */
class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, User $model): bool
    {
        // Prevent deleting self
        if ($user->id === $model->id) {
            return false;
        }

        return $user->isAdmin();
    }

    public function restore(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, User $model): bool
    {
        // Prevent force-deleting self
        if ($user->id === $model->id) {
            return false;
        }

        return $user->isAdmin();
    }

    /**
     * Can update user's VIP level
     */
    public function updateVipLevel(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Can change user's role
     */
    public function changeRole(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Can reset user's password
     */
    public function resetPassword(User $user, User $model): bool
    {
        return $user->isAdmin();
    }
}
