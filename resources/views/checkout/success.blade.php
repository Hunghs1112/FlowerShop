@extends('layouts.app')

@section('title', 'Order Submitted')

@section('content')
<div class="container" style="padding: var(--space-16) var(--space-4);">
    <div class="success-container">
        <div class="success-icon">
            <svg width="80" height="80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        
        <h1 class="success-title">Thank You!</h1>
        <p class="success-message">Your inquiry has been submitted successfully.</p>
        
        <div class="success-details">
            <div class="detail-card">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3>What's Next?</h3>
                    <p>Our sales team will contact you via Zalo or phone within 24 hours to confirm your order details and discuss payment options.</p>
                </div>
            </div>
            
            <div class="detail-card">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <div>
                    <h3>Check Your Messages</h3>
                    <p>Please keep your phone and Zalo accessible so we can reach you quickly.</p>
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
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                Back to Home
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-outline btn-lg">
                Continue Shopping
            </a>
            @auth
                <a href="{{ route('profile.show') }}" class="btn btn-secondary btn-lg">
                    View My Inquiries
                </a>
            @endauth
        </div>
    </div>
</div>

@push('styles')
<style>
    .success-container {
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
    }
    
    .success-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 120px;
        height: 120px;
        margin-bottom: var(--space-6);
        background: linear-gradient(135deg, var(--color-accent-cool), var(--color-accent-warm));
        border-radius: 50%;
        color: white;
    }
    
    .success-title {
        font-size: var(--font-size-4xl);
        font-weight: var(--font-bold);
        margin-bottom: var(--space-3);
    }
    
    .success-message {
        font-size: var(--font-size-lg);
        color: var(--color-text-secondary);
        margin-bottom: var(--space-8);
    }
    
    .success-details {
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
        margin-bottom: var(--space-8);
        text-align: left;
    }
    
    .detail-card {
        display: flex;
        gap: var(--space-4);
        padding: var(--space-6);
        background-color: var(--color-bg-secondary);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
    }
    
    .detail-card svg {
        flex-shrink: 0;
        color: var(--color-accent-cool);
    }
    
    .detail-card h3 {
        font-size: var(--font-size-lg);
        font-weight: var(--font-semibold);
        margin-bottom: var(--space-2);
    }
    
    .detail-card p {
        font-size: var(--font-size-base);
        color: var(--color-text-secondary);
        margin-bottom: var(--space-2);
    }
    
    .detail-card p:last-child {
        margin-bottom: 0;
    }
    
    .detail-card .text-sm {
        font-size: var(--font-size-sm);
    }
    
    .success-actions {
        display: flex;
        flex-direction: column;
        gap: var(--space-3);
        max-width: 400px;
        margin: 0 auto;
    }
    
    @media (min-width: 640px) {
        .success-actions {
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .success-actions .btn {
            flex: 0 0 auto;
        }
    }
</style>
@endpush
@endsection
