<?php

namespace App\Models\Traits;

/**
 * Trait for models that store image paths
 * 
 * Provides standardized:
 * - Image URL generation via accessors
 * - Fallback handling for missing/null images
 * - Support for both storage disk and public paths
 * - Placeholder images
 */
trait HasImageUrl
{
    /**
     * Get the image path attribute name
     * Override in model if using different attribute name
     */
    protected function getImagePathAttribute(): string
    {
        return 'image_path';
    }

    /**
     * Get placeholder image URL
     * Override in model for custom placeholders
     */
    protected function getPlaceholderImage(): string
    {
        return asset('images/placeholder.jpg');
    }

    /**
     * Get the full URL for the image
     * 
     * Handles:
     * - External URLs (http/https) - returns as-is
     * - Storage disk paths (products/abc.jpg) - uses asset() with storage prefix
     * - Public paths (images/banners/xyz.jpg) - uses asset() directly
     * - Null/empty - returns placeholder
     */
    protected function buildImageUrl(?string $imagePath): string
    {
        if (empty($imagePath)) {
            return $this->getPlaceholderImage();
        }

        // Already a full URL (http:// or https://)
        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return $imagePath;
        }

        // Banners and other public/images/ paths - use asset() directly
        if (str_starts_with($imagePath, 'images/')) {
            return asset($imagePath);
        }

        // Storage disk paths (products/, categories/, etc) - prefix with storage/
        return asset('storage/' . ltrim($imagePath, '/'));
    }

    /**
     * Generate image URL from path
     * Called by model accessors
     */
    public function getImageUrl(?string $imagePath = null): string
    {
        if ($imagePath === null) {
            $pathAttr = $this->getImagePathAttribute();
            $imagePath = $this->attributes[$pathAttr] ?? null;
        }

        return $this->buildImageUrl($imagePath);
    }

    /**
     * Check if model has a valid image
     */
    public function hasImage(): bool
    {
        $pathAttr = $this->getImagePathAttribute();
        $imagePath = $this->attributes[$pathAttr] ?? null;

        return !empty($imagePath) && $imagePath !== $this->getPlaceholderImage();
    }

    /**
     * Clear image (set to null)
     */
    public function clearImage(): void
    {
        $pathAttr = $this->getImagePathAttribute();
        $this->setAttribute($pathAttr, null);
    }
}
