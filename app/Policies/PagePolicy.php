<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Page Policy
 */
class PagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Page $page): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Page $page): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Page $page): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Page $page): bool
    {
        return $user->isAdmin();
    }
}
