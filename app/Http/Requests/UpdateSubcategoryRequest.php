<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateSubcategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $subcategory = $this->route('subcategory');
        $maxKb = (int) config('upload.limits.category_image.max_size', 2048);

        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:subcategories,slug,' . $subcategory->id,
            'description' => 'nullable|string',
            'image' => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Vui lòng chọn danh mục',
            'category_id.exists' => 'Danh mục không tồn tại',
            'name.required' => 'Tên danh mục con là bắt buộc',
            'name.max' => 'Tên danh mục con không được vượt quá 255 ký tự',
            'slug.unique' => 'Slug danh mục con đã tồn tại',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpg, jpeg, png, gif, webp',
            'image.max' => 'Kích thước hình ảnh không được vượt quá ' . config('upload.limits.category_image.max_size', 2048) . ' KB',
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
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
