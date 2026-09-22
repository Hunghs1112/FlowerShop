<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $maxKb = (int) config('upload.limits.category_image.max_size', 2048);

        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'image' => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
            'hover_image' => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục là bắt buộc',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
            'slug.unique' => 'Slug danh mục đã tồn tại',
            'icon.max' => 'Icon không được vượt quá 50 ký tự',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpg, jpeg, png, gif, webp',
            'image.max' => 'Kích thước hình ảnh không được vượt quá ' . config('upload.limits.category_image.max_size', 2048) . ' KB',
            'hover_image.mimes' => 'Hình ảnh hover phải có định dạng: jpg, jpeg, png, gif, webp',
            'hover_image.max' => 'Kích thước hình ảnh hover không được vượt quá ' . config('upload.limits.category_image.max_size', 2048) . ' KB',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Auto-generate slug if empty
        if (empty($this->input('slug')) && !empty($this->input('name'))) {
            $this->merge(['slug' => Str::slug($this->input('name'))]);
        }

        // Set boolean defaults
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
}
