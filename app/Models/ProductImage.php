<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $table = 'product_media';
    
    protected $fillable = [
        'product_id',
        'image_path',
        'mime_type',
        'media_type',
        'video_url',
        'thumbnail_path',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // Scopes
    public function scopeImages($query)
    {
        return $query->where('media_type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('media_type', 'video');
    }

    // Accessors
    public function getImageUrlAttribute(): string
    {
        if (!$this->image_path) {
            return asset('images/placeholder.jpg');
        }
        // If already starts with 'images/' or 'products/', use asset directly
        if (str_starts_with($this->image_path, 'images/')) {
            return asset($this->image_path);
        }
        // Otherwise use storage path
        return asset('storage/' . $this->image_path);
    }

    public function getVideoUrlAttribute(): ?string
    {
        if ($this->media_type !== 'video') {
            return null;
        }
        
        // External URL (YouTube, Vimeo, etc.)
        if ($this->attributes['video_url']) {
            return $this->attributes['video_url'];
        }
        
        // Local uploaded video
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        
        return null;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->thumbnail_path) {
            return asset('storage/' . $this->thumbnail_path);
        }
        
        // Default video placeholder
        if ($this->media_type === 'video') {
            return asset('images/video-placeholder.jpg');
        }
        
        return null;
    }

    public function isVideo(): bool
    {
        return $this->media_type === 'video';
    }

    public function isImage(): bool
    {
        return $this->media_type === 'image';
    }

    // Relationships
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
