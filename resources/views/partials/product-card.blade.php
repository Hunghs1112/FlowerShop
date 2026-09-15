{{-- Product Card Component --}}
<div class="product-card">
    <div class="product-card-image">
        <a href="{{ route('products.show', $product->display_slug) }}">
            <img src="{{ $product->getPrimaryImageUrl() }}" alt="{{ $product->display_name }}">
        </a>
    </div>

    <div class="product-card-body">
        <h3 class="product-card-title">
            <a href="{{ route('products.show', $product->display_slug) }}">
                {{ $product->display_name }}
            </a>
        </h3>

        @if($product->short_description)
            <p class="product-card-description">
                {{ Str::limit($product->display_short_description, 80) }}
            </p>
        @endif

        <div class="product-card-footer">
            <div class="product-card-price">
                {{ number_format($product->price, 0, ',', '.') }}đ
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
