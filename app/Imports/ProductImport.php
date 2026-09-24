<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductImport implements ToModel, WithHeadingRow, WithValidation
{
    protected int $successCount = 0;

    public function model(array $row)
    {
        if (empty($row['ten_san_pham'])) {
            return null;
        }

        // Find subcategory by name
        $subcategoryId = null;
        $categoryId = null;
        if (!empty($row['danh_muc'])) {
            $subcategory = Subcategory::where('name', $row['danh_muc'])->first();
            if ($subcategory) {
                $subcategoryId = $subcategory->id;
                $categoryId = $subcategory->category_id;
            }
        }

        // Generate slug if not provided
        $slug = $row['slug'] ?? Str::slug($row['ten_san_pham'] ?? 'product-' . time());

        // Check if product with same slug exists
        $existingProduct = Product::where('slug', $slug)->first();
        if ($existingProduct) {
            $slug = $slug . '-' . time();
        }

        $this->successCount++;

        return new Product([
            'name' => $row['ten_san_pham'],
            'slug' => $slug,
            'sku' => $row['sku'] ?? null,
            'subcategory_id' => $subcategoryId,
            'category_id' => $categoryId,
            'price' => $row['gia'] ?? 0,
            'stock' => $row['ton_kho'] ?? 0,
            'short_description' => $row['mo_ta_ngan'] ?? null,
            'description' => $row['mo_ta'] ?? null,
            'length' => $row['chieu_dai'] ?? null,
            'min_order_quantity' => $row['sl_toi_thieu'] ?? 1,
            'origin' => $row['xuat_xu'] ?? null,
            'specification' => $row['quy_cach'] ?? null,
            'is_active' => true,
            'is_featured' => false,
        ]);
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    public function rules(): array
    {
        return [
            'ten_san_pham' => 'required|string|max:255',
            'danh_muc' => 'required|string',
            'gia' => 'required|numeric|min:0',
            'ton_kho' => 'required|integer|min:0',
            'chieu_dai' => 'nullable|string|max:50',
            'sl_toi_thieu' => 'nullable|integer|min:1',
            'xuat_xu' => 'nullable|string|max:100',
            'quy_cach' => 'nullable|string',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'ten_san_pham.required' => 'Tên sản phẩm là bắt buộc',
            'danh_muc.required' => 'Danh mục là bắt buộc',
            'gia.required' => 'Giá là bắt buộc',
            'ton_kho.required' => 'Tồn kho là bắt buộc',
        ];
    }
}
