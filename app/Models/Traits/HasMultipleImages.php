<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Collection;

/**
 * Trait for models that have multiple images through a relation
 * 
 * Provides:
 * - Primary image accessors
 * - Image collection helpers
 * - Image URL generation
 */
trait HasMultipleImages
{
    /**
     * Get the primary image path
     * Used by views to display main image
     */
    public function getPrimaryImageUrl(): string
    {
        if ($primary = $this->primaryImage()) {
            return $primary->getImageUrl();
        }

        return $this->getPlaceholderImage() ?? asset('images/placeholder.jpg');
    }

    /**
     * Get all image URLs
     */
    public function getImageUrls(): Collection
    {
        return $this->images()->get()->map(function ($image) {
            return [
                'id' => $image->id,
                'url' => $image->getImageUrl(),
                'path' => $image->image_path,
            ];
        });
    }

    /**
     * Get the primary/main image
     * Override in model to customize which image is considered primary
     */
    public function primaryImage()
    {
        if (method_exists($this, 'images')) {
            return $this->images()
                ->where('is_primary', true)
                ->orWhere('sort_order', 0)
                ->first();
        }

        return null;
    }

    /**
     * Get thumbnail image URL (first image or primary)
     */
    public function getThumbnailUrl(): string
    {
        return $this->getPrimaryImageUrl();
    }

    /**
     * Get placeholder image
     */
    protected function getPlaceholderImage(): string
    {
        return asset('images/placeholder.jpg');
    }

    /**
     * Check if model has any images
     */
    public function hasImages(): bool
    {
        return $this->images()->exists();
    }

    /**
     * Get image count
     */
    public function getImageCount(): int
    {
        return $this->images()->count();
    }

    /**
     * Get images with URLs
     */
    public function getImagesWithUrls(): array
    {
        return $this->images()
            ->orderBy('sort_order')
            ->get()
            ->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => $image->getImageUrl(),
                    'path' => $image->image_path,
                    'sort_order' => $image->sort_order,
                    'is_primary' => $image->is_primary ?? false,
                ];
            })
            ->toArray();
    }
}
