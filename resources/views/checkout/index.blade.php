@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
<x-page-hero 
    title="Thanh toán"
    description="Hoàn tất thông tin để đặt hàng"
    :breadcrumbs="[
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Giỏ hàng', 'url' => route('cart.index')],
        ['label' => 'Thanh toán']
    ]"
    :image="$siteBanners['checkout'] ?? null"
    height="350px"
/>

<div class="container page-wrapper">

    <div class="checkout-layout">
        <!-- Checkout Form -->
        <div class="checkout-main">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Thông tin liên hệ</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name" class="form-label required">Họ và tên</label>
                                <input type="text" id="name" name="name" 
                                       value="{{ auth()->check() ? auth()->user()->name : old('name') }}" 
                                       class="form-input @error('name') error @enderror" required>
                                @error('name')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone" class="form-label required">Số điện thoại</label>
                                <input type="tel" id="phone" name="phone" 
                                       value="{{ auth()->check() ? auth()->user()->phone : old('phone') }}" 
                                       class="form-input @error('phone') error @enderror" required>
                                @error('phone')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Email (tùy chọn)</label>
                                <input type="email" id="email" name="email" 
                                       value="{{ auth()->check() ? auth()->user()->email : old('email') }}" 
                                       class="form-input @error('email') error @enderror">
                                @error('email')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="zalo_id" class="form-label">Zalo ID</label>
                                <input type="text" id="zalo_id" name="zalo_id" 
                                       value="{{ old('zalo_id') }}" 
                                       class="form-input @error('zalo_id') error @enderror"
                                       placeholder="VD: 0901234567">
                                @error('zalo_id')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message" class="form-label">Ghi chú</label>
                            <textarea id="message" name="message" rows="4" 
                                      class="form-input @error('message') error @enderror"
                                      placeholder="Thêm ghi chú cho đơn hàng...">{{ old('message') }}</textarea>
                            @error('message')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="checkout-submit">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline btn-lg">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Quay lại giỏ hàng
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        Đặt hàng
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="checkout-sidebar">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Tóm tắt đơn hàng</h2>
                </div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                        <div class="summary-item">
                            <div class="summary-item-image">
                                <img src="{{ $item->product->getPrimaryImageUrl() }}" alt="{{ $item->product->name }}">
                            </div>
                            <div class="summary-item-info">
                                <h4 class="summary-item-name">{{ $item->product->name }}</h4>
                                <p class="summary-item-qty">SL: {{ $item->quantity }}</p>
                            </div>
                            <div class="summary-item-price">
                                {{ number_format($item->getSubtotal(), 0, ',', '.') }}₫
                            </div>
                        </div>
                    @endforeach

                    <div class="summary-divider"></div>

                    <div class="summary-row">
                        <span>Tạm tính ({{ $cartItems->count() }} sản phẩm)</span>
                        <span class="summary-value">{{ number_format($total, 0, ',', '.') }}₫</span>
                    </div>
                    
                    <div class="summary-row summary-total">
                        <span>Tổng cộng</span>
                        <span class="summary-value">{{ number_format($total, 0, ',', '.') }}₫</span>
                    </div>

                    <div class="checkout-info">
                        <div class="info-item">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <strong>Không cần thanh toán ngay</strong>
                                <p>Chúng tôi sẽ liên hệ xác nhận đơn hàng với bạn.</p>
                            </div>
                        </div>
                        
                        @if($siteInfo['zalo_qr'])
                            <div class="info-item">
                                <div class="zalo-qr">
                                    <img src="{{ asset('storage/' . $siteInfo['zalo_qr']) }}" alt="Mã QR Zalo">
                                    <p>Quét Zalo để liên hệ nhanh</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
