<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'stock',
        'sales_count',
        'latest_arrival_date',
        'short_description',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'latest_arrival_date' => 'datetime',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeBestSelling($query)
    {
        return $query->orderBy('sales_count', 'desc');
    }

    public function scopeNewArrival($query)
    {
        return $query->whereNotNull('latest_arrival_date')
            ->orderBy('latest_arrival_date', 'desc');
    }

    // Helpers
    public function getPrimaryImage(): ?string
    {
        $primary = $this->productImages()->where('is_primary', true)->first();
        return $primary ? $primary->image_path : $this->productImages()->first()?->image_path;
    }

    public function getPrimaryImageUrl(): string
    {
        $imagePath = $this->getPrimaryImage();
        if (!$imagePath) {
            return 'https://via.placeholder.com/400x400/E5E7EB/6B7280?text=No+Image';
        }
        return asset('storage/' . $imagePath);
    }

    public function isFavoritedBy($userId): bool
    {
        if (!$userId) {
            return false;
        }
        return $this->favorites()->where('user_id', $userId)->exists();
    }
}
