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
 * Banner files and page headers are written directly to public_path so
 * BannerService / asset() can read them without Storage symlinks.
 * All other files go through the configured Storage disk (default: public).
 */
class ImageStorageService
{
    /** @var string */
    protected $disk;

    public function __construct(string $disk = null)
    {
        $this->disk = $disk ?? config('upload.disks.default', 'public');
    }

    /**
     * Validate the uploaded file against MIME / size / extension rules.
     *
     * Throws ValidationException on failure so Laravel automatically turns
     * it into a 422 redirect with the proper error bag.
     *
     * @param  string|null $feature  Key in config('upload.limits') - determines max size.
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
                        "Anh vuot qua dung luong cho phep ({$maxKb} KB).",
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

        // Banners and page headers live outside the Storage disk because they
        // are read via asset() / file_exists(). Other folders go through Storage.
        $path = trim($folder, '/') . '/' . $basename;

        if ($folder === 'images/banners' || str_starts_with($folder, 'images/banners/')
            || $folder === 'images/pages'  || str_starts_with($folder, 'images/pages/')) {
            $absoluteDir = public_path($folder);
            if (!is_dir($absoluteDir)) {
                @mkdir($absoluteDir, 0755, true);
            }
            $file->move($absoluteDir, $basename);
        } else {
            Storage::disk($this->disk)->putFileAs(
                trim($folder, '/'),
                $file,
                $basename
            );
        }

        if ($oldFile) {
            $this->delete($oldFile);
        }

        return $path;
    }

    /**
     * Upload multiple files at once (used by ProductController).
     *
     * Enforces max_count from config.
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
                'images' => ["Toi da {$maxCount} anh cho moi lan tai len."],
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

        // Banners and page headers live in public_path, not on the Storage disk.
        if (str_starts_with($path, 'images/banners') || str_starts_with($path, '/images/banners')
            || str_starts_with($path, 'images/pages')  || str_starts_with($path, '/images/pages')) {
            $absolute = str_starts_with($path, '/')
                ? public_path(ltrim($path, '/'))
                : public_path($path);

            if (is_file($absolute)) {
                return @unlink($absolute);
            }
            return false;
        }

        // Storage disk (default public). Wrap in try/catch because Storage
        // throws on permission errors which we don't want to bubble up.
        try {
            if (Storage::disk($this->disk)->exists($path)) {
                return Storage::disk($this->disk)->delete($path);
            }
        } catch (\Throwable $e) {
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
            ? "Dinh dang anh khong duoc ho tro. Chi chap nhan: {$allowed}."
            : "Phan mo rong cua tep khong hop le. Chi chap nhan: {$allowed}.";

        throw ValidationException::withMessages([
            $file->getClientOriginalName() => [$message],
        ]);
    }
}
