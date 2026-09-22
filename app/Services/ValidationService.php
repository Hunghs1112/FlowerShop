<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Centralized Validation Service
 * 
 * Provides:
 * - Reusable validation rule sets
 * - Custom validation messages
 * - Validation helpers for common patterns
 * - Batch validation operations
 */
class ValidationService
{
    /**
     * Validate string field
     */
    public function validateString(string $value, int $maxLength = 255, ?string $fieldName = null): array
    {
        return $this->validate(
            [$fieldName ?? 'value' => $value],
            [$fieldName ?? 'value' => "required|string|max:{$maxLength}"]
        );
    }

    /**
     * Validate email
     */
    public function validateEmail(string $email, string $table = 'users', string $exceptId = null): array
    {
        $rule = "required|email|max:255|unique:{$table},email";
        if ($exceptId) {
            $rule .= ",{$exceptId}";
        }

        return $this->validate(['email' => $email], ['email' => $rule]);
    }

    /**
     * Validate slug
     */
    public function validateSlug(string $slug, string $table, string $exceptId = null): array
    {
        $rule = "nullable|string|max:255|unique:{$table},slug";
        if ($exceptId) {
            $rule .= ",{$exceptId}";
        }

        return $this->validate(['slug' => $slug], ['slug' => $rule]);
    }

    /**
     * Validate price
     */
    public function validatePrice($value): array
    {
        return $this->validate(
            ['price' => $value],
            ['price' => 'required|numeric|min:0|max:999999999']
        );
    }

    /**
     * Validate stock
     */
    public function validateStock($value): array
    {
        return $this->validate(
            ['stock' => $value],
            ['stock' => 'required|integer|min:0|max:999999']
        );
    }

    /**
     * Validate image file
     */
    public function validateImage($file, int $maxKb = 2048, bool $required = false): array
    {
        $rule = $required ? 'required' : 'nullable';
        $rule .= "|file|image|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}";

        return $this->validate(
            ['image' => $file],
            ['image' => $rule]
        );
    }

    /**
     * Validate multiple images
     */
    public function validateImages(array $files, int $maxCount = 10, int $maxKb = 2048): array
    {
        return $this->validate(
            ['images' => $files],
            [
                'images' => "nullable|array|max:{$maxCount}",
                'images.*' => "file|image|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
            ]
        );
    }

    /**
     * Validate URL
     */
    public function validateUrl(?string $url): array
    {
        return $this->validate(
            ['url' => $url],
            ['url' => 'nullable|url|max:500']
        );
    }

    /**
     * Validate date range
     */
    public function validateDateRange(?string $from, ?string $to): array
    {
        $data = ['from' => $from, 'to' => $to];
        $rules = [
            'from' => 'nullable|date',
            'to' => 'nullable|date',
        ];

        $validated = $this->validate($data, $rules);

        // Additional validation: from should be before to
        if ($from && $to && strtotime($from) > strtotime($to)) {
            throw ValidationException::withMessages([
                'from' => ['Start date must be before end date'],
            ]);
        }

        return $validated;
    }

    /**
     * Validate password
     */
    public function validatePassword(string $password, string $confirmation): array
    {
        return $this->validate(
            ['password' => $password, 'password_confirmation' => $confirmation],
            [
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required',
            ]
        );
    }

    /**
     * Validate username
     */
    public function validateUsername(string $username): array
    {
        return $this->validate(
            ['username' => $username],
            ['username' => 'required|string|max:100|alpha_dash']
        );
    }

    /**
     * Validate phone number
     */
    public function validatePhone(?string $phone): array
    {
        return $this->validate(
            ['phone' => $phone],
            ['phone' => 'nullable|string|max:20']
        );
    }

    /**
     * Validate address
     */
    public function validateAddress(?string $address): array
    {
        return $this->validate(
            ['address' => $address],
            ['address' => 'nullable|string|max:500']
        );
    }

    /**
     * Validate sort order
     */
    public function validateSortOrder(?int $sortOrder): array
    {
        return $this->validate(
            ['sort_order' => $sortOrder],
            ['sort_order' => 'nullable|integer|min:0']
        );
    }

    /**
     * Validate priority
     */
    public function validatePriority(int $priority): array
    {
        return $this->validate(
            ['priority' => $priority],
            ['priority' => 'required|integer|min:0']
        );
    }

    /**
     * Generic validation method
     */
    public function validate(array $data, array $rules, array $messages = []): array
    {
        $validator = Validator::make($data, $rules, $messages ?: $this->getDefaultMessages());

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        return $validator->validated();
    }

    /**
     * Soft validation - returns boolean instead of throwing
     */
    public function isValid(array $data, array $rules): bool
    {
        return !Validator::make($data, $rules, $this->getDefaultMessages())->fails();
    }

