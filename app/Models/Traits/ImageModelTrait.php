<?php

namespace App\Models\Traits;

use App\Services\ImageStorageService;

/**
 * Trait for image models (ProductImage, ProductVariantImage, etc)
 * 
 * Provides:
 * - Unified image URL generation
 * - Image path manipulation
 * - Integration with ImageStorageService
 */
trait ImageModelTrait
{
    /**
     * Get the full URL for this image
     * Used in views
     */
    public function getImageUrl(): string
    {
        if (empty($this->image_path)) {
            return asset('images/placeholder.jpg');
        }

        // External URLs - return as-is
        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        // Public paths (images/banners/) - use asset() directly
        if (str_starts_with($this->image_path, 'images/')) {
            return asset($this->image_path);
        }

        // Storage disk paths - prefix with storage/
        return asset('storage/' . ltrim($this->image_path, '/'));
    }

    /**
     * Get image URL accessor
     * Use in views as $image->image_url
     */
    public function getImageUrlAttribute(): string
    {
        return $this->getImageUrl();
    }

    /**
     * Delete this image from storage
     */
    public function deleteFromStorage(): bool
    {
        if (empty($this->image_path)) {
            return false;
        }

        $service = app(ImageStorageService::class);
        return $service->delete($this->image_path);
    }

    /**
     * Boot trait to handle deletion
     */
    public static function bootImageModelTrait()
    {
        static::deleting(function ($model) {
            // Automatically clean up file when image record is deleted
            $model->deleteFromStorage();
        });
    }

    /**
     * Set as primary image (for image relations)
     */
    public function setPrimary(): bool
    {
        if (method_exists($this, 'getTable')) {
            $parentColumn = $this->getTable() === 'product_images' ? 'product_id' : 'product_variant_id';

            // Unset previous primary
            $this->newQuery()
                ->where($parentColumn, $this->getAttribute($parentColumn))
                ->update(['is_primary' => false]);

            // Set this as primary
            return $this->update(['is_primary' => true]);
        }

        return false;
    }

    /**
     * Check if this is the primary image
     */
    public function isPrimary(): bool
    {
        return $this->is_primary === true || $this->is_primary === 1;
    }

    /**
     * Get image dimensions if available
     * Can be extended to actually read from file
     */
    public function getDimensions(): ?array
    {
        if (empty($this->image_path)) {
            return null;
        }

        try {
            $url = $this->getImageUrl();
            // Could use getimagesize($url) but that's slow for remote files
            // For now just return the path for inspection
            return [
                'path' => $this->image_path,
                'url' => $url,
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }
}
