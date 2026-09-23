<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_active',
        'header_image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getHeaderImageUrlAttribute(): ?string
    {
        if (!$this->header_image) {
            return null;
        }

        if (str_starts_with($this->header_image, 'http://') || str_starts_with($this->header_image, 'https://')) {
            return $this->header_image;
        }

        if (str_starts_with($this->header_image, 'images/')) {
            return asset($this->header_image);
        }

        return asset('storage/' . ltrim($this->header_image, '/'));
    }
}
