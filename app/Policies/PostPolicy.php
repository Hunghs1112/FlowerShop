<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Post Policy
 */
class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can publish/unpublish a post
     */
    public function publish(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }
}
