<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryImage extends Model
{
    protected $fillable = ['title', 'caption', 'image', 'alt_text', 'sort_order', 'is_active'];

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
}
