<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

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

    // Relationships
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
