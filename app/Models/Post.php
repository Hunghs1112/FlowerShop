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
    ];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'category',
        'content',
        'thumbnail',
        'is_published',
        'published_at',
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

    // Helpers
    public function getReadingTime(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return ceil($wordCount / 200); // Assuming 200 words per minute
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->thumbnail) {
            return 'https://via.placeholder.com/800x600/E5E7EB/6B7280?text=No+Image';
        }
        // Already an absolute URL (e.g. Unsplash, http/https)
        if (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://')) {
            return $this->thumbnail;
        }
        // Relative path → storage disk
        return asset('storage/' . $this->thumbnail);
    }
}
