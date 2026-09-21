<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariantImage extends Model
{
    protected $fillable = [
        'product_variant_id',
        'image_path',
        'mime_type',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // Relationships
    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    // Accessors
    public function getImageUrlAttribute(): string
    {
        if (!$this->image_path) {
            return asset('images/placeholder.jpg');
        }
        return asset('storage/' . ltrim($this->image_path, '/'));
    }
}
