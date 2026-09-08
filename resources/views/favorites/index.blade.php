@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')
<x-page-hero 
    title="Yêu thích"
    description="Các sản phẩm bạn đã lưu để mua sau"
    :breadcrumbs="[
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Tài khoản', 'url' => route('profile.show')],
        ['label' => 'Yêu thích']
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
                <a href="{{ route('profile.show') }}" class="account-nav-item">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile
                </a>
                <a href="{{ route('favorites.index') }}" class="account-nav-item active">
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

        <!-- Favorites Main Content -->
        <div class="account-main">
            <div class="account-card">
                <div class="account-card-header">
                    <h2 class="account-card-title">My Favorites</h2>
                    @if($favorites->count() > 0)
                        <span class="favorites-count">{{ $favorites->count() }} items</span>
                    @endif
                </div>
                <div class="account-card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($favorites->count() > 0)
                        <div class="favorites-grid">
                            @foreach($favorites as $favorite)
                                @php
                                    $product = $favorite->product;
                                @endphp
                                <div class="product-card">
                                    <div class="product-card-image">
                                        <a href="{{ route('products.show', $product->slug) }}">
                                            <img src="{{ $product->getPrimaryImage() }}" alt="{{ $product->name }}">
                                        </a>
                                        @if($product->stock <= 0)
                                            <span class="badge badge-danger product-badge">Out of Stock</span>
                                        @elseif($product->is_featured)
                                            <span class="badge badge-accent product-badge">Featured</span>
                                        @endif
                                        <form action="{{ route('favorites.destroy', $favorite->id) }}" method="POST" class="favorite-remove">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="favorite-btn active" title="Remove from favorites">
                                                <svg width="20" height="20" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="product-card-info">
                                        <h3 class="product-card-name">
                                            <a href="{{ route('products.show', $product->slug) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                        @if($product->short_description)
                                            <p class="product-card-description">
                                                {{ Str::limit($product->short_description, 60) }}
                                            </p>
                                        @endif
                                        <div class="product-card-price">
                                            {{ number_format($product->price, 0, ',', '.') }}₫
                                        </div>
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary btn-block" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state-sm">
                            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <h3>No favorites yet</h3>
                            <p>Start adding products to your favorites to see them here</p>
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
    .account-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .favorites-count {
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
        font-weight: var(--font-medium);
    }
    
    .favorites-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: var(--space-6);
    }
    
    @media (max-width: 640px) {
        .favorites-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .favorite-remove {
        position: absolute;
        top: var(--space-3);
        right: var(--space-3);
    }
    
    .favorite-btn.active {
        background-color: var(--color-accent-warm);
        border-color: var(--color-accent-warm);
    }
    
    .favorite-btn.active:hover {
        background-color: var(--color-error);
        border-color: var(--color-error);
    }
    
    .empty-state-sm {
        text-align: center;
        padding: var(--space-12) var(--space-4);
    }
    
    .empty-state-sm svg {
        margin: 0 auto var(--space-4);
        color: var(--color-text-secondary);
        opacity: 0.5;
    }
    
    .empty-state-sm h3 {
        font-size: var(--font-size-xl);
        font-weight: var(--font-semibold);
        margin-bottom: var(--space-2);
    }
    
    .empty-state-sm p {
        color: var(--color-text-secondary);
        margin-bottom: var(--space-6);
    }
</style>
@endpush
@endsection
