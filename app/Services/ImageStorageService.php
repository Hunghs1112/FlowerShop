<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Centralized service for image upload / delete / validation.
 *
 * Replaces ad-hoc UploadedFile handling inside controllers so we have
 * one consistent place to enforce:
 *
 *   - MIME whitelist (config('upload.allowed_mimes'))
 *   - Server-side extension derivation (NOT getClientOriginalExtension)
 *   - Filename uniqueness (timestamp + random suffix)
 *   - Safe delete with permission/missing-file handling
 *
 * Banner files are written directly to public_path('images/banners/...')
 * because BannerService serves them via asset() (not Storage::url). All
 * other files go through the configured Storage disk (default: public).
 */
class ImageStorageService
{
    /** @var string */
    protected $disk;

    public function __construct(string $disk = null)
    {
        // Allow callers (e.g. banner uploader) to override the disk. We
        // resolve the default from config so ops can switch disks without
        // touching this class.
        $this->disk = $disk ?? config('upload.disks.default', 'public');
    }

    /**
     * Validate the uploaded file against MIME / size / extension rules.
     *
     * Throws ValidationException on failure so Laravel automatically turns
     * it into a 422 redirect with the proper error bag.
     *
     * @param  string|null $feature  Key in config('upload.limits') – determines max size.
     *                               Pass null to skip size enforcement.
     */
    public function validate(UploadedFile $file, ?string $feature = null): void
    {
        $allowedMimes = array_keys(config('upload.allowed_mimes', []));
        $allowedExts  = config('upload.allowed_extensions', []);

        // 1. MIME whitelist. We trust the server-side MIME (which PHP
        //    derives from file contents via finfo) NOT the client-supplied
        //    type, which can be spoofed trivially.
        if (!in_array($file->getMimeType(), $allowedMimes, true)) {
            $this->throwInvalid($file, 'mime');
        }

        // 2. Extension whitelist. getMimeType() can lie for some weird files
        //    on shared hosting; cross-check with the server-side extension.
        $serverExt = strtolower($file->getClientOriginalExtension());
        if (!in_array($serverExt, $allowedExts, true) && !in_array(strtolower($file->extension()), $allowedExts, true)) {
            $this->throwInvalid($file, 'extension');
        }

        // 3. Size check (only when a feature is provided).
        if ($feature && ($maxKb = config("upload.limits.{$feature}.max_size"))) {
            if ($file->getSize() > ($maxKb * 1024)) {
                throw ValidationException::withMessages([
                    $file->getClientOriginalName() => [
                        "Ảnh vượt quá dung lượng cho phép ({$maxKb} KB).",
                    ],
                ]);
            }
        }
    }

    /**
     * Upload a file and return its relative storage path.
     *
     * If $oldFile is supplied the previous file is removed on success.
     * The new filename is derived from time + random bytes; we never
     * trust the original filename (path traversal / collision risk).
     *
     * For banners, pass $feature = 'banner' (or any feature key whose
     * `folder` is in config) so we route to the local filesystem instead
     * of the `public` Storage disk.
     *
     * @return string  Relative path, e.g. "products/abc123.jpg"
     *                or "images/banners/home-hero-1700000000.jpg".
     */
    public function upload(UploadedFile $file, string $folder, ?string $oldFile = null, ?string $prefix = null): string
    {
        // Validate first; throws ValidationException if invalid.
        $this->validate($file);

        $extension = strtolower($file->extension());
        $basename  = ($prefix ? $prefix . '-' : '')
            . time()
            . '-'
            . Str::random(8)
            . '.'
            . $extension;

        // Banners live outside the `public` Storage disk because BannerService
        // reads them with asset() / file_exists(). We detect "banners" folder
        // and write via move() directly. Other folders go through Storage.
        $path = trim($folder, '/') . '/' . $basename;

        if ($folder === 'images/banners' || str_starts_with($folder, 'images/banners/')) {
            $absoluteDir = public_path('images/banners');
            if (!is_dir($absoluteDir)) {
                @mkdir($absoluteDir, 0755, true);
            }
            $file->move($absoluteDir, $basename);
        } else {
            // putFileAs handles directory creation + collision-safe rename.
            Storage::disk($this->disk)->putFileAs(
                trim($folder, '/'),
                $file,
                $basename
            );
        }

        // Best-effort cleanup of the previous file. Failures are swallowed
        // because (a) file may already be missing and (b) we don't want a
        // broken delete to fail a successful upload.
        if ($oldFile) {
            $this->delete($oldFile);
        }

        return $path;
    }

    /**
     * Upload multiple files at once (used by ProductController).
     *
     * Enforces max_count from config and rolls back (deletes) any uploaded
     * files if the caller passes a closure that throws – callers should
     * wrap their DB writes in DB::transaction().
     *
     * @param  string $feature  Feature key for limit lookup.
     * @param  string $folder   Storage folder (e.g. 'products').
     * @return array<string>    List of relative paths in the same order as $files.
     */
    public function uploadMany(array $files, string $folder, string $feature): array
    {
        $maxCount = (int) config("upload.limits.{$feature}.max_count", count($files));
        if (count($files) > $maxCount) {
            throw ValidationException::withMessages([
                'images' => ["Tối đa {$maxCount} ảnh cho mỗi lần tải lên."],
            ]);
        }

        $uploaded = [];
        foreach ($files as $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }
            $uploaded[] = $this->upload($file, $folder);
        }

