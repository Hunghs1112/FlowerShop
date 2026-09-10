@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-logo">
            <h1>{{ config('app.name') }}</h1>
        </div>

        <div class="auth-header">
            <h2>Đặt lại mật khẩu</h2>
            <p>Nhập mật khẩu mới của bạn</p>
        </div>

        <form method="POST" action="{{ locale_route('password.update') }}" class="auth-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">Địa chỉ Email</label>
                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu mới</label>
                <input id="password" type="password" name="password" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">Xác nhận mật khẩu</label>
                <input id="password-confirm" type="password" name="password_confirmation" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-block">
                    Đặt lại mật khẩu
                </button>
            </div>
        </form>

        <div class="auth-links">
            <a href="{{ locale_route('login') }}">Quay lại đăng nhập</a>
        </div>
    </div>
</div>
@endsection
