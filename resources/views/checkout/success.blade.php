@extends('layouts.app')

@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container page-wrapper">
    <div class="success-container">
        <div class="success-icon">
            <svg width="80" height="80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        
        <h1 class="success-title">Đặt hàng thành công!</h1>
        <p class="success-message">Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
        
        <div class="success-details">
            <div class="detail-card">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <div>
                    <h3>Tiếp theo là gì?</h3>
                    <p>Chúng tôi sẽ liên hệ xác nhận đơn hàng qua email hoặc tin nhắn trong thời gian sớm nhất.</p>
                </div>
            </div>
            
            <div class="detail-card">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                <div>
                    <h3>Theo dõi đơn hàng</h3>
                    <p>Bạn có thể nhắn tin với chúng tôi bất cứ lúc nào qua chat để theo dõi đơn hàng.</p>
                </div>
            </div>
            
            @if($inquiry ?? null)
                <div class="detail-card">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <div>
                        <h3>Mã đơn hàng</h3>
                        <p>Mã tham chiếu: <strong>#{{ $inquiry->id }}</strong></p>
                        <p class="text-sm">Đặt lúc {{ $inquiry->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="success-actions">
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                Về trang chủ
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-outline btn-lg">
                Tiếp tục mua sắm
            </a>
            @auth
                <a href="{{ route('profile.show') }}" class="btn btn-secondary btn-lg">
                    Xem tài khoản
                </a>
            @endauth
        </div>
    </div>
</div>

@endsection
