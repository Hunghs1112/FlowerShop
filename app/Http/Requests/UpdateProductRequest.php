<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $product = $this->route('product');
        $maxKb = (int) config('upload.limits.product_images.max_size', 2048);
        $maxCnt = (int) config('upload.limits.product_images.max_count', 10);

        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'subcategory_id' => 'required|exists:subcategories,id',
            'price' => 'required|numeric|min:0|max:999999999',
            'stock' => 'required|integer|min:0|max:999999',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'images' => "nullable|array|max:{$maxCnt}",
            'images.*' => "file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:product_images,id',
            'primary_image' => 'nullable|exists:product_images,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự',
            'subcategory_id.required' => 'Vui lòng chọn danh mục con',
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
            'delete_images.*.exists' => 'Một số hình ảnh không tồn tại',
            'primary_image.exists' => 'Hình ảnh chính không tồn tại',
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
            'is_featured' => $this->boolean('is_featured'),
        ]);
    }
}
