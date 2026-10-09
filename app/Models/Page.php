<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public const GUIDE_SLUGS = ['huong-dan-mua-hang', 'huong-dan-dat-hang'];

    public const POLICY_SLUGS = [
        'chinh-sach-bao-mat',
        'chinh-sach-cua-chung-toi',
        'chinh-sach-giao-hang',
        'dieu-khoan-dich-vu',
    ];

    public const SEASONAL_SLUGS = [
        'phu-kien-cay-thong',
        'mua-le-hoi',
    ];

    public const STATIC_SLUGS = [
        'chinh-sach-giao-hang',
        'chinh-sach-bao-mat',
        'chinh-sach-cua-chung-toi',
        'dieu-khoan-dich-vu',
        ...self::GUIDE_SLUGS,
        'lien-he',
        'chinh-sach-doi-tra',
        ...self::SEASONAL_SLUGS,
    ];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_active',
        'header_image',
        'hide_header_overlay',
        'policy_intro',
        'policy_updated_at_display',
        'policy_content_override',
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
