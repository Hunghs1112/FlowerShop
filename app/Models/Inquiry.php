<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'source_slug',
        'name',
        'phone',
        'email',
        'zalo_id',
        'product_ids',
        'message',
        'order_data',
        'admin_notes',
        'status',
    ];

    protected $casts = [
        'product_ids' => 'array',
        'order_data' => 'array',
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

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Helpers
    public function getProducts()
    {
        if (!$this->product_ids) {
            return collect();
        }
        return Product::whereIn('id', $this->product_ids)->get();
    }
}
