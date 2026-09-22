<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Base Admin Policy
 * 
 * All admin-only policies inherit from this to provide common authorization checks
 */
class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Check if user is admin
     */
    public function isAdmin(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Authorize admin access
     * Use in controller: $this->authorize('admin');
     */
    public function admin(User $user): bool
    {
        return $this->isAdmin($user);
    }
}
