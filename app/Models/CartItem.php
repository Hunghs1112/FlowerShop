<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'variant_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    // Helpers
    public function getUnitPrice(): float
    {
        // Discounted price: variant price (or product price) with the group discount applied
        return $this->variant
            ? $this->variant->discountedPrice()
            : $this->product->discountedPrice();
    }

    public function getOriginalUnitPrice(): float
    {
        return $this->variant ? (float) $this->variant->getDisplayPrice() : (float) $this->product->price;
    }

    public function getSubtotal(): float
    {
        return $this->getUnitPrice() * $this->quantity;
    }
    
    public function getDisplayName(): string
    {
        $name = $this->product->display_name;
        if ($this->variant) {
            $variantName = $this->variant->name ?? $this->variant->sku;
            $name .= ' - ' . $variantName;
        }
        return $name;
    }
    
    public function getPrimaryImageUrl(): string
    {
        // Use variant image if available, otherwise use product image
        if ($this->variant && $this->variant->images()->count() > 0) {
            return $this->variant->getPrimaryImageUrl();
        }
        return $this->product->getPrimaryImageUrl();
    }
}
