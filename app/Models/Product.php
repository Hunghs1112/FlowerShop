<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'price',
        'stock',
        'sales_count',
        'latest_arrival_date',
        'description',
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

    /**
     * Scope for search - searches in name and short_description
     * Uses full-text like search with sanitized input
     */
    public function scopeSearch($query, ?string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        // Escape special regex characters and prepare search term
        $escapedTerm = preg_replace('/[%_]/', '\\$0', $searchTerm);
        
        return $query->where(function (Builder $q) use ($escapedTerm) {
            $q->where('name', 'like', '%' . $escapedTerm . '%')
              ->orWhere('short_description', 'like', '%' . $escapedTerm . '%');
        });
    }

    /**
     * Scope for price range filtering
     */
    public function scopePriceRange($query, ?float $minPrice, ?float $maxPrice): Builder
    {
        if ($minPrice !== null && $minPrice > 0) {
            $query->where('price', '>=', $minPrice);
        }
        
        if ($maxPrice !== null && $maxPrice > 0) {
            $query->where('price', '<=', $maxPrice);
        }
        
        return $query;
    }

    /**
     * Scope for sorting by name A-Z
     */
    public function scopeSortByName($query, string $direction = 'asc'): Builder
    {
        return $query->orderBy('name', $direction);
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
        // Use storage path for images stored in storage/app/public
        return asset('storage/' . $imagePath);
    }

    // Display helpers (locale-aware — simplified since bilingual feature was removed)
    public function getDisplayNameAttribute(): string { return $this->name; }
    public function getDisplayShortDescriptionAttribute(): ?string { return $this->short_description; }
    public function getDisplaySlugAttribute(): string { return $this->slug; }

    public function isFavoritedBy($user): bool
    {
        if (!$user) return false;
        return $this->favorites()->where('user_id', $user->id)->exists();
    }
}
