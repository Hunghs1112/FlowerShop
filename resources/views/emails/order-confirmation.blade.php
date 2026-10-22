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
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('customer.mail.title', ['id' => $orderId]) }}</title>
</head>
<body>
    <div class="email-wrapper">
        {{-- Header --}}
        <div class="email-header">
            <h1>🌸 Lâm Nhiên Thảo</h1>
            <p>{{ __('customer.mail.confirmed') }}</p>
        </div>

        {{-- Body --}}
        <div class="email-body">
            {{-- Greeting --}}
            <div class="greeting">
                {{ __('customer.mail.hello_prefix') }} <strong>{{ $customerName }}</strong>!
            </div>

            {{-- Order Confirmation Message --}}
            <p>
                {!! __('customer.mail.thanks') !!}
            </p>

            {{-- Order Info --}}
            <div class="order-info">
                <h3>📋 {{ __('customer.mail.order_info', ['id' => $orderId]) }}</h3>
                <div class="info-row">
                    <span class="info-label">{{ __('customer.mail.order_date') }}</span>
                    <span class="info-value">{{ $orderDate }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">{{ __('customer.mail.phone') }}</span>
                    <span class="info-value">{{ $customerPhone }}</span>
                </div>
                @if($customerEmail)
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $customerEmail }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">{{ __('customer.mail.address') }}</span>
                    <span class="info-value">{{ $deliveryAddress }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">{{ __('customer.mail.delivery_time') }}</span>
                    <span class="info-value">{{ $deliveryDate }} {{ __('customer.mail.at') }} {{ $deliveryTime }}</span>
                </div>
            </div>

            {{-- Order Items --}}
            <table class="items-table">
                <thead>
                    <tr>
                        <th>{{ __('ui.products') }}</th>
                        <th>{{ __('customer.mail.unit_price') }}</th>
                        <th>{{ __('customer.mail.quantity') }}</th>
                        <th>{{ __('customer.mail.line_total') }}</th>
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
                        <td colspan="3">{{ __('customer.mail.subtotal') }}</td>
                        <td>{{ number_format($subtotal, 0, ',', '.') }}₫</td>
                    </tr>
                    <tr>
                        <td colspan="3">{{ __('customer.mail.shipping') }}</td>
                        <td>{{ $shippingFee === null ? __('customer.mail.pending') : number_format($shippingFee, 0, ',', '.').'₫' }}</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3"><strong>{{ $shippingFee === null ? __('customer.mail.estimated_total') : __('customer.mail.total') }}</strong></td>
                        <td><strong>{{ number_format($total, 0, ',', '.') }}₫</strong></td>
                    </tr>
                </tbody>
            </table>

            {{-- Customer Note --}}
            @if($customerNote)
            <div class="note-section">
                <h4>📝 {{ __('customer.mail.note') }}</h4>
                <p>{{ $customerNote }}</p>
            </div>
            @endif

            {{-- Next Steps --}}
            <div class="contact-section">
                <h3>{{ __('customer.mail.next') }}</h3>
                <p>📞 {{ __('customer.mail.call') }}</p>
                <p>💬 {{ __('customer.mail.help') }}</p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="email-footer">
            <p><strong>Lâm Nhiên Thảo</strong> - Flowers & Gifts</p>
            <p>{{ __('customer.mail.address_label') }} {{ config('app.address', 'TP. Hồ Chí Minh') }}</p>
            <div class="social-links">
                <a href="{{ config('services.zalo.hotline', '#') }}">Zalo</a> | 
                <a href="{{ config('app.url', '#') }}">Website</a>
            </div>
            <p>
                {{ __('customer.mail.automatic') }}
            </p>
        </div>
    </div>
</body>
</html>
