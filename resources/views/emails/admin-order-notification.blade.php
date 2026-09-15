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
                <div>
                    <span>#{{ $orderId }}</span>
                    <p>{{ $orderDate }}</p>
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
                            <a href="tel:{{ $customerPhone }}">
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
            <p>
                <a href="{{ config('app.url', '#') }}">Truy cập Admin Panel</a>
            </p>
        </div>
    </div>
</body>
</html>
