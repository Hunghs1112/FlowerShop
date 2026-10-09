<?php

namespace App\Http\Controllers\Traits;

use App\Services\ImageStorageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

/**
 * Reusable AJAX image upload / delete helpers for admin controllers.
 *
 * Controllers using this trait must inject ImageStorageService into
 * $this->images (usually via constructor DI).
 *
 * Usage example:
 *
 *   // Single-image field upload (input name = 'images' array or 'file')
 *   public function uploadImage(Request $request, Category $category): JsonResponse
 *   {
 *       return $this->handleSingleImageUpload(
 *           $request, $category,
 *           dbField: 'image',
 *           folder:  config('upload.disks.folders.category', 'categories'),
 *           imageUrlAccessor: 'image_url',
 *           successMessage: 'Đã tải ảnh lên',
 *       );
 *   }
 *
 *   // Delete a single-image field
 *   public function deleteImage(Category $category): JsonResponse
 *   {
 *       return $this->handleImageDelete(
 *           $category,
 *           dbField: 'image',
 *           notFoundMessage: 'Danh mục không có ảnh',
 *           successMessage:  'Đã xóa ảnh',
 *       );
 *   }
 */
trait HandlesImageUpload
{
    /**
     * Upload one image to $folder, save the path in $model->$dbField,
     * delete the previous file (if any), and return a JSON response.
     *
     * Accepts the file from any of these request keys (in order):
     *   images[0]  (array upload from the Dropzone-style widget)
     *   file       (legacy single-file key)
     *
     * @param  string        $dbField         Column name on the model (e.g. 'image', 'hover_image')
     * @param  string        $folder          Storage folder (e.g. 'categories')
     * @param  string        $imageUrlAccessor  Model accessor name for the public URL (e.g. 'image_url')
     * @param  string        $successMessage  Text returned on success
     */
    protected function handleSingleImageUpload(
        Request $request,
        Model $model,
        string $dbField,
        string $folder,
        string $imageUrlAccessor = 'image_url',
        string $successMessage = 'Đã tải ảnh lên'
    ): JsonResponse {
        // Accept both 'images' (array) and 'file' (single) input names
        $file = $this->resolveUploadedFile($request);

        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn một ảnh hợp lệ',
            ], 422);
        }

        $request->validate([
            'images'   => 'nullable|array|max:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'file'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $oldPath   = $model->$dbField;
        $imagePath = null;

        try {
            $imagePath = $this->images->upload($file, $folder);
            $model->update([$dbField => $imagePath]);

            // Delete old file only after DB update succeeds
            if ($oldPath) {
                $this->images->delete($oldPath);
            }

            $model->refresh();

            return response()->json([
                'success'   => true,
                'message'   => $successMessage,
                'image_url' => $model->$imageUrlAccessor,
            ]);
        } catch (\Throwable $e) {
            // Roll back the uploaded file so we don't leave orphans
            if ($imagePath) {
                $this->images->delete($imagePath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tải ảnh: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Clear an image field on a model: null the DB column and delete the file.
     *
     * @param  string  $dbField          Column name (e.g. 'image')
     * @param  string  $notFoundMessage  Returned when field is already empty
     * @param  string  $successMessage   Returned on success
     */
    protected function handleImageDelete(
        Model $model,
        string $dbField,
        string $notFoundMessage = 'Không có ảnh để xóa',
        string $successMessage  = 'Đã xóa ảnh'
    ): JsonResponse {
        if (!$model->$dbField) {
            return response()->json([
                'success' => false,
                'message' => $notFoundMessage,
            ], 404);
        }

        $path = $model->$dbField;
        $model->update([$dbField => null]);
        $this->images->delete($path);

        return response()->json([
            'success' => true,
            'message' => $successMessage,
        ]);
    }

    /**
     * Resolve the uploaded file from either 'images[0]' or 'file' input.
     */
    private function resolveUploadedFile(Request $request): ?UploadedFile
    {
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            return is_array($files) ? ($files[0] ?? null) : $files;
        }

        if ($request->hasFile('file')) {
            return $request->file('file');
        }

        return null;
    }
}
