<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlowerOrigin extends Model
{
    protected $fillable = [
        'slug', 'map_x', 'map_y', 'country', 'country_en', 'country_code', 'lat', 'lon',
        'flower', 'flower_en', 'latin', 'region', 'region_en', 'coordinate', 'image', 'sort_order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function getImageUrlAttribute(): string
    {
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return str_starts_with($this->image, 'images/')
            ? asset($this->image)
            : asset('storage/' . ltrim($this->image, '/'));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getDisplayCountryAttribute(): string
    {
        return app()->getLocale() === 'en' && filled($this->country_en) ? $this->country_en : $this->country;
    }

    public function getDisplayFlowerAttribute(): string
    {
        return app()->getLocale() === 'en' && filled($this->flower_en) ? $this->flower_en : $this->flower;
    }

    public function getDisplayRegionAttribute(): string
    {
        return app()->getLocale() === 'en' && filled($this->region_en) ? $this->region_en : $this->region;
    }
}
