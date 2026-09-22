<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image_path',
        'button_text',
        'button_link',
        'sort_order',
        'is_active',
        'location',
        'has_background',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'has_background' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    // Accessors
    public function getImageUrlAttribute(): string
    {
        if (!$this->image_path) {
            return asset('images/placeholder-banner.jpg');
        }

        // Absolute URL — return as-is
        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        // Banners are uploaded directly to public/images/banners/ (not on storage disk)
        // DB stores paths like "images/banners/file.jpg" → serve via asset()
        if (str_starts_with($this->image_path, 'images/')) {
            return asset($this->image_path);
        }

        // Fallback: any record stored on the public storage disk
        return asset('storage/' . ltrim($this->image_path, '/'));
    }

    public function hasText(): bool
    {
        return !empty($this->title) || !empty($this->subtitle);
    }

    public function hasCta(): bool
    {
        return !empty($this->button_text) && !empty($this->button_link);
    }

    public function scopeForLocation($query, $location = 'home')
    {
        return $query->where('location', $location);
    }
}