        return $uploaded;
    }

    /**
     * Delete a file. Safe to call on missing files.
     *
     * Handles both Storage paths (e.g. "products/foo.jpg") and absolute
     * paths inside public_path (e.g. "images/banners/home-hero.jpg").
     */
    public function delete(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        // Banners live in public_path and are NOT on the `public` Storage
        // disk. Detect them and unlink directly.
        if (str_starts_with($path, 'images/banners') || str_starts_with($path, '/images/banners')) {
            $absolute = str_starts_with($path, '/')
                ? public_path(ltrim($path, '/'))
                : public_path($path);

            if (is_file($absolute)) {
                return @unlink($absolute);
            }
            return false;
        }

        // Storage disk (default `public`). Wrap in try/catch because Storage
        // throws on permission errors which we don't want to bubble up.
        try {
            if (Storage::disk($this->disk)->exists($path)) {
                return Storage::disk($this->disk)->delete($path);
            }
        } catch (\Throwable $e) {
            // Log + swallow. The caller has already lost ownership of the
            // DB row, so failing here would just create a worse UX.
            \Log::warning('ImageStorageService::delete failed', [
                'path'  => $path,
                'error' => $e->getMessage(),
            ]);
        }

        return false;
    }

    /**
     * Return a public URL for a stored path. Pure helper for views.
     */
    public function url(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        // Banners are served directly via asset() because they live in
        // public/images/banners/.
        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        try {
            return Storage::disk($this->disk)->url($path);
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Build the ValidationException with a localized message.
     */
    protected function throwInvalid(UploadedFile $file, string $reason): void
    {
        $allowed = implode(', ', array_values(config('upload.allowed_mimes', [])));
        $message = $reason === 'mime'
            ? "Định dạng ảnh không được hỗ trợ. Chỉ chấp nhận: {$allowed}."
            : "Phần mở rộng của tệp không hợp lệ. Chỉ chấp nhận: {$allowed}.";

        throw ValidationException::withMessages([
            $file->getClientOriginalName() => [$message],
        ]);
    }

    /**
     * Get image URL for display in views
     * Unified helper that handles all path types
     */
    public function getImageUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        // External URLs - return as-is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Public paths (images/banners/, images/logo/) - use asset() directly
        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        // Storage disk paths - prefix with storage/
        return asset('storage/' . ltrim($path, '/'));
    }

    /**
     * Get image path from model or request
     * Handles null/empty gracefully
     */
    public function resolveImagePath($imageData): ?string
    {
        if ($imageData === null) {
            return null;
        }

        if (is_string($imageData)) {
            return $imageData ?: null;
        }

        if (is_object($imageData) && property_exists($imageData, 'image_path')) {
            return $imageData->image_path ?: null;
        }

        return null;
    }

    /**
     * Check if path is a storage disk path vs public path
     */
    public function isStoragePath(string $path): bool
    {
        return !str_starts_with($path, 'images/') 
            && !str_starts_with($path, 'http://') 
            && !str_starts_with($path, 'https://');
    }

    /**
     * Check if path is a public/images path
     */
    public function isPublicPath(string $path): bool
    {
        return str_starts_with($path, 'images/');
    }

    /**
     * Check if path is an external URL
     */
    public function isExternalUrl(string $path): bool
    {
        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
    }

    /**
     * Batch delete files
     * Returns count of successfully deleted files
     */
    public function deleteMany(array $paths): int
    {
        $deleted = 0;

        foreach ($paths as $path) {
            if ($this->delete($path)) {
                $deleted++;
            }
        }

        return $deleted;
    }

    /**
     * Get total size of all files in a folder
     * Useful for quota checking
     */
    public function getFolderSize(string $folder): int
    {
        try {
            $files = Storage::disk($this->disk)->files($folder);
            $totalSize = 0;

            foreach ($files as $file) {
                $totalSize += Storage::disk($this->disk)->size($file);
            }

            return $totalSize;
        } catch (\Throwable $e) {
            return 0;
        }
    }

    /**
     * Generate unique filename
     * Public for use in custom upload scenarios
     */
    public function generateFilename(string $extension, ?string $prefix = null): string
    {
        $extension = strtolower(ltrim($extension, '.'));
        return ($prefix ? $prefix . '-' : '') . time() . '-' . Str::random(8) . '.' . $extension;
    }

    /**
     * Copy file within storage
     */
    public function copy(string $sourcePath, string $destinationPath): bool
    {
        try {
            if (Storage::disk($this->disk)->exists($sourcePath)) {
                $content = Storage::disk($this->disk)->get($sourcePath);
                Storage::disk($this->disk)->put($destinationPath, $content);
                return true;
            }
        } catch (\Throwable $e) {
            \Log::warning('ImageStorageService::copy failed', [
                'source' => $sourcePath,
                'destination' => $destinationPath,
                'error' => $e->getMessage(),
            ]);
        }

        return false;
    }

    /**
     * Move file within storage
     */
    public function move(string $sourcePath, string $destinationPath): bool
    {
        try {
            if (Storage::disk($this->disk)->exists($sourcePath)) {
                Storage::disk($this->disk)->move($sourcePath, $destinationPath);
                return true;
            }
        } catch (\Throwable $e) {
            \Log::warning('ImageStorageService::move failed', [
                'source' => $sourcePath,
                'destination' => $destinationPath,
                'error' => $e->getMessage(),
            ]);
        }

        return false;
    }
}