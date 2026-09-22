<?php

namespace App\Constants;

/**
 * Centralized validation rule constants
 * 
 * Use these in FormRequests to maintain consistency and avoid string duplication
 */
class ValidationRules
{
    // String rules
    const REQUIRED_STRING = 'required|string';
    const OPTIONAL_STRING = 'nullable|string';

    // Name/Title fields
    const NAME_FIELD = 'required|string|max:255';
    const OPTIONAL_NAME = 'nullable|string|max:255';
    const TITLE_FIELD = 'required|string|max:255';
    const OPTIONAL_TITLE = 'nullable|string|max:255';

    // Slug field
    const SLUG_FIELD = 'nullable|string|max:255|unique:__TABLE__,slug';
    const SLUG_UPDATE = 'nullable|string|max:255|unique:__TABLE__,slug,__ID__';

    // Numeric fields
    const PRICE = 'required|numeric|min:0|max:999999999';
    const OPTIONAL_PRICE = 'nullable|numeric|min:0|max:999999999';
    const STOCK = 'required|integer|min:0|max:999999';
    const OPTIONAL_STOCK = 'nullable|integer|min:0|max:999999';

    // Email field
    const EMAIL = 'required|email|max:255|unique:users,email';
    const EMAIL_UPDATE = 'required|email|max:255|unique:users,email,__ID__';

    // Text fields
    const DESCRIPTION = 'nullable|string';
    const SHORT_DESCRIPTION = 'nullable|string|max:500';
    const EXCERPT = 'nullable|string|max:500';
    const CONTENT = 'required|string';
    const OPTIONAL_CONTENT = 'nullable|string';

    // Meta fields (SEO)
    const META_TITLE = 'nullable|string|max:255';
    const META_DESCRIPTION = 'nullable|string|max:500';

    // Boolean fields
    const IS_ACTIVE = 'boolean';
    const IS_FEATURED = 'boolean';
    const IS_PRIMARY = 'boolean';

    // File/Image fields
    const IMAGE_FILE = 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:__SIZE__';
    const IMAGE_REQUIRED = 'required|image|mimes:jpg,jpeg,png,gif,webp|max:__SIZE__';
    const IMAGES_MULTIPLE = 'nullable|array|max:__COUNT__';
    const IMAGES_FILE = 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:__SIZE__';

    // Relationship fields
    const EXISTS_CATEGORY = 'required|exists:categories,id';
    const EXISTS_SUBCATEGORY = 'required|exists:subcategories,id';
    const EXISTS_PRODUCT = 'required|exists:products,id';
    const OPTIONAL_VIP_LEVEL = 'nullable|exists:vip_levels,id';

    // Sorting
    const SORT_ORDER = 'nullable|integer|min:0';
    const PRIORITY = 'required|integer|min:0';

    // Pagination
    const PER_PAGE = 'nullable|integer|min:1|max:100';
    const PAGE = 'nullable|integer|min:1';

    /**
     * Get rule with replacements
     * 
     * @param string $rule Rule template with placeholders
     * @param array $replacements Key-value pairs for replacements
     * @return string Processed rule
     */
    public static function replace(string $rule, array $replacements = []): string
    {
        foreach ($replacements as $key => $value) {
            $rule = str_replace('__' . strtoupper($key) . '__', $value, $rule);
        }

        return $rule;
    }

    /**
     * Get file size limit from config
     */
    public static function getMaxFileSize(string $feature): int
    {
        return (int) config("upload.limits.{$feature}.max_size", 2048);
    }

    /**
     * Get file count limit from config
     */
    public static function getMaxFileCount(string $feature): int
    {
        return (int) config("upload.limits.{$feature}.max_count", 10);
    }

    /**
     * Get image rule with custom size
     */
    public static function imageRule(int $maxKb = 2048, bool $required = false): string
    {
        $base = $required ? 'required' : 'nullable';
        return "{$base}|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}";
    }

    /**
     * Get multiple images rule with custom limits
     */
    public static function multipleImagesRule(int $maxCount = 10, int $maxKb = 2048): array
    {
        return [
            'images' => "nullable|array|max:{$maxCount}",
            'images.*' => "file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
        ];
    }

    /**
     * Get password rules (uses Laravel's Password rules)
     */
    public static function passwordRules(): string
    {
        return 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$';
    }

    /**
     * Get common error messages
     */
    public static function messages(): array
    {
        return [
            'required' => ':attribute là bắt buộc',
            'email' => ':attribute không hợp lệ',
            'unique' => ':attribute đã tồn tại',
            'max' => ':attribute không được vượt quá :max ký tự',
            'min' => ':attribute phải có ít nhất :min ký tự',
            'numeric' => ':attribute phải là số',
            'integer' => ':attribute phải là số nguyên',
            'array' => ':attribute phải là danh sách',
            'mimes' => ':attribute phải có định dạng: :values',
            'confirmed' => ':attribute xác nhận không khớp',
            'exists' => ':attribute không tồn tại',
            'file' => ':attribute phải là tệp',
            'image' => ':attribute phải là ảnh',
            'boolean' => ':attribute phải là giá trị boolean',
        ];
    }
}
