<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $variant = $this->route('variant');
        $maxKb = (int) config('upload.limits.variant_image.max_size', 2048);

        return [
            'sku' => 'required|string|max:100|unique:product_variants,sku,' . $variant->id,
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:50',
            'price' => 'nullable|numeric|min:0|max:999999999',
            'compare_at_price' => 'nullable|numeric|min:0|max:999999999',
            'stock' => 'nullable|integer|min:0|max:999999',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => "nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:{$maxKb}",
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:product_variant_images,id',
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
            'compare_at_price.numeric' => 'Giá so sánh phải là số',
            'compare_at_price.min' => 'Giá so sánh không được âm',
            'stock.integer' => 'Số lượng tồn kho phải là số nguyên',
            'stock.min' => 'Số lượng tồn kho không được âm',
            'weight.numeric' => 'Cân nặng phải là số',
            'weight.min' => 'Cân nặng không được âm',
            'images.*.image' => 'File phải là ảnh',
            'images.*.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, webp',
            'images.*.max' => 'Kích thước ảnh không được vượt quá ' . config('upload.limits.variant_image.max_size', 2048) . ' KB',
            'delete_images.*.exists' => 'Một số ảnh không tồn tại',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Set boolean defaults
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
