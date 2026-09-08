@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
<x-page-hero 
    title="Thanh toán"
    description="Hoàn tất đơn hàng của bạn - Nhân viên sẽ liên hệ xác nhận qua Zalo"
    :breadcrumbs="[
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Giỏ hàng', 'url' => route('cart.index')],
        ['label' => 'Thanh toán']
    ]"
    height="350px"
/>

<div class="container" style="padding: var(--space-8) var(--space-4);">

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
                                <label for="email" class="form-label">Email (Không bắt buộc)</label>
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
                                       placeholder="Số điện thoại hoặc ID Zalo của bạn">
                                @error('zalo_id')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message" class="form-label">Ghi chú thêm</label>
                            <textarea id="message" name="message" rows="4" 
                                      class="form-input @error('message') error @enderror"
                                      placeholder="Yêu cầu đặc biệt, hướng dẫn giao hàng, v.v.">{{ old('message') }}</textarea>
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
                        Gửi yêu cầu
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
                    <h2 class="card-title">Tổng đơn hàng</h2>
                </div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                        <div class="summary-item">
                            <div class="summary-item-image">
                                <img src="{{ $item->product->getPrimaryImage() }}" alt="{{ $item->product->name }}">
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
                                <strong>Chưa cần thanh toán ngay</strong>
                                <p>Nhân viên sẽ liên hệ với bạn qua Zalo để xác nhận chi tiết đơn hàng và phương thức thanh toán.</p>
                            </div>
                        </div>
                        
                        @if($siteInfo['zalo_qr'])
                            <div class="info-item">
                                <div class="zalo-qr">
                                    <img src="{{ asset('storage/' . $siteInfo['zalo_qr']) }}" alt="Mã QR Zalo">
                                    <p>Quét mã để thêm chúng tôi trên Zalo</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-4);
    }
    
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .form-group {
        margin-bottom: var(--space-4);
    }
    
    .form-label {
        display: block;
        font-size: var(--font-size-sm);
        font-weight: var(--font-semibold);
        margin-bottom: var(--space-2);
    }
    
    .form-label.required::after {
        content: '*';
        color: var(--color-error);
        margin-left: var(--space-1);
    }
    
    .form-input {
        width: 100%;
        padding: var(--space-3);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        background-color: var(--color-bg);
        transition: all var(--transition-base);
    }
    
    .form-input:focus {
        outline: none;
        border-color: var(--color-accent-cool);
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
    }
    
    .form-input.error {
        border-color: var(--color-error);
    }
    
    .form-error {
        display: block;
        margin-top: var(--space-2);
        font-size: var(--font-size-sm);
        color: var(--color-error);
    }
    
    .checkout-submit {
        display: flex;
        justify-content: space-between;
        gap: var(--space-4);
        margin-top: var(--space-6);
    }
    
    @media (max-width: 640px) {
        .checkout-submit {
            flex-direction: column;
        }
    }
    
    .summary-item {
        display: grid;
        grid-template-columns: 60px 1fr auto;
        gap: var(--space-3);
        padding: var(--space-3) 0;
        border-bottom: 1px solid var(--color-border);
    }
    
    .summary-item:first-child {
        padding-top: 0;
    }
    
    .summary-item-image {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-md);
        overflow: hidden;
        background-color: var(--color-bg-secondary);
    }
    
    .summary-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .summary-item-name {
        font-size: var(--font-size-sm);
        font-weight: var(--font-semibold);
        margin-bottom: var(--space-1);
    }
    
    .summary-item-qty {
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
        margin: 0;
    }
    
    .summary-item-price {
        font-weight: var(--font-semibold);
        white-space: nowrap;
    }
    
    .summary-divider {
        height: 1px;
        background-color: var(--color-border);
        margin: var(--space-4) 0;
    }
    
    .checkout-info {
        margin-top: var(--space-6);
        padding-top: var(--space-6);
        border-top: 1px solid var(--color-border);
    }
    
    .info-item {
        display: flex;
        gap: var(--space-3);
        margin-bottom: var(--space-4);
    }
    
    .info-item svg {
        flex-shrink: 0;
        color: var(--color-accent-cool);
    }
    
    .info-item strong {
        display: block;
        margin-bottom: var(--space-1);
    }
    
    .info-item p {
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
        margin: 0;
    }
    
    .zalo-qr {
        text-align: center;
        width: 100%;
    }
    
    .zalo-qr img {
        width: 150px;
        height: 150px;
        margin: 0 auto var(--space-2);
        border-radius: var(--radius-md);
    }
    
    .zalo-qr p {
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
    }
</style>
@endpush
@endsection
