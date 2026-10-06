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
        
        $items = CartItem::where($identifier)
            ->with(['product.productImages', 'product.vipLevels', 'variant.images'])
            ->get();

        // CRITICAL: Filter out products user doesn't have access to
        $user = Auth::user();
        if ($user && $user->vip_level_id) {
            $items = $items->filter(function ($item) use ($user) {
                return $item->product->vipLevels()
                    ->where('vip_levels.id', $user->vip_level_id)
                    ->exists();
            });
        }

        return $items;
    }

    /**
     * Add item to cart
     */
    public function addItem(int $productId, int $quantity = 1, ?int $variantId = null): CartItem
    {
        // Validate stock before adding
        $product = Product::findOrFail($productId);
        
        // If variant specified, validate it belongs to the product
        $variant = null;
        if ($variantId) {
            $variant = \App\Models\ProductVariant::where('id', $variantId)
                ->where('product_id', $productId)
                ->where('is_active', true)
                ->firstOrFail();
        }
        
        // CRITICAL: Backend VIP authorization check
        $user = Auth::user();
        if ($user && $user->vip_level_id) {
            $hasAccess = $product->vipLevels()->where('vip_levels.id', $user->vip_level_id)->exists();
            if (!$hasAccess) {
                throw new \Exception('Bạn không có quyền thêm sản phẩm này vào giỏ hàng');
            }
        }
        
        $identifier = $this->getCartIdentifier();
        
        // Find existing cart item (same product and variant)
        $cartItem = CartItem::where($identifier)
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->first();

        $newQuantity = $cartItem ? $cartItem->quantity + $quantity : $quantity;
        
        // Check stock availability (use variant stock if available)
        $availableStock = $variant ? $variant->stock : $product->stock;
        if ($availableStock < $newQuantity) {
            throw new \Exception('Sản phẩm không đủ số lượng (còn ' . $availableStock . ')');
        }

        if ($cartItem) {
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create(array_merge($identifier, [
                'product_id' => $productId,
                'quantity' => $quantity,
                'variant_id' => $variantId,
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
            
            $stock = $cartItem->variant?->stock ?? $cartItem->product?->stock ?? 0;
            if ($quantity > $stock) {
                throw new \RuntimeException('Số lượng vượt quá tồn kho (còn ' . $stock . ')');
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
                ->where('variant_id', $guestItem->variant_id)
                ->first();

            if ($userItem) {
                $stock = $guestItem->variant?->stock ?? $guestItem->product?->stock ?? 0;
                $userItem->quantity = min($userItem->quantity + $guestItem->quantity, $stock);
                if ($userItem->quantity < 1) {
                    $guestItem->delete();
                    continue;
                }
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
