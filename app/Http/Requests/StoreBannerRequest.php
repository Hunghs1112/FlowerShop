<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Vui lòng chọn ảnh banner',
            'image.image' => 'File phải là ảnh',
            'image.mimes' => 'Ảnh phải có định dạng: jpg, jpeg, png, gif, webp',
            'image.max' => 'Ảnh không được vượt quá 4MB',
            'button_link.url' => 'Link phải là URL hợp lệ',
            'title.max' => 'Tiêu đề banner không được vượt quá 255 ký tự',
            'subtitle.max' => 'Phụ đề banner không được vượt quá 500 ký tự',
            'button_text.max' => 'Văn bản nút không được vượt quá 100 ký tự',
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
