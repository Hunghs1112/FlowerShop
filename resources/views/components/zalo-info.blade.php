@props(['showQr' => true, 'compact' => false])

@php
    $zaloOaId = config('services.zalo.oa_id');
    $zaloLink = $zaloOaId ? "https://zalo.me/{$zaloOaId}" : null;
    $settings = app(\App\Services\SettingService::class)->getAllSettings();
@endphp

@if(!$compact)
<div class="zalo-info-card">
    <div class="zalo-info-header">
        <svg width="32" height="32" viewBox="0 0 48 48" fill="none">
            <rect width="48" height="48" rx="12" fill="#0068FF"/>
            <path d="M24 10C16.268 10 10 15.82 10 23c0 3.398 1.478 6.467 3.846 8.723L12 38l6.744-2.115C20.136 36.628 22.017 37 24 37c7.732 0 14-5.82 14-13s-6.268-13-14-13z" fill="white"/>
        </svg>
        <div>
            <h3 class="zalo-title">Nhận thông báo qua Zalo</h3>
            <p class="zalo-subtitle">Cập nhật trạng thái đơn hàng nhanh chóng</p>
        </div>
    </div>

    <div class="zalo-info-content">
        <div class="zalo-benefits">
            <div class="benefit-item">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Xác nhận đơn hàng tức thì</span>
            </div>
            <div class="benefit-item">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Theo dõi tiến trình giao hàng</span>
            </div>
            <div class="benefit-item">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Hỗ trợ và tư vấn nhanh chóng</span>
            </div>
        </div>

        @if($showQr && isset($settings['zalo_qr']) && $settings['zalo_qr'])
            <div class="zalo-qr-section">
                <p class="zalo-qr-label">Quét mã QR để kết nối với chúng tôi:</p>
                <div class="zalo-qr-code">
                    <img src="{{ asset('storage/' . $settings['zalo_qr']) }}" alt="Zalo QR Code">
                </div>
                @if($zaloLink)
                    <a href="{{ $zaloLink }}" target="_blank" class="btn btn-zalo">
                        <svg width="20" height="20" viewBox="0 0 48 48" fill="none">
                            <rect width="48" height="48" rx="12" fill="currentColor"/>
                            <path d="M24 10C16.268 10 10 15.82 10 23c0 3.398 1.478 6.467 3.846 8.723L12 38l6.744-2.115C20.136 36.628 22.017 37 24 37c7.732 0 14-5.82 14-13s-6.268-13-14-13z" fill="white"/>
                        </svg>
                        Mở Zalo
                    </a>
                @endif
            </div>
        @endif

        <div class="zalo-how-to">
            <details>
                <summary>Làm thế nào để lấy Zalo ID của tôi?</summary>
                <div class="how-to-content">
                    <ol>
                        <li>Mở ứng dụng <strong>Zalo</strong> trên điện thoại</li>
                        <li>Vào <strong>Cá nhân</strong> (biểu tượng người ở góc phải dưới)</li>
                        <li>Nhấn vào <strong>Cài đặt</strong> (biểu tượng bánh răng)</li>
                        <li>Chọn <strong>Tài khoản và bảo mật</strong></li>
                        <li>Xem <strong>Zalo ID</strong> của bạn (thường là số điện thoại hoặc tên người dùng)</li>
                    </ol>
                    <p class="note">💡 <strong>Mẹo:</strong> Bạn có thể điền số điện thoại đã đăng ký Zalo thay cho Zalo ID</p>
                </div>
            </details>
        </div>
    </div>
</div>

@else
{{-- Compact version for inline use --}}
<div class="zalo-info-compact">
    <svg width="24" height="24" viewBox="0 0 48 48" fill="none">
        <rect width="48" height="48" rx="12" fill="#0068FF"/>
        <path d="M24 10C16.268 10 10 15.82 10 23c0 3.398 1.478 6.467 3.846 8.723L12 38l6.744-2.115C20.136 36.628 22.017 37 24 37c7.732 0 14-5.82 14-13s-6.268-13-14-13z" fill="white"/>
    </svg>
    <div class="zalo-compact-text">
        <strong>Nhận thông báo qua Zalo</strong>
        <p>Nhập Zalo ID để nhận xác nhận đơn hàng và cập nhật giao hàng</p>
    </div>
