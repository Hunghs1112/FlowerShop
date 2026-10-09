<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    private const NEW_ARRIVAL_DAYS = 30;
    private const BESTSELLER_SALES_THRESHOLD = 10;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'slug',
        'sku',
        'price',
        'stock',
        'sales_count',
        'latest_arrival_date',
        'arrival_status',
        'is_new_arrival',
        'is_bestseller',
        'description',
        'short_description',
        'length',
        'min_order_quantity',
        'origin',
        'specification',
        'unit',
        'return_policy',
        'video_url',
        'video_type',
        'is_featured',
        'is_active',
        'season_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'latest_arrival_date' => 'datetime',
        'is_new_arrival' => 'boolean',
        'is_bestseller' => 'boolean',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->orderBy('sort_order');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function vipLevels()
    {
        return $this->belongsToMany(VipLevel::class, 'product_vip_level');
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

    public function scopeForSeason($query, string $seasonId)
    {
        return $query->where('season_id', $seasonId);
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

    /**
     * Scope for VIP level visibility
     * Filters products based on user's VIP level
     */
    public function scopeVisibleToUser($query, $user = null): Builder
    {
        // If no user, return all active products (or implement guest logic)
        if (!$user) {
            return $query;
        }

        // If user has no VIP level, return all products (or implement default logic)
        if (!$user->vip_level_id) {
            return $query;
        }

        // Get products that are assigned to this VIP level
        return $query->whereHas('vipLevels', function ($q) use ($user) {
            $q->where('vip_levels.id', $user->vip_level_id);
        });
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
        // Strip legacy 'images/' prefix since storage/app/public already contains category folders
        $path = preg_replace('#^/?images/#', '', $imagePath);
        return asset('storage/' . $path);
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

    public function isSoldOut(): bool
    {
        return (int) $this->stock <= 0;
    }

    public function hasNewArrivalBadge(): bool
    {
        $arrivalDate = $this->latest_arrival_date ?? $this->created_at;

        return (bool) $this->is_new_arrival
            || ($arrivalDate && $arrivalDate->greaterThanOrEqualTo(now()->subDays(self::NEW_ARRIVAL_DAYS)));
    }

    public function hasBestsellerBadge(): bool
    {
        return (bool) $this->is_bestseller
            || (int) $this->sales_count >= self::BESTSELLER_SALES_THRESHOLD;
    }
}
