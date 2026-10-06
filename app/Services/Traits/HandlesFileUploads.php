<?php

namespace App\Services\Traits;

use App\Services\ImageStorageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

/**
 * Trait for handling file/image uploads in CRUD operations
 * 
 * Provides:
 * - Single file upload
 * - Multiple file uploads
 * - File replacement
 * - File deletion
 * - Cleanup on rollback
 */
trait HandlesFileUploads
{
    /**
     * Image storage service instance
     */
    protected ImageStorageService $imageService;

    /**
     * Set the image storage service
     */
    protected function setImageService(ImageStorageService $service): void
    {
        $this->imageService = $service;
    }

    /**
     * Upload single file
     */
    protected function uploadFile(UploadedFile $file, string $folder): ?string
    {
        try {
            return $this->imageService->upload($file, $folder);
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }

    /**
     * Upload multiple files
     */
    protected function uploadFiles(array $files, string $folder): array
    {
        try {
            return $this->imageService->uploadMany($files, $folder);
        } catch (\Throwable $e) {
            report($e);
            return [];
        }
    }

    /**
     * Replace file (delete old, upload new)
     */
    protected function replaceFile(?string $oldPath, UploadedFile $newFile, string $folder): ?string
    {
        try {
            $newPath = $this->imageService->upload($newFile, $folder);
            if ($oldPath) $this->imageService->delete($oldPath);
            return $newPath;
        } catch (\Throwable $e) {
            report($e);
            return $oldPath; // Fallback to old file
        }
    }

    /**
     * Delete file
     */
    protected function deleteFile(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        try {
            return $this->imageService->delete($path);
        } catch (\Throwable $e) {
            report($e);
            return false;
        }
    }

    /**
     * Delete multiple files
     */
    protected function deleteFiles(array $paths): int
    {
        $deleted = 0;

        foreach ($paths as $path) {
            if ($this->deleteFile($path)) {
                $deleted++;
            }
        }

        return $deleted;
    }

    /**
     * Upload and attach file to model relation
     * 
     * Usage:
     * $service->uploadAndAttachImage($product, $file, 'product_images', 'products')
     */
    protected function uploadAndAttachImage(
        Model $model,
        UploadedFile $file,
        string $relationName,
        string $folder
    ): ?Model {
        $path = $this->uploadFile($file, $folder);

        if (!$path) {
            return null;
        }

        try {
            $relation = $model->$relationName()->create([
                'image_path' => $path,
                'sort_order' => $model->$relationName()->count(),
            ]);

            return $relation;
        } catch (\Throwable $e) {
            // Cleanup on failure
            $this->deleteFile($path);
            throw $e;
        }
    }

    /**
     * Upload and replace model's single image attribute
     * 
     * Usage:
     * $service->uploadAndReplaceImage($category, $file, 'image', 'categories')
     */
    protected function uploadAndReplaceImage(
        Model $model,
        UploadedFile $file,
        string $attributeName,
        string $folder
    ): bool {
        $newPath = $this->replaceFile($model->$attributeName, $file, $folder);

        if (!$newPath) {
            return false;
        }

        $model->update([$attributeName => $newPath]);
        return true;
    }
}
