{{-- Product Card Component --}}
<div class="product-card">
    <div class="product-card-image">
        <a href="{{ route('products.show', $product->slug) }}">
            <img src="{{ $product->getPrimaryImageUrl() }}" alt="{{ $product->name }}">
        </a>

        @auth
            <button 
                class="product-card-favorite {{ auth()->user()->favorites()->where('product_id', $product->id)->exists() ? 'active' : '' }}"
                data-favorite-id="{{ $product->id }}"
                onclick="toggleFavorite({{ $product->id }})"
                title="Add to favorites"
            >
                <svg width="20" height="20" fill="{{ auth()->user()->favorites()->where('product_id', $product->id)->exists() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </button>
        @else
            <button 
                class="product-card-favorite"
                data-favorite-id="{{ $product->id }}"
                onclick="toggleFavorite({{ $product->id }})"
                title="Add to favorites"
            >
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </button>
        @endauth
    </div>

    <div class="product-card-body">
        <h3 class="product-card-title">
            <a href="{{ route('products.show', $product->slug) }}">
                {{ $product->name }}
            </a>
        </h3>

        @if($product->short_description)
            <p class="product-card-description">
                {{ Str::limit($product->short_description, 80) }}
            </p>
        @endif

        <div class="product-card-footer">
            <div class="product-card-price">
                {{ number_format($product->price, 0, ',', '.') }}₫
            </div>

            <div class="product-card-actions">
                <button 
                    class="btn btn-primary btn-sm"
                    onclick="addToCart({{ $product->id }})"
                    title="Add to cart"
                >
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
