<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public const STATIC_SLUGS = [
        'chinh-sach-giao-hang',
        'chinh-sach-bao-mat',
        'chinh-sach-cua-chung-toi',
        'dieu-khoan-dich-vu',
        'huong-dan-dat-hang',
        'lien-he',
        'chinh-sach-doi-tra',
    ];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_active',
        'header_image',
        'hide_header_overlay',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'hide_header_overlay' => 'boolean',
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
