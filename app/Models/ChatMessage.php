<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_admin',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'is_read' => 'boolean',
    ];

    /**
     * Get the user that owns the message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to get messages for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId)
                     ->orderBy('created_at', 'asc');
    }

    /**
     * Scope a query to get unread messages.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope a query to get messages from admin.
     */
    public function scopeFromAdmin($query)
    {
        return $query->where('is_admin', true);
    }

    /**
     * Scope a query to get messages from customers.
     */
    public function scopeFromCustomer($query)
    {
        return $query->where('is_admin', false);
    }
}
