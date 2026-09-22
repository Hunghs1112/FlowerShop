<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVipLevelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|unique:vip_levels,name',
            'description' => 'nullable|string|max:500',
            'priority' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên cấp VIP là bắt buộc',
            'name.max' => 'Tên cấp VIP không được vượt quá 100 ký tự',
            'name.unique' => 'Tên cấp VIP đã tồn tại',
            'priority.required' => 'Mức ưu tiên là bắt buộc',
            'priority.integer' => 'Mức ưu tiên phải là số nguyên',
            'priority.min' => 'Mức ưu tiên không được âm',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Set boolean defaults
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
}
