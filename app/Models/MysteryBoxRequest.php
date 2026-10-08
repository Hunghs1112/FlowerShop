<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MysteryBoxRequest extends Model
{
    protected $fillable = [
        'request_id',
        'user_id',
        'name',
        'phone',
        'email',
        'style',
        'colors',
        'preferences',
        'flower_preferences',
        'budget_range',
        'surprise_level',
        'note',
        'delivery_address',
        'delivery_date',
        'status',
    ];

    protected $casts = [
        'colors' => 'array',
        'preferences' => 'array',
        'flower_preferences' => 'array',
        'delivery_date' => 'date',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeReviewing($query)
    {
        return $query->where('status', 'reviewing');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // Helpers
    public static function generateRequestId(): string
    {
        $lastId = self::max('id') ?? 0;
        return 'LNT-MB-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'new' => 'Mới',
            'reviewing' => 'Đang xem xét',
            'confirmed' => 'Đã xác nhận',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
            default => $this->status,
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'new' => 'badge-warning',
            'reviewing' => 'badge-info',
            'confirmed' => 'badge-success',
            'completed' => 'badge-success',
            'cancelled' => 'badge-secondary',
            default => 'badge-secondary',
        };
    }
}
