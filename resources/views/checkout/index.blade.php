@extends('layouts.app')

@section('title', __('account.checkout_title'))

@section('content')
<x-page-hero
    :title="__('account.checkout_title')"
    :description="__('account.checkout_description')"
    :breadcrumbs="[
        ['label' => __('ui.home'), 'url' => localized_route('home')],
        ['label' => __('account.cart_title'), 'url' => localized_route('cart.index')],
        ['label' => __('account.checkout_title')]
    ]"
    :image="$siteBanners['checkout'] ?? null"
    :hideOverlay="$siteBannerHideOverlay['checkout'] ?? false"
    variant="checkout"
/>

<div class="container page-wrapper">

    <div class="checkout-container">
        <!-- Checkout Form -->
        <div class="checkout-form">
            <form action="{{ localized_route('checkout.store') }}" method="POST">
                @csrf
                
                <div class="checkout-section">
                    <div class="checkout-section-header">
                        <div class="checkout-card-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h2 class="checkout-section-title">{{ __('account.contact_delivery') }}</h2>
                    </div>
                    <div class="checkout-section-body">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name" class="form-label required">{{ __('account.full_name_required') }}</label>
                                <input type="text" id="name" name="name" 
                                       value="{{ auth()->check() ? auth()->user()->name : old('name') }}" 
                                       class="form-input @error('name') form-input-error @enderror" required>
                                @error('name')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone" class="form-label required">{{ __('account.phone_required') }}</label>
                                <input type="tel" id="phone" name="phone" 
                                       value="{{ auth()->check() ? auth()->user()->phone : old('phone') }}" 
                                       class="form-input @error('phone') form-input-error @enderror" required>
                                @error('phone')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">{{ __('account.email_optional') }}</label>
                                <input type="email" id="email" name="email" 
                                       value="{{ auth()->check() ? auth()->user()->email : old('email') }}" 
                                       class="form-input @error('email') form-input-error @enderror">
                                @error('email')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="zalo_id" class="form-label">Zalo ID</label>
                                <input type="text" id="zalo_id" name="zalo_id" 
                                       value="{{ old('zalo_id') }}" 
                                       class="form-input @error('zalo_id') form-input-error @enderror"
                                       :placeholder="__('account.zalo_example')">
                                @error('zalo_id')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="delivery_address" class="form-label required">{{ __('account.delivery_address') }}</label>
                            <textarea id="delivery_address" name="delivery_address" rows="3" autocomplete="street-address"
                                      class="form-input form-textarea @error('delivery_address') form-input-error @enderror"
                                      required>{{ old('delivery_address', $user?->address) }}</textarea>
                            @error('delivery_address')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="delivery_date" class="form-label required">{{ __('account.delivery_date') }}</label>
                                <input type="date" id="delivery_date" name="delivery_date" min="{{ now()->toDateString() }}"
                                       value="{{ old('delivery_date') }}"
                                       class="form-input @error('delivery_date') form-input-error @enderror" required>
                                @error('delivery_date')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="delivery_time" class="form-label required">{{ __('account.delivery_time') }}</label>
                                <input type="time" id="delivery_time" name="delivery_time"
                                       value="{{ old('delivery_time') }}"
                                       class="form-input @error('delivery_time') form-input-error @enderror" required>
                                @error('delivery_time')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="message" class="form-label">{{ __('account.note') }}</label>
                            <textarea id="message" name="message" rows="4" 
                                      class="form-input form-textarea @error('message') form-input-error @enderror"
                                      :placeholder="__('account.order_note_placeholder')">{{ old('message') }}</textarea>
                            @error('message')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="checkout-actions">
                    <a href="{{ localized_route('cart.index') }}" class="btn btn-outline btn-lg">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        {{ __('account.back_to_cart') }}
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        {{ __('account.place_order') }}
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="checkout-summary">
            <div class="summary-card">
                <div class="summary-card-header">
                    <div class="summary-card-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h2 class="summary-card-title">{{ __('account.order_summary') }}</h2>
                </div>
                <div class="summary-card-body">
                    <div class="summary-items">
                        @foreach($cartItems as $item)
                            <div class="summary-item">
                                <div class="summary-item-image">
                                    <img src="{{ $item->getPrimaryImageUrl() }}" alt="{{ $item->getDisplayName() }}">
                                    <span class="item-quantity-badge">{{ $item->quantity }}</span>
                                </div>
                                <div class="summary-item-info">
                                    <h4 class="summary-item-name">{{ $item->getDisplayName() }}</h4>
                                    <p class="summary-item-qty">{{ __('account.quantity_short', ['count' => $item->quantity]) }}</p>
                                </div>
                                <div class="summary-item-price">
                                    {{ number_format($item->getSubtotal(), 0, ',', '.') }}₫
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-row">
                        <span class="summary-label">{{ __('account.subtotal_products', ['count' => $cartItems->count()]) }}</span>
                        <span class="summary-value">{{ number_format($total, 0, ',', '.') }}₫</span>
                    </div>
                    
                    <div class="summary-row summary-shipping">
                        <span class="summary-label">{{ __('account.shipping_fee') }}</span>
                        <span class="summary-value">{{ __('account.pending_confirmation') }}</span>
                    </div>
                    
                    <div class="summary-row summary-total">
                        <span class="summary-label">{{ __('account.estimated_total') }}</span>
                        <span class="summary-value">{{ number_format($total, 0, ',', '.') }}₫</span>
                    </div>

                    <div class="checkout-info">
                        <div class="info-item">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <strong>{{ __('account.no_payment_now') }}</strong>
                                <p>{{ __('account.order_contact_notice') }}</p>
                            </div>
                        </div>
                        
                        @if($siteInfo['zalo_qr'])
                            <div class="info-item">
                                <div class="zalo-qr">
                                    <img src="{{ asset('storage/' . $siteInfo['zalo_qr']) }}" alt="{{ __('account.zalo_qr_alt') }}">
                                    <p>{{ __('account.zalo_scan') }}</p>
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
