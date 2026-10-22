@extends('layouts.app')

@section('title', __('account.profile_title'))

@section('content')
<section class="profile-page">
<div class="container profile-container">
    <header class="profile-heading">
        <div>
            <p class="profile-eyebrow">{{ __('account.profile_eyebrow') }}</p>
            <h1>{{ __('ui.account') }}</h1>
            <p class="profile-heading-copy">{{ __('account.profile_intro') }}</p>
        </div>
        <a class="profile-back-link" href="{{ localized_route('home') }}">{{ __('account.continue_shopping') }}</a>
    </header>

    <div class="profile-dashboard">
        <aside class="profile-sidebar" aria-label="{{ __('account.account_summary') }}">
            <div class="profile-identity">
                <div class="profile-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                <div class="profile-identity-copy">
                    <span class="profile-kicker">{{ __('account.member') }}</span>
                    <h2>{{ $user->name }}</h2>
                    <p>{{ $user->email }}</p>
                    <p>{{ __('account.member_rank') }} <strong>{{ $user->vipLevel?->is_active ? $user->vipLevel->name : __('account.regular_customer') }}</strong></p>
                </div>
            </div>
            <nav class="profile-nav" aria-label="{{ __('account.account_navigation') }}">
                <a href="#profile-information"><span>01</span> {{ __('account.profile_information') }}</a>
                <a href="#profile-password"><span>02</span> {{ __('account.security') }}</a>
                <a href="#profile-inquiries"><span>03</span> {{ __('account.my_requests') }} <i>{{ $inquiries->total() }}</i></a>
            </nav>
            <p class="profile-sidebar-note">{{ __('account.profile_note') }}</p>
        </aside>

        <!-- Account Main Content -->
        <div class="account-main profile-main">
            <!-- Profile Information -->
            <div class="account-card" id="profile-information">
                <div class="account-card-header">
                    <h2 class="account-card-title">{{ __('account.profile_information') }}</h2>
                    <p>{{ __('account.profile_contact_intro') }}</p>
                </div>
                <div class="account-card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ localized_route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name" class="form-label">{{ __('account.full_name') }}</label>
                                <input type="text" id="name" name="name" 
                                       value="{{ old('name', auth()->user()->name) }}" 
                                       class="form-input @error('name') error @enderror" required>
                                @error('name')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">{{ __('account.email') }}</label>
                                <input type="email" id="email" name="email" 
                                       value="{{ old('email', auth()->user()->email) }}" 
                                       class="form-input @error('email') error @enderror" required>
                                @error('email')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone" class="form-label">{{ __('account.phone') }}</label>
                                <input type="tel" id="phone" name="phone" 
                                       value="{{ old('phone', auth()->user()->phone) }}" 
                                       class="form-input @error('phone') error @enderror">
                                @error('phone')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="address" class="form-label">{{ __('account.address') }}</label>
                                <textarea id="address" name="address" rows="3" 
                                          class="form-input @error('address') error @enderror">{{ old('address', auth()->user()->address) }}</textarea>
                                @error('address')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">{{ __('account.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="account-card" id="profile-password">
                <div class="account-card-header">
                    <h2 class="account-card-title">{{ __('account.change_password') }}</h2>
                    <p>{{ __('account.password_security_intro') }}</p>
                </div>
                <div class="account-card-body">
                    <form action="{{ localized_route('profile.password') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="current_password" class="form-label">{{ __('account.current_password') }}</label>
                            <input type="password" id="current_password" name="current_password" 
                                   class="form-input @error('current_password') error @enderror" required>
                            @error('current_password')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="password" class="form-label">{{ __('account.new_password') }}</label>
                                <input type="password" id="password" name="password" 
                                       class="form-input @error('password') error @enderror" required>
                                @error('password')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">{{ __('account.confirm_password') }}</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       class="form-input" required>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">{{ __('account.change_password') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Inquiry History -->
            <div class="account-card" id="profile-inquiries">
                <div class="account-card-header">
                    <h2 class="account-card-title">{{ __('account.my_requests') }}</h2>
                    <p>{{ __('account.requests_intro') }}</p>
                </div>
                <div class="account-card-body">
                    @if($inquiries->count() > 0)
                        <div class="inquiry-list">
                            @foreach($inquiries as $inquiry)
                                <div class="inquiry-item">
                                    <div class="inquiry-header">
                                        <div class="inquiry-id">#{{ $inquiry->id }}</div>
                                        <span class="badge badge-{{ $inquiry->status }}">
                                            {{ match($inquiry->status) {'new' => __('account.status_new'), 'contacted' => __('account.status_contacted'), 'completed' => __('account.status_completed'), 'cancelled' => __('account.status_cancelled'), default => ucfirst($inquiry->status)} }}
                                        </span>
                                    </div>
                                    <div class="inquiry-meta">
                                        <span>{{ $inquiry->created_at->format('d/m/Y · H:i') }}</span>
                                        <span>•</span>
                                        <span>{{ __('account.products_count', ['count' => count($inquiry->product_ids ?? [])]) }}</span>
                                    </div>
                                    @if($inquiry->message)
                                        <p class="inquiry-message">{{ Str::limit($inquiry->message, 100) }}</p>
                                    @endif
                                    <div class="inquiry-products">
                                        @foreach($inquiry->getProducts() as $product)
                                            <a href="{{ localized_route('products.show', $product->display_slug) }}" class="inquiry-product">
                                                <img src="{{ $product->getPrimaryImageUrl() }}" alt="{{ $product->name }}">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state-sm">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p>{{ __('account.no_requests') }}</p>
                            <a href="{{ localized_route('products.index') }}" class="btn btn-primary">{{ __('account.view_products') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</section>

@endsection
