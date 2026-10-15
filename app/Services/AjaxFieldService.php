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

}
