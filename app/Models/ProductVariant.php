<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'sku',
        'name',
        'price',
        'stock',
        'description',
        'short_description',
        'color',
        'size',
        'attributes',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'attributes' => 'array',
    ];

    // Relationships
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductVariantImage::class)->orderBy('sort_order');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    // Helpers - Kế thừa thông tin từ product gốc nếu không có thông tin riêng
    public function getDisplayName(): string
    {
        return $this->name ?? $this->product->name;
    }

    public function getDisplayPrice(): float
    {
        return $this->price ?? $this->product->price;
    }

    public function getDisplayStock(): int
    {
        return $this->stock ?? $this->product->stock;
    }

    public function getDisplayDescription(): ?string
    {
        return $this->description ?? $this->product->description;
    }

    public function getDisplayShortDescription(): ?string
    {
        return $this->short_description ?? $this->product->short_description;
    }

    // Lấy ảnh chính - ưu tiên ảnh riêng, nếu không có thì dùng ảnh của product
    public function getPrimaryImage(): ?string
    {
        $primary = $this->images()->where('is_primary', true)->first();
        if ($primary) {
            return $primary->image_path;
        }
        
        $firstImage = $this->images()->first();
        if ($firstImage) {
            return $firstImage->image_path;
        }
        
        // Fallback to product's primary image
        return $this->product->getPrimaryImage();
    }

    public function getPrimaryImageUrl(): string
    {
        $imagePath = $this->getPrimaryImage();
        if (!$imagePath) {
            return 'https://via.placeholder.com/400x400/E5E7EB/6B7280?text=No+Image';
        }
        // Strip legacy 'images/' prefix since storage/app/public already contains category folders
        $path = preg_replace('#^/?images/#', '', $imagePath);
        return asset('storage/' . $path);
    }

    // Lấy tất cả ảnh - ưu tiên ảnh riêng, nếu không có thì dùng ảnh của product
    public function getAllImages()
    {
        $variantImages = $this->images;
        
        if ($variantImages->count() > 0) {
            return $variantImages;
        }
        
        // Fallback to product images
        return $this->product->productImages;
    }

    // Get full display data
    public function getFullDisplayData(): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->getDisplayName(),
            'price' => $this->getDisplayPrice(),
            'stock' => $this->getDisplayStock(),
            'description' => $this->getDisplayDescription(),
            'short_description' => $this->getDisplayShortDescription(),
            'color' => $this->color,
            'size' => $this->size,
            'attributes' => $this->getAttribute('attributes'),
            'primary_image_url' => $this->getPrimaryImageUrl(),
            'images' => $this->getAllImages(),
            'is_active' => $this->is_active,
        ];
    }
}
