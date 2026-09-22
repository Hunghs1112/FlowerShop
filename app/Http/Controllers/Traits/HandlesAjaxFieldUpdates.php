<?php

namespace App\Http\Controllers\Traits;

use App\Http\Responses\AjaxResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Trait for handling AJAX field updates (auto-save)
 * 
 * Provides standardized pattern for:
 * - Field validation
 * - Mass assignment protection
 * - Value transformation
 * - Consistent JSON responses
 * 
 * Usage in controller:
 * public function updateField(Request $request, Model $model)
 * {
 *     return $this->handleAjaxFieldUpdate($request, $model, [
 *         'allowed_fields' => ['name', 'title', 'description'],
 *         'rules' => ['name' => 'required|string|max:255'],
 *     ]);
 * }
 */
trait HandlesAjaxFieldUpdates
{
    /**
     * Handle AJAX field update with validation and transformation
     */
    public function handleAjaxFieldUpdate(
        Request $request,
        Model $model,
        array $options = []
    ): JsonResponse {
        $field = $request->input('field');
        $value = $request->input('value');

        // Required options
        $allowedFields = $options['allowed_fields'] ?? [];
        $rules = $options['rules'] ?? [];
        $transformers = $options['transformers'] ?? [];
        $beforeSave = $options['before_save'] ?? null;
        $afterSave = $options['after_save'] ?? null;

        // Validate field name (whitelist protection)
        if (empty($field) || !in_array($field, $allowedFields)) {
            return AjaxResponse::error('Trường không hợp lệ', [], 422);
        }

        // Validate field value
        $fieldRules = $rules[$field] ?? 'nullable';
        $validator = Validator::make(
            [$field => $value],
            [$field => $fieldRules],
            $this->getAjaxFieldMessages()
        );

        if ($validator->fails()) {
            return AjaxResponse::validationError(
                $validator->errors()->toArray(),
                $validator->errors()->first($field)
            );
        }

        // Transform value if transformer exists
        if (isset($transformers[$field]) && is_callable($transformers[$field])) {
            $value = $transformers[$field]($value, $model);
        }

        // Before save hook
        if ($beforeSave && is_callable($beforeSave)) {
            $result = $beforeSave($model, $field, $value);
            if ($result === false) {
                return AjaxResponse::error('Không thể lưu giá trị này', [], 422);
            }
            if (is_array($result)) {
                // Return value from transformer
                $value = $result['value'] ?? $value;
            }
        }

        try {
            // Update model
            $model->update([$field => $value]);

            // After save hook
            if ($afterSave && is_callable($afterSave)) {
                $afterSave($model, $field, $value);
            }

            return AjaxResponse::updated(
                "Đã lưu {$field}",
                [
                    'field' => $field,
                    'value' => $model->$field,
                    'display_value' => $this->formatFieldDisplay($field, $model->$field),
                ]
            );
        } catch (\Throwable $e) {
            \Log::error('AJAX field update failed', [
                'model' => class_basename($model),
                'field' => $field,
                'error' => $e->getMessage(),
            ]);

            return AjaxResponse::error('Lỗi khi lưu dữ liệu', [], 500);
        }
    }

    /**
     * Handle AJAX field update with custom logic
     * More flexible version that allows complete control
     */
    public function handleCustomAjaxFieldUpdate(
        Request $request,
        Model $model,
        callable $handler
    ): JsonResponse {
        $field = $request->input('field');
        $value = $request->input('value');

        try {
            $result = $handler($model, $field, $value);

            if ($result === false) {
                return AjaxResponse::error('Không thể lưu giá trị này', [], 422);
            }

            if (is_array($result)) {
                return AjaxResponse::updated($result['message'] ?? 'Đã lưu', $result['data'] ?? []);
            }

            return AjaxResponse::updated('Đã lưu');
        } catch (\Throwable $e) {
            \Log::error('AJAX custom field update failed', [
                'model' => class_basename($model),
                'field' => $field,
                'error' => $e->getMessage(),
            ]);

            return AjaxResponse::error('Lỗi khi lưu dữ liệu', [], 500);
        }
    }

    /**
     * Format field value for display in response
     * Override in controller for custom formatting
     */
    protected function formatFieldDisplay(string $field, $value): string
    {
        // Boolean fields
        if (in_array($field, ['is_active', 'is_featured', 'is_primary', 'is_published'])) {
            return $value ? 'Bật' : 'Tắt';
        }

        // Status fields
        if ($field === 'status') {
            $statusMap = [
                'published' => 'Xuất bản',
                'draft' => 'Nháp',
                'active' => 'Hoạt động',
                'inactive' => 'Không hoạt động',
            ];
            return $statusMap[$value] ?? $value;
        }

        // Default: return as string
        return (string) $value;
    }

    /**
     * Get error messages for AJAX field validation
     */
    protected function getAjaxFieldMessages(): array
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
            'in' => ':attribute không hợp lệ',
            'date' => ':attribute không hợp lệ',
        ];
    }

    /**
     * Quick helper to build allowed fields list from model fillable
     */
    protected function getAllowedFieldsFromModel(Model $model, array $exclude = []): array
    {
        $fields = $model->getFillable();

        return array_filter($fields, function ($field) use ($exclude) {
            return !in_array($field, array_merge($exclude, ['created_at', 'updated_at', 'deleted_at']));
        });
    }
}
