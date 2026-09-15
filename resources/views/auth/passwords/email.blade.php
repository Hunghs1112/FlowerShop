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
            <p>Nhập email để nhận liên kết đặt lại mật khẩu</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email">Địa chỉ Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-block">
                    Gửi liên kết đặt lại mật khẩu
                </button>
            </div>
        </form>

        <div class="auth-links">
            <a href="{{ route('login') }}">Quay lại đăng nhập</a>
        </div>
    </div>
</div>
@endsection