</div>
@endif

<style>
    .zalo-info-card {
        background: linear-gradient(135deg, #0068FF 0%, #0052CC 100%);
        border-radius: var(--radius-lg);
        padding: var(--space-6);
        color: white;
        margin: var(--space-6) 0;
    }

    .zalo-info-header {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        margin-bottom: var(--space-6);
    }

    .zalo-title {
        font-size: var(--font-size-xl);
        font-weight: var(--font-bold);
        margin: 0;
        color: white;
    }

    .zalo-subtitle {
        font-size: var(--font-size-sm);
        margin: var(--space-1) 0 0;
        opacity: 0.9;
    }

    .zalo-info-content {
        background: rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-md);
        padding: var(--space-5);
        backdrop-filter: blur(10px);
    }

    .zalo-benefits {
        display: grid;
        gap: var(--space-3);
        margin-bottom: var(--space-5);
    }

    .benefit-item {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        font-size: var(--font-size-sm);
    }

    .benefit-item svg {
        flex-shrink: 0;
        color: #4ADE80;
    }

    .zalo-qr-section {
        text-align: center;
        padding: var(--space-5) 0;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        margin: var(--space-5) 0;
    }

    .zalo-qr-label {
        font-size: var(--font-size-sm);
        margin-bottom: var(--space-4);
        opacity: 0.9;
    }

    .zalo-qr-code {
        display: inline-block;
        padding: var(--space-3);
        background: white;
        border-radius: var(--radius-md);
        margin-bottom: var(--space-4);
    }

    .zalo-qr-code img {
        width: 180px;
        height: 180px;
        display: block;
    }

    .btn-zalo {
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-3) var(--space-6);
        background: white;
        color: #0068FF;
        border-radius: var(--radius-full);
        font-weight: var(--font-semibold);
        text-decoration: none;
        transition: all var(--transition-base);
    }

    .btn-zalo:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .zalo-how-to {
        margin-top: var(--space-5);
    }

    .zalo-how-to details {
        background: rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-md);
        padding: var(--space-4);
    }

    .zalo-how-to summary {
        font-weight: var(--font-semibold);
        cursor: pointer;
        user-select: none;
        list-style: none;
    }

    .zalo-how-to summary::-webkit-details-marker {
        display: none;
    }

    .zalo-how-to summary::before {
        content: '▶';
        display: inline-block;
        margin-right: var(--space-2);
        transition: transform 0.2s;
    }

    .zalo-how-to details[open] summary::before {
        transform: rotate(90deg);
    }

    .how-to-content {
        margin-top: var(--space-4);
        padding-top: var(--space-4);
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .how-to-content ol {
        margin: 0 0 var(--space-4) var(--space-4);
        padding: 0;
    }

    .how-to-content li {
        margin-bottom: var(--space-2);
        font-size: var(--font-size-sm);
        line-height: 1.6;
    }

    .how-to-content .note {
        background: rgba(74, 222, 128, 0.2);
        border-left: 3px solid #4ADE80;
        padding: var(--space-3);
        border-radius: var(--radius-sm);
        font-size: var(--font-size-sm);
        margin: 0;
    }

    /* Compact version */
    .zalo-info-compact {
        display: flex;
        align-items: flex-start;
        gap: var(--space-3);
        padding: var(--space-4);
        background: #F0F9FF;
        border: 1px solid #0068FF;
        border-radius: var(--radius-md);
        margin: var(--space-4) 0;
    }

    .zalo-info-compact svg {
        flex-shrink: 0;
    }

    .zalo-compact-text strong {
        display: block;
        color: #0068FF;
        margin-bottom: var(--space-1);
    }

    .zalo-compact-text p {
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
        margin: 0;
    }

    @media (max-width: 640px) {
        .zalo-info-card {
            padding: var(--space-4);
        }

        .zalo-info-header {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        .zalo-qr-code img {
            width: 150px;
            height: 150px;
        }
    }
</style>
