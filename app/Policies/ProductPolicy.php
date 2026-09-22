<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Product Policy
 * 
 * Defines authorization rules for product CRUD operations
 */
class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if user can view the product admin panel
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can view a product
     */
    public function view(User $user, Product $product): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can create a product
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can update a product
     */
    public function update(User $user, Product $product): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can delete a product
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can restore a product (soft delete)
     */
    public function restore(User $user, Product $product): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can permanently delete a product
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can manage product images
     */
    public function manageImages(User $user, Product $product): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can manage product variants
     */
    public function manageVariants(User $user, Product $product): bool
    {
        return $user->isAdmin();
    }
}