    /**
     * Get validation errors without throwing
     */
    public function getErrors(array $data, array $rules): array
    {
        $validator = Validator::make($data, $rules, $this->getDefaultMessages());
        return $validator->errors()->toArray();
    }

    /**
     * Get single field errors
     */
    public function getFieldErrors(array $data, array $rules, string $field): array
    {
        $validator = Validator::make($data, $rules, $this->getDefaultMessages());
        return $validator->errors()->get($field) ?? [];
    }

    /**
     * Get default validation messages in Vietnamese
     */
    protected function getDefaultMessages(): array
    {
        return [
            'required' => ':attribute là bắt buộc',
            'string' => ':attribute phải là text',
            'email' => ':attribute không hợp lệ',
            'unique' => ':attribute đã tồn tại',
            'max' => ':attribute không được vượt quá :max ký tự',
            'min' => ':attribute phải có ít nhất :min ký tự',
            'numeric' => ':attribute phải là số',
            'integer' => ':attribute phải là số nguyên',
            'boolean' => ':attribute phải là giá trị boolean',
            'array' => ':attribute phải là danh sách',
            'image' => ':attribute phải là ảnh',
            'mimes' => ':attribute phải có định dạng: :values',
            'url' => ':attribute phải là URL hợp lệ',
            'date' => ':attribute phải là ngày hợp lệ',
            'confirmed' => ':attribute xác nhận không khớp',
            'exists' => ':attribute không tồn tại',
            'file' => ':attribute phải là tệp',
            'alpha_dash' => ':attribute chỉ có thể chứa chữ, số, gạch ngang và gạch dưới',
        ];
    }

    /**
     * Get all product validation rules
     */
    public function getProductRules(string $productId = null): array
    {
        $maxImageKb = (int) config('upload.limits.product_images.max_size', 2048);
        $maxImageCount = (int) config('upload.limits.product_images.max_count', 10);

        $slugRule = 'nullable|string|max:255|unique:products,slug';
        if ($productId) {
            $slugRule .= "," . $productId;
        }

        return [
            'name' => 'required|string|max:255',
            'slug' => $slugRule,
            'subcategory_id' => 'required|exists:subcategories,id',
            'price' => 'required|numeric|min:0|max:999999999',
            'stock' => 'required|integer|min:0|max:999999',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'images' => "nullable|array|max:{$maxImageCount}",
            'images.*' => "file|image|mimes:jpg,jpeg,png,gif,webp|max:{$maxImageKb}",
        ];
    }

    /**
     * Get all category validation rules
     */
    public function getCategoryRules(string $categoryId = null): array
    {
        $maxImageKb = (int) config('upload.limits.category_image.max_size', 2048);

        $slugRule = 'nullable|string|max:255|unique:categories,slug';
        if ($categoryId) {
            $slugRule .= "," . $categoryId;
        }

        return [
            'name' => 'required|string|max:255',
            'slug' => $slugRule,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'image' => "nullable|file|image|mimes:jpg,jpeg,png,gif,webp|max:{$maxImageKb}",
            'hover_image' => "nullable|file|image|mimes:jpg,jpeg,png,gif,webp|max:{$maxImageKb}",
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    /**
     * Get all post validation rules
     */
    public function getPostRules(string $postId = null): array
    {
        $maxThumbnailKb = (int) config('upload.limits.post_thumbnail.max_size', 2048);

        $slugRule = 'nullable|string|max:255|unique:posts,slug';
        if ($postId) {
            $slugRule .= "," . $postId;
        }

        return [
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'thumbnail' => "nullable|file|image|mimes:jpg,jpeg,png,gif,webp|max:{$maxThumbnailKb}",
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get all page validation rules
     */
    public function getPageRules(string $pageId = null): array
    {
        $slugRule = 'nullable|string|max:255|unique:pages,slug';
        if ($pageId) {
            $slugRule .= "," . $pageId;
        }

        return [
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'content' => 'required|string',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get all user validation rules
     */
    public function getUserRules(string $userId = null): array
    {
        $emailRule = 'required|email|max:255|unique:users,email';
        if ($userId) {
            $emailRule .= "," . $userId;
        }

        return [
            'name' => 'required|string|max:255',
            'email' => $emailRule,
            'password' => 'nullable|confirmed|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'role' => 'required|in:admin,customer',
            'vip_level_id' => 'nullable|exists:vip_levels,id',
        ];
    }

    /**
     * Get all VIP level validation rules
     */
    public function getVipLevelRules(string $vipLevelId = null): array
    {
        $nameRule = 'required|string|max:100|unique:vip_levels,name';
        if ($vipLevelId) {
            $nameRule .= "," . $vipLevelId;
        }

        return [
            'name' => $nameRule,
            'description' => 'nullable|string|max:500',
            'priority' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ];
    }
}
