@extends('layouts.app')

@section('title', 'Order Submitted')

@section('content')
<div class="container page-wrapper-lg">
    <div class="success-container">
        <div class="success-icon">
            <svg width="80" height="80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        
        <h1 class="success-title">{{ __('messages.checkout.success_title') }}</h1>
        <p class="success-message">{{ __('messages.checkout.success_desc') }}</p>
        
        <div class="success-details">
            <div class="detail-card">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3>{{ __('messages.checkout.whats_next') }}</h3>
                    <p>{{ __('messages.checkout.team_contact') }}</p>
                </div>
            </div>
            
            <div class="detail-card">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <div>
                    <h3>{{ __('messages.checkout.check_messages') }}</h3>
                    <p>{{ __('messages.checkout.keep_accessible') }}</p>
                </div>
            </div>
            
            @if($inquiry ?? null)
                <div class="detail-card">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <div>
                        <h3>Inquiry Reference</h3>
                        <p>Reference ID: <strong>#{{ $inquiry->id }}</strong></p>
                        <p class="text-sm">Submitted on {{ $inquiry->created_at->format('M d, Y \a\t H:i') }}</p>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="success-actions">
            <a href="{{ locale_route('home') }}" class="btn btn-primary btn-lg">
                {{ __('messages.checkout.back_home') }}
            </a>
            <a href="{{ locale_route('products.index') }}" class="btn btn-outline btn-lg">
                {{ __('messages.cart.continue_shopping') }}
            </a>
            @auth
                <a href="{{ locale_route('profile.show') }}" class="btn btn-secondary btn-lg">
                    View My Inquiries
                </a>
            @endauth
        </div>
    </div>
</div>

@endsection
