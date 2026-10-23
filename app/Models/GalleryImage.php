<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryImage extends Model
{
    protected $fillable = ['title', 'title_en', 'caption', 'caption_en', 'image', 'alt_text', 'alt_text_en', 'sort_order', 'is_active'];

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

    public function getDisplayTitleAttribute(): ?string
    {
        return app()->getLocale() === 'en' && filled($this->title_en) ? $this->title_en : $this->title;
    }

    public function getDisplayCaptionAttribute(): ?string
    {
        return app()->getLocale() === 'en' && filled($this->caption_en) ? $this->caption_en : $this->caption;
    }

    public function getDisplayAltTextAttribute(): ?string
    {
        return app()->getLocale() === 'en' && filled($this->alt_text_en) ? $this->alt_text_en : $this->alt_text;
    }
}
