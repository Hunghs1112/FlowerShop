@extends('layouts.app')

@section('title', 'My Account')

@section('content')
<x-page-hero 
    title="Tài khoản"
    description="Quản lý thông tin cá nhân và sở thích của bạn"
    :breadcrumbs="[
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Tài khoản']
    ]"
    height="350px"
/>

<div class="container" style="padding: var(--space-8) var(--space-4);">
    <div class="account-layout">
        <!-- Account Sidebar -->
        <aside class="account-sidebar">
            <div class="account-user">
                <div class="account-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="account-user-info">
                    <h3>{{ auth()->user()->name }}</h3>
                    <p>{{ auth()->user()->email }}</p>
                </div>
            </div>

            <nav class="account-nav">
                <a href="{{ route('profile.show') }}" class="account-nav-item active">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile
                </a>
                <a href="{{ route('favorites.index') }}" class="account-nav-item">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    Favorites
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="account-nav-item">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Account Main Content -->
        <div class="account-main">
            <!-- Profile Information -->
            <div class="account-card">
                <div class="account-card-header">
                    <h2 class="account-card-title">Profile Information</h2>
                </div>
                <div class="account-card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" id="name" name="name" 
                                       value="{{ old('name', auth()->user()->name) }}" 
                                       class="form-input @error('name') error @enderror" required>
                                @error('name')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" 
                                       value="{{ old('email', auth()->user()->email) }}" 
                                       class="form-input @error('email') error @enderror" required>
                                @error('email')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" id="phone" name="phone" 
                                       value="{{ old('phone', auth()->user()->phone) }}" 
                                       class="form-input @error('phone') error @enderror">
                                @error('phone')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <textarea id="address" name="address" rows="3" 
                                          class="form-input @error('address') error @enderror">{{ old('address', auth()->user()->address) }}</textarea>
                                @error('address')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="account-card">
                <div class="account-card-header">
                    <h2 class="account-card-title">Change Password</h2>
                </div>
                <div class="account-card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" id="current_password" name="current_password" 
                                   class="form-input @error('current_password') error @enderror" required>
                            @error('current_password')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" id="password" name="password" 
                                       class="form-input @error('password') error @enderror" required>
                                @error('password')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       class="form-input" required>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Inquiry History -->
            <div class="account-card">
                <div class="account-card-header">
                    <h2 class="account-card-title">My Inquiries</h2>
                </div>
                <div class="account-card-body">
                    @if($inquiries->count() > 0)
                        <div class="inquiry-list">
                            @foreach($inquiries as $inquiry)
                                <div class="inquiry-item">
                                    <div class="inquiry-header">
                                        <div class="inquiry-id">#{{ $inquiry->id }}</div>
                                        <span class="badge badge-{{ $inquiry->status }}">
                                            {{ ucfirst($inquiry->status) }}
                                        </span>
                                    </div>
                                    <div class="inquiry-meta">
                                        <span>{{ $inquiry->created_at->format('M d, Y \a\t H:i') }}</span>
                                        <span>•</span>
                                        <span>{{ count($inquiry->product_ids ?? []) }} products</span>
                                    </div>
                                    @if($inquiry->message)
                                        <p class="inquiry-message">{{ Str::limit($inquiry->message, 100) }}</p>
                                    @endif
                                    <div class="inquiry-products">
                                        @foreach($inquiry->getProducts() as $product)
                                            <a href="{{ route('products.show', $product->slug) }}" class="inquiry-product">
                                                <img src="{{ $product->getPrimaryImage() }}" alt="{{ $product->name }}">
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
                            <p>No inquiries yet</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .account-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: var(--space-8);
    }
    
    @media (max-width: 1024px) {
        .account-layout {
            grid-template-columns: 1fr;
        }
    }
    
    .account-sidebar {
        position: sticky;
        top: var(--space-4);
        height: fit-content;
    }
    
    .account-user {
        display: flex;
        gap: var(--space-4);
        padding: var(--space-6);
        background-color: var(--color-bg-secondary);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        margin-bottom: var(--space-4);
    }
    
    .account-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--color-accent-cool), var(--color-accent-warm));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: var(--font-size-xl);
        font-weight: var(--font-bold);
        flex-shrink: 0;
    }
    
    .account-user-info h3 {
        font-size: var(--font-size-base);
        font-weight: var(--font-semibold);
        margin-bottom: var(--space-1);
    }
    
    .account-user-info p {
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
        margin: 0;
    }
    
    .account-nav {
        display: flex;
        flex-direction: column;
    }
    
    .account-nav-item {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        padding: var(--space-3) var(--space-4);
        color: var(--color-text-secondary);
        text-decoration: none;
        border-radius: var(--radius-md);
        transition: all var(--transition-base);
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        font-size: var(--font-size-base);
    }
    
    .account-nav-item:hover,
    .account-nav-item.active {
        background-color: var(--color-bg-secondary);
        color: var(--color-text);
    }
    
    .account-nav-item.active {
        font-weight: var(--font-semibold);
        color: var(--color-accent-cool);
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-4);
    }
    
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .form-actions {
        margin-top: var(--space-6);
    }
    
    .inquiry-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
    }
    
    .inquiry-item {
        padding: var(--space-4);
        background-color: var(--color-bg);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
    }
    
    .inquiry-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-2);
    }
    
    .inquiry-id {
        font-weight: var(--font-semibold);
        font-family: var(--font-mono);
    }
    
    .inquiry-meta {
        display: flex;
        gap: var(--space-2);
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
        margin-bottom: var(--space-2);
    }
    
    .inquiry-message {
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
        margin-bottom: var(--space-3);
    }
    
    .inquiry-products {
        display: flex;
        gap: var(--space-2);
        flex-wrap: wrap;
    }
    
    .inquiry-product {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        background-color: var(--color-bg-secondary);
    }
    
    .inquiry-product img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .badge-new {
        background-color: var(--color-accent-cool);
    }
    
    .badge-contacted {
        background-color: var(--color-accent-warm);
    }
    
    .badge-completed {
        background-color: var(--color-success);
    }
    
    .empty-state-sm {
        text-align: center;
        padding: var(--space-8) var(--space-4);
    }
    
    .empty-state-sm svg {
        margin: 0 auto var(--space-3);
        color: var(--color-text-secondary);
    }
    
    .empty-state-sm p {
        color: var(--color-text-secondary);
        margin-bottom: var(--space-4);
    }
</style>
@endpush
@endsection
