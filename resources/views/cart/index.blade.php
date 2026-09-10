@extends('layouts.app')

@section('title', __('messages.cart.page_title'))

@section('content')
<x-page-hero
    title="{{ __('messages.cart.page_title') }}"
    description="{{ __('messages.cart.page_subtitle') ?? 'Xem lại các sản phẩm bạn đã chọn trước khi thanh toán' }}"
    :breadcrumbs="[
        ['label' => __('messages.nav.home'), 'url' => route('home')],
        ['label' => __('messages.cart.page_title')]
    ]"
    height="350px"
/>

<div class="container page-wrapper">

    @if($cartItems->count() > 0)
        <div class="checkout-layout">
            <!-- Cart Items -->
            <div class="checkout-main">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">{{ __('messages.cart.cart_items_title') }} ({{ $cartItems->count() }})</h2>
                    </div>
                    <div class="card-body">
                        @foreach($cartItems as $item)
                            <div class="cart-item">
                                <div class="cart-item-image">
                                    <img src="{{ $item->product->getPrimaryImage() }}" alt="{{ $item->product->name }}">
                                </div>
                                <div class="cart-item-info">
                                    <h3 class="cart-item-name">
                                        <a href="{{ locale_route('products.show', $item->product->display_slug) }}">
                                            {{ $item->product->name }}
                                        </a>
                                    </h3>
                                    @if($item->product->category)
                                        <p class="cart-item-category">{{ $item->product->category->name }}</p>
                                    @endif
                                    @if($item->product->stock <= 0)
                                        <span class="badge badge-danger">{{ __('messages.products.out_of_stock') }}</span>
                                    @elseif($item->product->stock < $item->quantity)
                                        <span class="badge badge-warning">{{ __('messages.cart.low_stock') ?? 'Chỉ còn ' . $item->product->stock }}</span>
                                    @endif
                                </div>
                                <div class="cart-item-price">
                                    {{ number_format($item->product->price, 0, ',', '.') }}₫
                                </div>
                                <div class="cart-item-quantity">
                                    <form action="{{ locale_route('cart.update', $item->id) }}" method="POST" class="quantity-form">
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
                                    <form action="{{ locale_route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon" title="{{ __('messages.cart.remove') }}" aria-label="{{ __('messages.cart.remove') }}">
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
                    <a href="{{ locale_route('products.index') }}" class="btn btn-outline">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        {{ __('messages.cart.continue_shopping') }}
                    </a>
                    <form action="{{ locale_route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-secondary" onclick="return confirm('{{ __('messages.cart.confirm_clear') ?? 'Xóa tất cả sản phẩm khỏi giỏ hàng?' }}')">
                            {{ __('messages.cart.clear_cart') ?? 'Xóa giỏ hàng' }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="checkout-sidebar">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">{{ __('messages.cart.order_total') }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="summary-row">
                            <span>{!! str_replace(':count', $cartItems->count(), __('messages.cart.cart_total')) !!}</span>
                            <span class="summary-value">{{ number_format($total, 0, ',', '.') }}₫</span>
                        </div>
                        <div class="summary-row summary-total">
                            <span>{{ __('messages.cart.total') }}</span>
                            <span class="summary-value">{{ number_format($total, 0, ',', '.') }}₫</span>
                        </div>
                        <a href="{{ locale_route('checkout.index') }}" class="btn btn-primary btn-lg btn-block">
                            {{ __('messages.cart.checkout') }}
                        </a>
                        <p class="checkout-note">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('messages.cart.checkout_note') }}
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
            <h2>{{ __('messages.cart.empty_title') }}</h2>
            <p>{{ __('messages.cart.empty_desc') }}</p>
            <a href="{{ locale_route('products.index') }}" class="btn btn-primary btn-lg">
                {{ __('messages.cart.view_products') }}
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
