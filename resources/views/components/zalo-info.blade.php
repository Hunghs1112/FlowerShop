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

