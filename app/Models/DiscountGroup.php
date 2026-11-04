<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DiscountGroup extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'description',
        'discount_percent',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'discount_percent' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'discount_group_product', 'discount_group_id', 'product_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Assign a product to a discount group (or remove it when $groupId is null).
     * A product belongs to at most one group (unique product_id on the pivot),
     * so it is detached from every group first. Single source of truth — both
     * the discount-group admin and the product admin call this.
     */
    public static function assignProduct(int $productId, ?int $groupId): void
    {
        static::whereHas('products', fn ($q) => $q->where('products.id', $productId))
            ->get()
            ->each(fn ($group) => $group->products()->detach($productId));

        if ($groupId) {
            static::find($groupId)?->products()->syncWithoutDetaching([$productId]);
        }
    }

    public function getDisplayNameAttribute(): string
    {
        return app()->getLocale() === 'en' && filled($this->name_en) ? $this->name_en : $this->name;
    }
}
