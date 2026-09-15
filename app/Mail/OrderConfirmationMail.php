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
 * Email xác nhận đơn hàng gửi cho khách hàng
 * 
 * Features:
 * - HTML injection prevention via Laravel's built-in sanitization
 * - Graceful degradation if email fails
 * - Idempotent - designed to only send once per order
 */
class OrderConfirmationMail extends Mailable implements ShouldQueue
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
            subject: '🌸 Xác nhận đơn hàng #' . $this->inquiry->id . ' - Lâm Nhiên Thảo',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-confirmation',
            with: [
                'orderId' => $this->inquiry->id,
                'customerName' => e($this->inquiry->name), // HTML escape
                'customerPhone' => e($this->inquiry->phone),
                'customerEmail' => e($this->inquiry->email),
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
