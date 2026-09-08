<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartService
{
    /**
     * Get cart identifier (user_id or session_id)
     */
    protected function getCartIdentifier(): array
    {
        if (Auth::check()) {
            return ['user_id' => Auth::id()];
        }
        
        return ['session_id' => session()->getId()];
    }

    /**
     * Get all cart items
     */
    public function getCartItems(): Collection
    {
        $identifier = $this->getCartIdentifier();
        
        return CartItem::where($identifier)
            ->with(['product.productImages'])
            ->get();
    }

    /**
     * Add item to cart
     */
    public function addItem(int $productId, int $quantity = 1): CartItem
    {
        $identifier = $this->getCartIdentifier();
        
        $cartItem = CartItem::where($identifier)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create(array_merge($identifier, [
                'product_id' => $productId,
                'quantity' => $quantity,
            ]));
        }

        return $cartItem;
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(int $cartItemId, int $quantity): ?CartItem
    {
        $identifier = $this->getCartIdentifier();
        
        $cartItem = CartItem::where($identifier)
            ->where('id', $cartItemId)
            ->first();

        if ($cartItem) {
            if ($quantity <= 0) {
                $cartItem->delete();
                return null;
            }
            
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        return $cartItem;
    }

    /**
     * Remove item from cart
     */
    public function removeItem(int $cartItemId): bool
    {
        $identifier = $this->getCartIdentifier();
        
        return CartItem::where($identifier)
            ->where('id', $cartItemId)
            ->delete() > 0;
    }

    /**
     * Clear cart
     */
    public function clearCart(): void
    {
        $identifier = $this->getCartIdentifier();
        CartItem::where($identifier)->delete();
    }

    /**
     * Calculate cart total
     */
    public function getTotal(): float
    {
        return $this->getCartItems()->sum(function ($item) {
            return $item->getSubtotal();
        });
    }

    /**
     * Get cart items count
     */
    public function getItemsCount(): int
    {
        return $this->getCartItems()->sum('quantity');
    }

    /**
     * Merge guest cart to user cart after login
     */
    public function mergeGuestCart(string $sessionId): void
    {
        if (!Auth::check()) {
            return;
        }

        $guestItems = CartItem::where('session_id', $sessionId)->get();

        foreach ($guestItems as $guestItem) {
            $userItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $guestItem->product_id)
                ->first();

            if ($userItem) {
                $userItem->quantity += $guestItem->quantity;
                $userItem->save();
            } else {
                $guestItem->user_id = Auth::id();
                $guestItem->session_id = null;
                $guestItem->save();
            }
        }

        // Delete remaining guest items
        CartItem::where('session_id', $sessionId)->delete();
    }
}
