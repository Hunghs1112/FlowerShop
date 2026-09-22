<?php

namespace App\Services;

use App\Http\Responses\AjaxResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * Service for centralized AJAX field update operations
 * 
 * Handles:
 * - Field validation
 * - Value transformation
 * - Batch operations
 * - Event hooks
 */
class AjaxFieldService
{
    /**
     * Handle AJAX field update — main entry point called by controllers.
     *
     * @param  Model   $model        The Eloquent model to update
     * @param  string  $field        Field name from request
     * @param  mixed   $value        New value from request
     * @param  array   $fieldConfig  Map of field => validation rule string
     * @param  array   $hooks        Optional per-field callbacks run before save
     *                               Signature: fn(Model $model, mixed $value): void
     *                               If the hook updates the model itself it should
     *                               return a JsonResponse to short-circuit the save.
     */
    public function handleAjaxFieldUpdate(
        Model $model,
        string $field,
        mixed $value,
        array $fieldConfig,
        array $hooks = []
    ): JsonResponse {
        // Validate field is in whitelist
        if (!array_key_exists($field, $fieldConfig)) {
            return AjaxResponse::error('Trường không hợp lệ', [], 422);
        }

        // Validate value against its rule
        $validator = Validator::make(
            [$field => $value],
            [$field => $fieldConfig[$field]]
        );

        if ($validator->fails()) {
            return AjaxResponse::validationError(
                $validator->errors()->toArray(),
                $validator->errors()->first($field)
            );
        }

        // Handle boolean casting
        if (str_contains($fieldConfig[$field], 'boolean')) {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        // Run per-field hook — hook may handle the save itself and return a response
        if (isset($hooks[$field]) && is_callable($hooks[$field])) {
            $result = $hooks[$field]($model, $value);
            if ($result instanceof JsonResponse) {
                return $result;
            }
            // Hook handled the update — just return success
            return AjaxResponse::updated(
                "Đã lưu {$field}",
                ['field' => $field, 'value' => $model->fresh()->$field]
            );
        }

        // Default: update the field directly
        try {
            $model->update([$field => $value]);
            return AjaxResponse::updated(
                "Đã lưu {$field}",
                ['field' => $field, 'value' => $model->$field]
            );
        } catch (\Throwable $e) {
            \Log::error("AjaxFieldService: failed to update {$field}", ['error' => $e->getMessage()]);
            return AjaxResponse::error('Lỗi khi lưu dữ liệu', [], 500);
        }
    }

    /**
     * Update single field with validation (options-based API)
     */
    public function updateField(
        Model $model,
        string $field,
        $value,
        array $options = []
    ): JsonResponse {
        $allowedFields = $options['allowed_fields'] ?? [];
        $rules = $options['rules'] ?? [];
        $transformers = $options['transformers'] ?? [];

        // Validate field is allowed
        if (!in_array($field, $allowedFields)) {
            return AjaxResponse::error('Trường không hợp lệ', [], 422);
        }

        // Validate value
        $fieldRules = $rules[$field] ?? 'nullable';
        $validator = Validator::make(
            [$field => $value],
            [$field => $fieldRules]
        );

        if ($validator->fails()) {
            return AjaxResponse::validationError(
                $validator->errors()->toArray(),
                $validator->errors()->first($field)
            );
        }

        // Transform if transformer exists
        if (isset($transformers[$field]) && is_callable($transformers[$field])) {
            $value = $transformers[$field]($value, $model);
        }

        try {
            $model->update([$field => $value]);
            return AjaxResponse::updated(
                "Đã lưu {$field}",
                ['field' => $field, 'value' => $model->$field]
            );
        } catch (\Throwable $e) {
            \Log::error("Failed to update field: {$field}", ['error' => $e->getMessage()]);
            return AjaxResponse::error('Lỗi khi lưu dữ liệu', [], 500);
        }
    }

    /**
     * Update multiple fields at once
     */
    public function updateFields(
        Model $model,
        array $updates,
        array $options = []
    ): JsonResponse {
        $allowedFields = $options['allowed_fields'] ?? [];
        $rules = $options['rules'] ?? [];
        $transformers = $options['transformers'] ?? [];

        $toUpdate = [];
        $errors = [];

        foreach ($updates as $field => $value) {
            // Check allowed
            if (!in_array($field, $allowedFields)) {
                $errors[$field] = 'Trường không được phép';
                continue;
            }

            // Validate
            $fieldRules = $rules[$field] ?? 'nullable';
            $validator = Validator::make(
                [$field => $value],
                [$field => $fieldRules]
            );

            if ($validator->fails()) {
                $errors[$field] = $validator->errors()->first($field);
                continue;
            }

            // Transform
            if (isset($transformers[$field]) && is_callable($transformers[$field])) {
                $value = $transformers[$field]($value, $model);
            }

            $toUpdate[$field] = $value;
        }

        if (!empty($errors)) {
            return AjaxResponse::validationError($errors, 'Một số trường không hợp lệ');
        }

        try {
            $model->update($toUpdate);
            return AjaxResponse::updated(
                'Đã lưu tất cả thay đổi',
                ['fields' => array_keys($toUpdate)]
            );
        } catch (\Throwable $e) {
            \Log::error('Failed to update fields', ['error' => $e->getMessage()]);
            return AjaxResponse::error('Lỗi khi lưu dữ liệu', [], 500);
        }
    }

    /**
     * Toggle boolean field
     */
    public function toggleField(
        Model $model,
        string $field,
        array $allowedFields = []
    ): JsonResponse {
        if (!in_array($field, $allowedFields)) {
            return AjaxResponse::error('Trường không hợp lệ', [], 422);
        }

        try {
            $currentValue = $model->$field;
            $newValue = !$currentValue;
            $model->update([$field => $newValue]);

            return AjaxResponse::updated(
                $newValue ? "{$field} đã được bật" : "{$field} đã được tắt",
                [
                    'field' => $field,
                    'value' => $newValue,
                    'display' => $newValue ? 'Bật' : 'Tắt',
                ]
            );
        } catch (\Throwable $e) {
            \Log::error("Failed to toggle field: {$field}", ['error' => $e->getMessage()]);
            return AjaxResponse::error('Lỗi khi lưu dữ liệu', [], 500);
        }
    }

    /**
     * Increment field value
     */
    public function incrementField(
        Model $model,
        string $field,
        int $amount = 1,
        array $allowedFields = []
    ): JsonResponse {
        if (!in_array($field, $allowedFields)) {
            return AjaxResponse::error('Trường không hợp lệ', [], 422);
        }

        try {
            $model->increment($field, $amount);
            $model->refresh();

            return AjaxResponse::updated(
                "{$field} đã được cập nhật",
                [
                    'field' => $field,
                    'value' => $model->$field,
                ]
            );
        } catch (\Throwable $e) {
            \Log::error("Failed to increment field: {$field}", ['error' => $e->getMessage()]);
            return AjaxResponse::error('Lỗi khi lưu dữ liệu', [], 500);
        }
    }

    /**
     * Decrement field value
     */
    public function decrementField(
        Model $model,
        string $field,
        int $amount = 1,
        array $allowedFields = []
    ): JsonResponse {
        if (!in_array($field, $allowedFields)) {
            return AjaxResponse::error('Trường không hợp lệ', [], 422);
        }

        try {
            $model->decrement($field, $amount);
            $model->refresh();

            return AjaxResponse::updated(
                "{$field} đã được cập nhật",
                [
                    'field' => $field,
                    'value' => $model->$field,
                ]
            );
        } catch (\Throwable $e) {
            \Log::error("Failed to decrement field: {$field}", ['error' => $e->getMessage()]);
            return AjaxResponse::error('Lỗi khi lưu dữ liệu', [], 500);
        }
    }

    /**
     * Validate field rules
     */
    public function validateField(string $field, $value, string $rules): bool
    {
        $validator = Validator::make(
            [$field => $value],
            [$field => $rules]
        );

        return !$validator->fails();
    }

    /**
     * Get validation errors for field
     */
    public function getValidationErrors(string $field, $value, string $rules): array
    {
        $validator = Validator::make(
            [$field => $value],
            [$field => $rules]
        );

        return $validator->errors()->get($field) ?? [];
    }
}
