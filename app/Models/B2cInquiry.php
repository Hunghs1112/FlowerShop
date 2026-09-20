<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class B2cInquiry extends Model
{
    protected $table = 'b2c_inquiries';

    protected $fillable = [
        'business_type',
        'contact_name',
        'contact_email',
        'business_name',
        'address',
        'phone',
        'years_in_business',
        'social_media',
        'tax_code',
        'vat_email',
        'business_license',
        'status',
    ];

    protected $casts = [
        'years_in_business' => 'integer',
    ];

    /** Available business type options. */
    public const BUSINESS_TYPES = [
        'traditional_shop' => 'Cửa hàng hoa truyền thống',
        'event_decor'      => 'Đơn vị trang trí sự kiện',
        'florist'          => 'Thợ cắm hoa (florist)',
        'online_shop'      => 'Cửa hàng online',
    ];

    public function getBusinessTypeLabelAttribute(): string
    {
        return self::BUSINESS_TYPES[$this->business_type] ?? $this->business_type;
    }
}
