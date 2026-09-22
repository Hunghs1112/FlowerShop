<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VipLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * VIP Level Policy
 */
class VipLevelPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, VipLevel $vipLevel): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, VipLevel $vipLevel): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, VipLevel $vipLevel): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, VipLevel $vipLevel): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, VipLevel $vipLevel): bool
    {
        return $user->isAdmin();
    }
}
