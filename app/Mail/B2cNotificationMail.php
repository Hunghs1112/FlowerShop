<?php

namespace App\Mail;

use App\Models\B2cInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Email thông báo khi có khách hàng B2C đăng ký mới.
 *
 * Gửi tới admin/shop owner với toàn bộ thông tin doanh nghiệp
 * khách hàng cung cấp qua form B2C.
 */
class B2cNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public B2cInquiry $inquiry)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[B2C] Khách hàng mới - ' . e($this->inquiry->business_name),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.b2c-notification',
            with: [
                'inquiry'          => $this->inquiry,
                'businessTypeLabel' => $this->inquiry->business_type_label,
                'submittedAt'      => $this->inquiry->created_at?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
