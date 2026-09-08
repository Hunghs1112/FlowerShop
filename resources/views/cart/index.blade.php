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
    height="350px"
/>

<div class="container" style="padding: var(--space-8) var(--space-4);">

    @if($cartItems->count() > 0)
        <div class="checkout-layout">
            <!-- Cart Items -->
            <div class="checkout-main">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Sản phẩm trong giỏ ({{ $cartItems->count() }})</h2>
                    </div>
                    <div class="card-body">
                        @foreach($cartItems as $item)
                            <div class="cart-item">
                                <div class="cart-item-image">
                                    <img src="{{ $item->product->getPrimaryImage() }}" alt="{{ $item->product->name }}">
                                </div>
                                <div class="cart-item-info">
                                    <h3 class="cart-item-name">
                                        <a href="{{ route('products.show', $item->product->slug) }}">
                                            {{ $item->product->name }}
                                        </a>
                                    </h3>
                                    @if($item->product->category)
                                        <p class="cart-item-category">{{ $item->product->category->name }}</p>
                                    @endif
                                    @if($item->product->stock <= 0)
                                        <span class="badge badge-danger">Hết hàng</span>
                                    @elseif($item->product->stock < $item->quantity)
                                        <span class="badge badge-warning">Chỉ còn {{ $item->product->stock }} sản phẩm</span>
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
                                        <button type="submit" class="btn-icon" title="Xóa">
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
                    <a href="{{ route('products.index') }}" class="btn btn-outline">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Tiếp tục mua sắm
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-secondary" onclick="return confirm('Xóa tất cả sản phẩm khỏi giỏ hàng?')">
                            Xóa giỏ hàng
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="checkout-sidebar">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Tổng đơn hàng</h2>
                    </div>
                    <div class="card-body">
                        <div class="summary-row">
                            <span>Tạm tính ({{ $cartItems->count() }} sản phẩm)</span>
                            <span class="summary-value">{{ number_format($total, 0, ',', '.') }}₫</span>
                        </div>
                        <div class="summary-row summary-total">
                            <span>Tổng cộng</span>
                            <span class="summary-value">{{ number_format($total, 0, ',', '.') }}₫</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg btn-block">
                            Thanh toán
                        </a>
                        <p class="checkout-note">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Nhân viên sẽ liên hệ với bạn qua Zalo để xác nhận đơn hàng
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="empty-cart">
            <svg width="120" height="120" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h2>Giỏ hàng trống</h2>
            <p>Thêm sản phẩm để bắt đầu mua sắm</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                Xem sản phẩm
            </a>
        </div>
    @endif
</div>

@push('styles')
<style>
    .checkout-layout {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: var(--space-8);
        align-items: start;
    }
    
    @media (max-width: 1024px) {
        .checkout-layout {
            grid-template-columns: 1fr;
        }
    }
    
    .cart-item {
        display: grid;
        grid-template-columns: 80px 1fr auto auto auto auto;
        gap: var(--space-4);
        align-items: center;
        padding: var(--space-4);
        border-bottom: 1px solid var(--color-border);
    }
    
    .cart-item:last-child {
        border-bottom: none;
    }
    
    @media (max-width: 768px) {
        .cart-item {
            grid-template-columns: 60px 1fr;
            gap: var(--space-3);
        }
        
        .cart-item-price,
        .cart-item-total {
            grid-column: 2;
        }
        
        .cart-item-quantity {
            grid-column: 1 / -1;
        }
    }
    
    .cart-item-image {
        width: 80px;
        height: 80px;
        border-radius: var(--radius-md);
        overflow: hidden;
        background-color: var(--color-bg-secondary);
    }
    
    .cart-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .cart-item-name {
        font-size: var(--font-size-base);
        font-weight: var(--font-semibold);
        margin-bottom: var(--space-1);
    }
    
    .cart-item-name a {
        color: var(--color-text);
        text-decoration: none;
    }
    
    .cart-item-name a:hover {
        color: var(--color-accent-cool);
    }
    
    .cart-item-category {
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
        margin: 0;
    }
    
    .cart-item-price,
    .cart-item-total {
        font-weight: var(--font-semibold);
        white-space: nowrap;
    }
    
    .cart-item-total {
        color: var(--color-accent-warm);
    }
    
    .quantity-form {
        display: inline-block;
    }
    
    .quantity-selector {
        display: flex;
        align-items: center;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        overflow: hidden;
    }
    
    .qty-btn {
        width: 32px;
        height: 36px;
        background-color: var(--color-bg-secondary);
        border: none;
        cursor: pointer;
        font-size: var(--font-size-base);
        transition: background-color var(--transition-base);
    }
    
    .qty-btn:hover {
        background-color: var(--color-bg-dark);
    }
    
    .qty-input {
        width: 50px;
        height: 36px;
        border: none;
        text-align: center;
        font-weight: var(--font-semibold);
        background-color: transparent;
    }
    
    .cart-item-actions .btn-icon {
        background: none;
        border: none;
        color: var(--color-text-secondary);
        cursor: pointer;
        padding: var(--space-2);
        transition: color var(--transition-base);
    }
    
    .cart-item-actions .btn-icon:hover {
        color: var(--color-error);
    }
    
    .cart-actions {
        display: flex;
        justify-content: space-between;
        gap: var(--space-4);
        margin-top: var(--space-6);
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: var(--space-3) 0;
        border-bottom: 1px solid var(--color-border);
    }
    
    .summary-row:last-of-type {
        border-bottom: none;
    }
    
    .summary-total {
        font-size: var(--font-size-lg);
        font-weight: var(--font-bold);
        padding-top: var(--space-4);
        margin-top: var(--space-4);
        border-top: 2px solid var(--color-border);
    }
    
    .summary-value {
        font-weight: var(--font-semibold);
    }
    
    .summary-total .summary-value {
        color: var(--color-accent-warm);
    }
    
    .checkout-note {
        display: flex;
        align-items: flex-start;
        gap: var(--space-2);
        margin-top: var(--space-4);
        padding: var(--space-3);
        background-color: var(--color-bg-secondary);
        border-radius: var(--radius-md);
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
    }
    
    .checkout-note svg {
        flex-shrink: 0;
        margin-top: 2px;
    }
    
    .empty-cart {
        text-align: center;
        padding: var(--space-16) var(--space-4);
    }
    
    .empty-cart svg {
        margin: 0 auto var(--space-6);
        color: var(--color-text-secondary);
        opacity: 0.5;
    }
    
    .empty-cart h2 {
        font-size: var(--font-size-2xl);
        font-weight: var(--font-bold);
        margin-bottom: var(--space-3);
    }
    
    .empty-cart p {
        color: var(--color-text-secondary);
        margin-bottom: var(--space-6);
    }
</style>
@endpush

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
