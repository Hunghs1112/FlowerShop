{{--
    Email thông báo khi có khách hàng B2C đăng ký mới
    Lâm Nhiên Thảo Flower Shop
--}}

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B2C - Khách hàng mới - {{ $inquiry->business_name }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Helvetica Neue', Arial, sans-serif; background: #f5ebe6; color: #3a2c24; }
        .email-wrapper { max-width: 640px; margin: 0 auto; background: #ffffff; }
        .email-header { background: linear-gradient(135deg, #5e4636 0%, #3a2c24 100%); color: #ffffff; padding: 28px 32px; text-align: center; }
        .email-header h1 { margin: 0; font-size: 22px; font-weight: 600; letter-spacing: 0.5px; }
        .email-header .subtitle { margin: 6px 0 0; opacity: 0.85; font-size: 14px; }
        .alert-badge { display: inline-block; margin-top: 14px; padding: 6px 14px; background: #f1c40f; color: #2c2c2c; font-size: 12px; font-weight: 700; text-transform: uppercase; border-radius: 999px; letter-spacing: 1px; }
        .email-body { padding: 28px 32px; }
        .section { margin-bottom: 24px; }
        .section-title { font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #5e4636; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #e6d3c6; }
        .info-card { background: #fcf8f5; border: 1px solid #e6d3c6; border-radius: 8px; padding: 16px 18px; }
        .info-row { display: flex; padding: 6px 0; font-size: 14px; line-height: 1.5; }
        .info-label { flex: 0 0 180px; color: #8c6e5c; font-weight: 500; }
        .info-value { flex: 1; color: #3a2c24; word-break: break-word; }
        .info-value a { color: #5e4636; text-decoration: none; }
        .action-section { text-align: center; margin-top: 28px; padding-top: 24px; border-top: 1px solid #e6d3c6; }
        .btn { display: inline-block; background: #5e4636; color: #ffffff !important; padding: 12px 28px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; }
        .email-footer { background: #f5ebe6; padding: 18px 32px; text-align: center; font-size: 12px; color: #8c6e5c; }
        .email-footer a { color: #5e4636; text-decoration: none; }
        @media only screen and (max-width: 600px) {
            .email-body, .email-header, .email-footer { padding-left: 18px; padding-right: 18px; }
            .info-row { flex-direction: column; }
            .info-label { flex: none; margin-bottom: 2px; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        {{-- Header --}}
        <div class="email-header">
            <h1>🤝 Đăng ký đối tác B2C</h1>
            <p class="subtitle">Lâm Nhiên Thảo - Flowers &amp; Gifts</p>
            <div class="alert-badge">Cần xử lý</div>
        </div>

        {{-- Body --}}
        <div class="email-body">
            {{-- Submission meta --}}
            <div class="section">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                    <strong style="font-size:16px;">#{{ str_pad($inquiry->id, 5, '0', STR_PAD_LEFT) }}</strong>
                    <span style="color:#6b6b6b; font-size:13px;">{{ $submittedAt }}</span>
                </div>
            </div>

            {{-- Business info --}}
            <div class="section">
                <div class="section-title">🏪 Thông tin doanh nghiệp</div>
                <div class="info-card">
                    <div class="info-row">
                        <div class="info-label">Loại hình:</div>
                        <div class="info-value">{{ $businessTypeLabel }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Tên cửa hàng / đơn vị:</div>
                        <div class="info-value">{{ $inquiry->business_name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Địa chỉ:</div>
                        <div class="info-value">{{ $inquiry->address }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Số năm hoạt động:</div>
                        <div class="info-value">{{ $inquiry->years_in_business }} năm</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Mạng xã hội:</div>
                        <div class="info-value"><a href="{{ $inquiry->social_media }}" target="_blank" rel="noopener">{{ $inquiry->social_media }}</a></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Mã số thuế:</div>
                        <div class="info-value">{{ $inquiry->tax_code }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Giấy phép KD:</div>
                        <div class="info-value">{{ $inquiry->business_license }}</div>
                    </div>
                </div>
            </div>

            {{-- Contact info --}}
            <div class="section">
                <div class="section-title">👤 Thông tin liên hệ</div>
                <div class="info-card">
                    <div class="info-row">
                        <div class="info-label">Họ và tên:</div>
                        <div class="info-value">{{ $inquiry->contact_name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Số điện thoại:</div>
                        <div class="info-value">
                            <a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a>
                        </div>
                    </div>
                    @if($inquiry->contact_email)
                        <div class="info-row">
                            <div class="info-label">Email liên hệ:</div>
                            <div class="info-value">
                                <a href="mailto:{{ $inquiry->contact_email }}">{{ $inquiry->contact_email }}</a>
                            </div>
                        </div>
                    @endif
                    <div class="info-row">
                        <div class="info-label">Email nhận VAT:</div>
                        <div class="info-value">
                            <a href="mailto:{{ $inquiry->vat_email }}">{{ $inquiry->vat_email }}</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action --}}
            <div class="action-section">
                <p style="margin:0 0 16px; color:#6b6b6b;">Vui lòng liên hệ khách hàng trong vòng 24 giờ làm việc.</p>
                <a href="{{ url('/admin/inquiries') }}" class="btn">Mở trang quản trị</a>
            </div>
        </div>

        {{-- Footer --}}
        <div class="email-footer">
            <p style="margin:0 0 4px;">Email được gửi tự động từ <strong>Lâm Nhiên Thảo</strong></p>
            <p style="margin:0;">
                <a href="{{ config('app.url', '#') }}">Truy cập Admin Panel</a>
            </p>
        </div>
    </div>
</body>
</html>
