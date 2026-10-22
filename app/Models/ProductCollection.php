<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class ProductCollection extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'slug',
        'slug_en',
        'criterion',
        'criterion_en',
        'accent_color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $collection) {
            if (empty($collection->slug) || $collection->isDirty('name')) {
                $collection->slug = static::generateUniqueSlug($collection->name, $collection->id);
            }
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'collection_product', 'collection_id', 'product_id')
            ->withPivot('sort_order')
            ->orderBy('collection_product.sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getAccentColorAttribute(): string
    {
        return ($this->attributes['accent_color'] ?? null) ?: '#A3B18A';
    }

    public function getDisplayNameAttribute(): string
    {
        return app()->getLocale() === 'en' && filled($this->name_en) ? $this->name_en : $this->name;
    }

    public function getDisplaySlugAttribute(): string
    {
        return app()->getLocale() === 'en' && filled($this->slug_en) ? $this->slug_en : $this->slug;
    }

    public function getDisplayCriterionAttribute(): ?string
    {
        return app()->getLocale() === 'en' && filled($this->criterion_en) ? $this->criterion_en : $this->criterion;
    }

    protected static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'collection';
        $slug = $base;
        $i = 1;
        while (static::where(fn ($query) => $query->where('slug', $slug)->orWhere('slug_en', $slug))
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.(++$i);
        }

        return $slug;
    }
}
