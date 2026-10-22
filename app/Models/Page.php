<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public const GUIDE_SLUGS = ['huong-dan-dat-hang'];

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
        'tuyen-dung',
        ...self::SEASONAL_SLUGS,
    ];

    protected $fillable = [
        'title',
        'title_en',
        'slug',
        'content',
        'content_en',
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
        if (! $this->header_image) {
            return null;
        }

        if (str_starts_with($this->header_image, 'http://') || str_starts_with($this->header_image, 'https://')) {
            return $this->header_image;
        }

        if (str_starts_with($this->header_image, 'images/')) {
            return asset($this->header_image);
        }

        return asset('storage/'.ltrim($this->header_image, '/'));
    }

    // Display helpers (locale-aware — Vietnamese as source, English as fallback)
    public function getDisplayTitleAttribute(): string
    {
        return app()->getLocale() === 'en' && filled($this->title_en) ? $this->title_en : $this->title;
    }

    public function getDisplayContentAttribute(): ?string
    {
        return app()->getLocale() === 'en' && filled($this->content_en) ? $this->content_en : $this->content;
    }

    public function getDisplaySlugAttribute(): string
    {
        return $this->slug; // slug not translated currently
    }
}
