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
            <p>{{ __('account.reset_email_intro') }}</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ localized_route('password.email') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email">{{ __('account.email_address') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('account.send_reset_link') }}
                </button>
            </div>
        </form>

        <div class="auth-links">
            <a href="{{ localized_route('login') }}">{{ __('account.back_to_login') }}</a>
        </div>
    </div>
</div>
@endsection
