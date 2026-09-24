<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductTemplateExport implements FromArray, WithHeadings
{
    protected array $subcategories;

    public function __construct(array $subcategories = [])
    {
        $this->subcategories = $subcategories;
    }

    public function array(): array
    {
        // Sample data row
        return [
            [
                'Hoa Hồng Đỏ',
                'hoa-hong-do',
                'HR001',
                $this->subcategories[0] ?? 'Tên danh mục con',
                50000,
                100,
                'Hoa hồng đỏ tươi, đẹp',
                'Mô tả chi tiết về sản phẩm...',
                '50cm',
                10,
                'Việt Nam',
                'Bó 10 bông',
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'ten_san_pham',
            'slug',
            'sku',
            'danh_muc',
            'gia',
            'ton_kho',
            'mo_ta_ngan',
            'mo_ta',
            'chieu_dai',
            'sl_toi_thieu',
            'xuat_xu',
            'quy_cach',
        ];
    }
}
