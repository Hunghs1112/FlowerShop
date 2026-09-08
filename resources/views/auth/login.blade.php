@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            {{-- Logo --}}
            <div class="auth-logo">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                </svg>
            </div>

            {{-- Header --}}
            <div class="auth-header">
                <h1 class="auth-title">Chào mừng trở lại</h1>
                <p class="auth-subtitle">Đăng nhập vào tài khoản của bạn</p>
            </div>

            {{-- Success Message --}}
            @if(session('status'))
                <div class="auth-alert success">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; flex-shrink: 0;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- Error Messages --}}
            @if($errors->any())
                <div class="auth-alert error">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; flex-shrink: 0;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span><strong>Đăng nhập thất bại:</strong> {{ $errors->first() }}</span>
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        class="form-input @error('email') error @enderror" 
                        placeholder="your@email.com"
                        required 
                        autofocus
                    >
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input @error('password') error @enderror" 
                        placeholder="••••••••"
                        required
                    >
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-checkbox-group">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        name="remember" 
                        class="form-checkbox"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <label for="remember" class="form-checkbox-label">Ghi nhớ đăng nhập</label>
                </div>

                <div class="auth-actions">
                    <button type="submit" class="auth-button">
                        Đăng nhập
                    </button>
                </div>
            </form>

            {{-- Forgot Password --}}
            @if(Route::has('password.request'))
                <div class="auth-footer">
                    <a href="{{ route('password.request') }}" class="auth-footer-link">
                        Quên mật khẩu?
                    </a>
                </div>
            @endif

            {{-- Info Note --}}
            <div class="auth-note">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>Tài khoản khách hàng được tạo bởi quản trị viên. Vui lòng liên hệ nếu bạn cần tài khoản mới.</p>
            </div>
        </div>
    </div>
</div>
@endsection
