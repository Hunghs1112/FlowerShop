<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    public const CATEGORIES = [
        'vung-dat' => 'Câu chuyện vùng đất',
        'cham-hoa' => 'Sổ tay chăm hoa',
        'mua-hoa' => 'Mùa hoa',
        'khong-gian' => 'Cảm hứng không gian',
        'cam-hung' => 'Cảm hứng',
        'hau-truong' => 'Hậu trường',
        'du-an' => 'Feedback từ khách hàng',
    ];

    protected $fillable = [
        'title',
        'title_en',
        'slug',
        'slug_en',
        'excerpt',
        'excerpt_en',
        'category',
        'content',
        'content_en',
        'thumbnail',
        'is_published',
        'published_at',
        'sort_order',
        'author_id',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Relationships
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeDisplayOrder($query)
    {
        return $query
            ->orderByRaw('CASE WHEN sort_order = 0 THEN 1 ELSE 0 END')
            ->orderBy('sort_order')
            ->latest('published_at')
            ->latest('id');
    }

    // Helpers
    public function getReadingTime(): int
    {
        $wordCount = str_word_count(strip_tags($this->display_content));

        return ceil($wordCount / 200); // Assuming 200 words per minute
    }

    public function getDisplayTitleAttribute(): string
    {
        return app()->getLocale() === 'en' && filled($this->title_en) ? $this->title_en : $this->title;
    }

    public function getDisplayExcerptAttribute(): ?string
    {
        return app()->getLocale() === 'en' && filled($this->excerpt_en) ? $this->excerpt_en : $this->excerpt;
    }

    public function getDisplayContentAttribute(): string
    {
        return app()->getLocale() === 'en' && filled($this->content_en) ? $this->content_en : $this->content;
    }

    public function getDisplaySlugAttribute(): string
    {
        return app()->getLocale() === 'en' && filled($this->slug_en) ? $this->slug_en : $this->slug;
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->thumbnail) {
            return 'https://via.placeholder.com/800x600/E5E7EB/6B7280?text=No+Image';
        }
        // Already an absolute URL (e.g. Unsplash, http/https)
        if (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://')) {
            return $this->thumbnail;
        }

        // Relative path → storage disk
        return asset('storage/'.$this->thumbnail);
    }
}
