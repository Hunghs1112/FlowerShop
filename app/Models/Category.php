<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'hover_image',
        'sort_order',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class)->orderBy('sort_order');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    // Helpers
    public function getFullPath(): string
    {
        $path = [$this->name];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }

        return implode(' > ', $path);
    }

    // Display helpers (locale-aware — simplified since bilingual feature was removed)
    public function getDisplayNameAttribute(): string { return $this->name; }
    public function getDisplayDescriptionAttribute(): ?string { return $this->description; }
    public function getDisplaySlugAttribute(): string { return $this->slug; }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return 'https://via.placeholder.com/400x300/E5E7EB/6B7280?text=Category';
        }

        // Absolute URL (http/https) — return as-is
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        // Clean path: remove leading slashes and always use /storage/ URL
        return asset('storage/' . ltrim($this->image, '/'));
    }

    public function getHoverImageUrlAttribute(): ?string
    {
        if (!$this->hover_image) {
            return null;
        }

        // Absolute URL (http/https) — return as-is
        if (str_starts_with($this->hover_image, 'http://') || str_starts_with($this->hover_image, 'https://')) {
            return $this->hover_image;
        }

        // If path already starts with /storage/ or /images/, treat as a public asset path
        if (str_starts_with($this->hover_image, '/storage/') || str_starts_with($this->hover_image, '/images/')) {
            return asset(ltrim($this->hover_image, '/'));
        }

        // Default: stored in the public disk under storage/app/public/
        return asset('storage/' . $this->hover_image);
    }
}
