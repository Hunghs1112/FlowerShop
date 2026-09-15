<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Email thông báo đơn hàng mới gửi cho admin/shop owner
 * 
 * Features:
 * - HTML injection prevention via Laravel's built-in sanitization
 * - Graceful degradation if email fails
 * - Includes full order details for admin review
 */
class AdminOrderNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Inquiry $inquiry,
        public array $orderItems,
        public float $total
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🆕 Đơn hàng mới #' . $this->inquiry->id . ' - ' . e($this->inquiry->name),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-order-notification',
            with: [
                'orderId' => $this->inquiry->id,
                'customerName' => e($this->inquiry->name),
                'customerPhone' => e($this->inquiry->phone),
                'customerEmail' => e($this->inquiry->email),
                'customerZaloId' => e($this->inquiry->zalo_id),
                'orderItems' => $this->orderItems,
                'total' => $this->total,
                'orderDate' => $this->inquiry->created_at->format('d/m/Y H:i'),
                'customerNote' => e($this->inquiry->message),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
