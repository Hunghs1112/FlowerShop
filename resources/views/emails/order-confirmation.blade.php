{{-- 
    Email xác nhận đơn hàng gửi cho khách hàng
    Lâm Nhiên Thảo Flower Shop
    
    Features:
    - Clean, responsive HTML template
    - Vietnamese content
    - Mobile-friendly design
    - Order summary with items
    - HTML injection prevention via e() helper
--}}

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng #{{ $orderId }}</title>
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
            background-color: #f8f4f0;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .email-header {
            background: linear-gradient(135deg, #d4a574 0%, #c9302c 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .email-header h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .email-header p {
            opacity: 0.9;
            font-size: 14px;
        }
        .email-body {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .order-info {
            background-color: #f8f4f0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .order-info h3 {
            color: #c9302c;
            font-size: 16px;
            margin-bottom: 15px;
            border-bottom: 2px solid #d4a574;
            padding-bottom: 10px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .info-label {
            color: #666;
        }
        .info-value {
            font-weight: 500;
            text-align: right;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .items-table th {
            background-color: #f8f4f0;
            padding: 12px 10px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #d4a574;
        }
        .items-table th:last-child {
            text-align: right;
        }
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
        }
        .items-table td:last-child {
            text-align: right;
        }
        .items-table .item-qty {
            color: #666;
            font-size: 12px;
        }
        .total-row {
            background-color: #c9302c;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }
        .total-row td {
            padding: 15px 10px;
            border: none;
        }
        .note-section {
            background-color: #fff8e6;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .note-section h4 {
            color: #856404;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .note-section p {
            color: #856404;
            font-size: 14px;
        }
        .contact-section {
            background-color: #f8f4f0;
            border-radius: 8px;
            padding: 20px;
            margin-top: 25px;
            text-align: center;
        }
        .contact-section h3 {
            color: #333;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .contact-section p {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .email-footer {
            background-color: #333;
            color: white;
            padding: 25px 30px;
            text-align: center;
            font-size: 12px;
        }
        .email-footer a {
            color: #d4a574;
            text-decoration: none;
        }
        .social-links {
            margin: 15px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 8px;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        {{-- Header --}}
        <div class="email-header">
            <h1>🌸 Lâm Nhiên Thảo</h1>
            <p>Xác nhận đơn hàng thành công</p>
        </div>

        {{-- Body --}}
        <div class="email-body">
            {{-- Greeting --}}
            <div class="greeting">
                Xin chào <strong>{{ $customerName }}</strong>!
            </div>

            {{-- Order Confirmation Message --}}
            <p style="margin-bottom: 20px; color: #333;">
                Cảm ơn bạn đã đặt hàng tại <strong>Lâm Nhiên Thảo</strong>. 
                Chúng tôi đã tiếp nhận đơn hàng của bạn và sẽ liên hệ trong thời gian sớm nhất để xác nhận.
            </p>

            {{-- Order Info --}}
            <div class="order-info">
                <h3>📋 Thông tin đơn hàng #{{ $orderId }}</h3>
                <div class="info-row">
                    <span class="info-label">Ngày đặt:</span>
                    <span class="info-value">{{ $orderDate }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Số điện thoại:</span>
                    <span class="info-value">{{ $customerPhone }}</span>
                </div>
                @if($customerEmail)
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $customerEmail }}</span>
                </div>
                @endif
            </div>

            {{-- Order Items --}}
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
                        <td>
                            {{ $item['name'] }}
                            <div class="item-qty">x{{ $item['quantity'] }}</div>
                        </td>
                        <td>{{ number_format($item['price'], 0, ',', '.') }}₫</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ number_format($item['subtotal'], 0, ',', '.') }}₫</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3"><strong>TỔNG CỘNG</strong></td>
                        <td><strong>{{ number_format($total, 0, ',', '.') }}₫</strong></td>
                    </tr>
                </tbody>
            </table>

            {{-- Customer Note --}}
            @if($customerNote)
            <div class="note-section">
                <h4>📝 Ghi chú của bạn:</h4>
                <p>{{ $customerNote }}</p>
            </div>
            @endif

            {{-- Next Steps --}}
            <div class="contact-section">
                <h3>Bước tiếp theo</h3>
                <p>📞 Chúng tôi sẽ gọi điện xác nhận đơn hàng trong vài phút tới</p>
                <p>💬 Nếu có thắc mắc, vui lòng liên hệ hotline hoặc Zalo</p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="email-footer">
            <p><strong>Lâm Nhiên Thảo</strong> - Flowers & Gifts</p>
            <p>Địa chỉ: {{ config('app.address', 'TP. Hồ Chí Minh') }}</p>
            <div class="social-links">
                <a href="{{ config('services.zalo.hotline', '#') }}">Zalo</a> | 
                <a href="{{ config('app.url', '#') }}">Website</a>
            </div>
            <p style="margin-top: 15px; opacity: 0.7;">
                Email này được gửi tự động. Vui lòng không reply email này.
            </p>
        </div>
    </div>
</body>
</html>
