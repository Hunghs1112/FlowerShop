@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<x-page-hero
    title="Giỏ hàng"
    description="Xem lại các sản phẩm bạn đã chọn trước khi thanh toán"
    :breadcrumbs="[
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Giỏ hàng']
    ]"
    :image="$siteBanners['cart'] ?? null"
    height="350px"
/>

<div class="container page-wrapper">

    @if($cartItems->count() > 0)
        <div class="checkout-layout">
            <!-- Cart Items -->
            <div class="checkout-main">
                <div class="cart-items-card">
                    <div class="cart-card-header">
                        <h2 class="cart-card-title">Sản phẩm trong giỏ ({{ $cartItems->count() }})</h2>
                    </div>
                    <div class="cart-card-body">
                        @foreach($cartItems as $item)
                            <div class="cart-item">
                                <div class="cart-item-image">
                                    <img src="{{ $item->product->getPrimaryImageUrl() }}" alt="{{ $item->product->name }}">
                                </div>
                                <div class="cart-item-info">
                                    <h3 class="cart-item-name">
                                        <a href="{{ route('products.show', $item->product->display_slug) }}">
                                            {{ $item->product->name }}
                                        </a>
                                    </h3>
                                    @if($item->product->category)
                                        <p class="cart-item-category">{{ $item->product->category->name }}</p>
                                    @endif
                                    @if($item->product->stock <= 0)
                                        <span class="badge badge-error">Hết hàng</span>
                                    @elseif($item->product->stock < $item->quantity)
                                        <span class="badge badge-warning">Chỉ còn {{ $item->product->stock }}</span>
                                    @endif
                                </div>
                                <div class="cart-item-price">
                                    {{ number_format($item->product->price, 0, ',', '.') }}₫
                                </div>
                                <div class="cart-item-quantity">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="quantity-form">
                                        @csrf
                                        @method('PATCH')
                                        <div class="quantity-selector">
                                            <button type="button" class="qty-btn" onclick="updateCartQty(this, -1)">-</button>
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                                   min="1" max="{{ $item->product->stock }}" 
                                                   class="qty-input" onchange="this.form.submit()">
                                            <button type="button" class="qty-btn" onclick="updateCartQty(this, 1)">+</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="cart-item-total">
                                    {{ number_format($item->getSubtotal(), 0, ',', '.') }}₫
                                </div>
                                <div class="cart-item-actions">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove" title="Xóa" aria-label="Xóa">
                                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="cart-actions">
                    <div class="cart-actions-left">
                        <a href="{{ route('products.index') }}" class="btn btn-outline">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Tiếp tục mua sắm
                        </a>
                    </div>
                    <div class="cart-actions-right">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary" onclick="return confirm('Xóa tất cả sản phẩm khỏi giỏ hàng?')">
                                Xóa giỏ hàng
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="checkout-sidebar">
                <div class="order-summary-card">
                    <div class="summary-card-header">
                        <div class="checkout-card-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h2 class="summary-card-title">Tổng cộng</h2>
                    </div>
                    <div class="summary-card-body">
                        <div class="summary-row">
                            <span class="summary-label">Tạm tính ({{ $cartItems->count() }} sản phẩm)</span>
                            <span class="summary-value">{{ number_format($total, 0, ',', '.') }}₫</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Phí vận chuyển</span>
                            <span class="summary-value">Tính khi đặt</span>
                        </div>
                        <div class="summary-row summary-total">
                            <span class="summary-label">Tổng cộng</span>
                            <span class="summary-value">{{ number_format($total, 0, ',', '.') }}₫</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg checkout-btn">
                            Thanh toán
                        </a>
                        <div class="checkout-note">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Chúng tôi sẽ liên hệ xác nhận đơn hàng sau khi bạn đặt.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="empty-cart">
            <div class="empty-cart-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h2 class="empty-cart-title">Giỏ hàng trống</h2>
            <p class="empty-cart-description">Hãy chọn những sản phẩm yêu thích của bạn!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                Xem sản phẩm
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function updateCartQty(btn, delta) {
        const form = btn.closest('.quantity-form');
        const input = form.querySelector('input[name="quantity"]');
        const current = parseInt(input.value) || 1;
        const max = parseInt(input.max);
        const newVal = current + delta;
        
        if (newVal >= 1 && newVal <= max) {
            input.value = newVal;
            form.submit();
        }
    }
</script>
@endpush
@endsection
