<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $maxKb = (int) config('upload.limits.variant_image.max_size', 2048);

        return [
            'sku' => 'required|string|max:100|unique:product_variants,sku',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:50',
            'price' => 'nullable|numeric|min:0|max:999999999',
            'stock' => 'nullable|integer|min:0|max:999999',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => "nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:{$maxKb}",
        ];
    }

    public function messages(): array
    {
        return [
            'sku.required' => 'SKU là bắt buộc',
            'sku.max' => 'SKU không được vượt quá 100 ký tự',
            'sku.unique' => 'SKU đã tồn tại',
            'name.max' => 'Tên variant không được vượt quá 255 ký tự',
            'color.max' => 'Màu sắc không được vượt quá 50 ký tự',
            'size.max' => 'Kích thước không được vượt quá 50 ký tự',
            'price.numeric' => 'Giá phải là số',
            'price.min' => 'Giá không được âm',
            'stock.integer' => 'Số lượng tồn kho phải là số nguyên',
            'stock.min' => 'Số lượng tồn kho không được âm',
            'images.*.image' => 'File phải là ảnh',
            'images.*.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, webp',
            'images.*.max' => 'Kích thước ảnh không được vượt quá ' . config('upload.limits.variant_image.max_size', 2048) . ' KB',
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
