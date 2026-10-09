<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUSES = [
        'new' => 'Mới',
        'confirmed' => 'Đã xác nhận',
        'completed' => 'Hoàn tất',
        'cancelled' => 'Đã hủy',
    ];

    protected $fillable = [
        'user_id', 'status', 'customer_name', 'customer_phone', 'customer_email',
        'zalo_id', 'delivery_address', 'delivery_date', 'delivery_time',
        'subtotal', 'shipping_fee', 'total', 'note', 'idempotency_key',
    ];

    protected $casts = [
        'delivery_date' => 'date',
        'subtotal' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function items(): HasMany { return $this->hasMany(OrderItem::class); }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
