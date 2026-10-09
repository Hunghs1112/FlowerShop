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
            <p>
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
                <div class="info-row">
                    <span class="info-label">Địa chỉ giao hàng:</span>
                    <span class="info-value">{{ $deliveryAddress }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Thời gian mong muốn:</span>
                    <span class="info-value">{{ $deliveryDate }} lúc {{ $deliveryTime }}</span>
                </div>
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
                    <tr>
                        <td colspan="3">Tạm tính</td>
                        <td>{{ number_format($subtotal, 0, ',', '.') }}₫</td>
                    </tr>
                    <tr>
                        <td colspan="3">Phí vận chuyển</td>
                        <td>{{ $shippingFee === null ? 'Chờ xác nhận' : number_format($shippingFee, 0, ',', '.').'₫' }}</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3"><strong>{{ $shippingFee === null ? 'TẠM TÍNH (CHƯA GỒM PHÍ GIAO HÀNG)' : 'TỔNG CỘNG' }}</strong></td>
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
            <p>
                Email này được gửi tự động. Vui lòng không reply email này.
            </p>
        </div>
    </div>
</body>
</html>
