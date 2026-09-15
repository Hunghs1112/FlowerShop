{{-- 
    Email thông báo đơn hàng mới gửi cho admin/shop owner
    Lâm Nhiên Thảo Flower Shop
    
    Features:
    - Clean, responsive HTML template
    - Full order details for admin review
    - Vietnamese content
    - Urgent visual indicators for new orders
    - HTML injection prevention via e() helper
--}}

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng mới #{{ $orderId }} - Lâm Nhiên Thảo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f0f0f0;
        }
        .email-wrapper {
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .email-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .email-header .subtitle {
            font-size: 14px;
            opacity: 0.9;
        }
        .alert-badge {
            display: inline-block;
            background-color: #ffc107;
            color: #333;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 10px;
            text-transform: uppercase;
        }
        .email-body {
            padding: 25px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }
        .customer-card {
            background-color: #e8f4fd;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
        .customer-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #cce5f4;
        }
        .customer-row:last-child {
            border-bottom: none;
        }
        .customer-label {
            color: #555;
            font-size: 14px;
        }
        .customer-value {
            font-weight: 500;
            font-size: 14px;
            text-align: right;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid #eee;
            border-radius: 8px;
            overflow: hidden;
        }
        .items-table thead {
            background-color: #f8f9fa;
        }
        .items-table th {
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            font-size: 12px;
            text-transform: uppercase;
        }
        .items-table th:last-child {
            text-align: right;
        }
        .items-table td {
            padding: 12px 15px;
            border-top: 1px solid #eee;
        }
        .items-table td:last-child {
            text-align: right;
        }
        .items-table .item-name {
            font-weight: 500;
        }
        .items-table .item-qty {
            color: #666;
            font-size: 12px;
        }
        .total-section {
            background-color: #28a745;
            color: white;
            border-radius: 8px;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-label {
            font-size: 16px;
        }
        .total-value {
            font-size: 24px;
            font-weight: 700;
        }
        .note-section {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-top: 20px;
            border-radius: 0 8px 8px 0;
        }
        .note-label {
            color: #856404;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .note-content {
            color: #856404;
            font-size: 14px;
        }
        .action-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-top: 25px;
            text-align: center;
        }
        .action-section p {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            font-size: 14px;
        }
        .email-footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 12px;
        }
        .email-footer a {
            color: #28a745;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        {{-- Header --}}
        <div class="email-header">
            <h1>🆕 ĐƠN HÀNG MỚI</h1>
            <p class="subtitle">Lâm Nhiên Thảo - Flowers & Gifts</p>
            <div class="alert-badge">Cần xử lý</div>
        </div>

        {{-- Body --}}
        <div class="email-body">
            {{-- Order ID --}}
            <div class="section">
                <div style="text-align: center; margin-bottom: 20px;">
                    <span style="font-size: 36px; font-weight: 700; color: #28a745;">#{{ $orderId }}</span>
                    <p style="color: #666; font-size: 14px;">{{ $orderDate }}</p>
                </div>
            </div>

            {{-- Customer Info --}}
            <div class="section">
                <div class="section-title">👤 Thông tin khách hàng</div>
                <div class="customer-card">
                    <div class="customer-row">
                        <span class="customer-label">Họ tên:</span>
                        <span class="customer-value">{{ $customerName }}</span>
                    </div>
                    <div class="customer-row">
                        <span class="customer-label">Số điện thoại:</span>
                        <span class="customer-value">
                            <a href="tel:{{ $customerPhone }}" style="color: #28a745; text-decoration: none;">
                                {{ $customerPhone }}
                            </a>
                        </span>
                    </div>
                    @if($customerEmail)
                    <div class="customer-row">
                        <span class="customer-label">Email:</span>
                        <span class="customer-value">{{ $customerEmail }}</span>
                    </div>
                    @endif
                    @if($customerZaloId)
                    <div class="customer-row">
                        <span class="customer-label">Zalo:</span>
                        <span class="customer-value">{{ $customerZaloId }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Order Items --}}
            <div class="section">
                <div class="section-title">📦 Sản phẩm đã đặt</div>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>SL</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderItems as $item)
                        <tr>
                            <td class="item-name">
                                {{ $item['name'] }}
                                <div class="item-qty">x{{ $item['quantity'] }}</div>
                            </td>
                            <td>{{ number_format($item['price'], 0, ',', '.') }}₫</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['subtotal'], 0, ',', '.') }}₫</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Total --}}
            <div class="total-section">
                <span class="total-label">💰 TỔNG CỘNG</span>
                <span class="total-value">{{ number_format($total, 0, ',', '.') }}₫</span>
            </div>

            {{-- Customer Note --}}
            @if($customerNote)
            <div class="note-section">
                <div class="note-label">📝 Ghi chú từ khách hàng</div>
                <div class="note-content">{{ $customerNote }}</div>
            </div>
            @endif

            {{-- Action --}}
            <div class="action-section">
                <p>Vui lòng liên hệ khách hàng để xác nhận đơn hàng</p>
                <a href="{{ url('/admin/inquiries/' . $orderId) }}" class="btn">
                    Xem chi tiết đơn hàng
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <div class="email-footer">
            <p>Email được gửi tự động từ <strong>Lâm Nhiên Thảo</strong></p>
            <p style="margin-top: 5px;">
                <a href="{{ config('app.url', '#') }}">Truy cập Admin Panel</a>
            </p>
        </div>
    </div>
</body>
</html>
