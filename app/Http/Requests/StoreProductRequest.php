<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $maxKb = (int) config('upload.limits.product_images.max_size', 2048);
        $maxCnt = (int) config('upload.limits.product_images.max_count', 10);

        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric|min:0|max:999999999',
            'stock' => 'required|integer|min:0|max:999999',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'length' => 'nullable|string|max:50',
            'min_order_quantity' => 'nullable|integer|min:1',
            'origin' => 'nullable|string|max:100',
            'specification' => 'nullable|string',
            'unit' => 'required|string|max:20',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'images' => "nullable|array|max:{$maxCnt}",
            'images.*' => "file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự',
            'category_id.required' => 'Vui lòng chọn danh mục chính',
            'category_id.exists' => 'Danh mục chính không tồn tại',
            'subcategory_id.exists' => 'Danh mục con không tồn tại',
            'price.required' => 'Giá sản phẩm là bắt buộc',
            'price.numeric' => 'Giá sản phẩm phải là số',
            'price.min' => 'Giá sản phẩm không được âm',
            'stock.required' => 'Số lượng tồn kho là bắt buộc',
            'stock.integer' => 'Số lượng tồn kho phải là số nguyên',
            'stock.min' => 'Số lượng tồn kho không được âm',
            'slug.unique' => 'Slug sản phẩm đã tồn tại',
            'images.max' => 'Tối đa ' . config('upload.limits.product_images.max_count', 10) . ' hình ảnh',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpg, jpeg, png, gif, webp',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá ' . config('upload.limits.product_images.max_size', 2048) . ' KB',
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
            'is_featured' => $this->boolean('is_featured', false),
        ]);
    }
}
