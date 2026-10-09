<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order, public array $orderItems, public float $total) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Xác nhận đơn hàng #' . $this->order->id);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.order-confirmation', with: [
            'orderId' => $this->order->id,
            'customerName' => e($this->order->customer_name),
            'customerPhone' => e($this->order->customer_phone),
            'customerEmail' => e($this->order->customer_email),
            'orderItems' => $this->orderItems, 'total' => $this->total,
            'subtotal' => (float) $this->order->subtotal,
            'shippingFee' => $this->order->shipping_fee === null ? null : (float) $this->order->shipping_fee,
            'deliveryAddress' => e($this->order->delivery_address),
            'deliveryDate' => $this->order->delivery_date?->format('d/m/Y'),
            'deliveryTime' => $this->order->delivery_time ? substr($this->order->delivery_time, 0, 5) : null,
            'orderDate' => $this->order->created_at->format('d/m/Y H:i'),
            'customerNote' => e($this->order->note),
        ]);
    }

    public function attachments(): array { return []; }
}
