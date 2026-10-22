@extends('layouts.app')

@section('title', __('account.reset_password'))

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-logo">
            <h1>{{ config('app.name') }}</h1>
        </div>

        <div class="auth-header">
            <h2>{{ __('account.reset_password') }}</h2>
            <p>{{ __('account.new_password_intro') }}</p>
        </div>

        <form method="POST" action="{{ localized_route('password.update') }}" class="auth-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">{{ __('account.email_address') }}</label>
                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">{{ __('account.new_password') }}</label>
                <input id="password" type="password" name="password" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">{{ __('account.confirm_password') }}</label>
                <input id="password-confirm" type="password" name="password_confirmation" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('account.reset_submit') }}
                </button>
            </div>
        </form>

        <div class="auth-links">
            <a href="{{ localized_route('login') }}">{{ __('account.back_to_login') }}</a>
        </div>
    </div>
</div>
@endsection
