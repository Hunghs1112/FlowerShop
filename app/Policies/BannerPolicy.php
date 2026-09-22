<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Banner;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Banner Policy
 */
class BannerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Banner $banner): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Banner $banner): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Banner $banner): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Banner $banner): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Banner $banner): bool
    {
        return $user->isAdmin();
    }
}
