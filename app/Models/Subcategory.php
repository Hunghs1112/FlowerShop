<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategory extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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

    // Helpers
    public function getFullPath(): string
    {
        return $this->category->name . ' > ' . $this->name;
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->name;
    }

    public function getDisplayDescriptionAttribute(): ?string
    {
        return $this->description;
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return 'https://via.placeholder.com/400x300/E5E7EB/6B7280?text=Subcategory';
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (str_starts_with($this->image, '/storage/') || str_starts_with($this->image, '/images/')) {
            return asset(ltrim($this->image, '/'));
        }

        return asset('storage/' . $this->image);
    }
}
