{{-- Product Card Component --}}
@props(['product'])

<a href="{{ route('products.show', $product->slug) }}" class="product-card">
    <div class="product-card-image-wrapper">
        <img
            src="{{ $product->getPrimaryImageUrl() }}"
            alt="{{ $product->name }}"
            class="product-card-image"
            loading="lazy"
        >

        <button
            class="product-card-wishlist"
            data-product-id="{{ $product->id }}"
            aria-label="Thêm vào yêu thích"
        >
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        </button>

        <div class="product-card-overlay">
            <span class="product-card-view-button">Xem chi tiết</span>
        </div>
    </div>

    <span class="product-card-category">{{ $product->category->name ?? 'Hoa tươi' }}</span>
    <h3 class="product-card-name">{{ $product->name }}</h3>
    <div class="product-card-price-wrapper">
        <span class="product-card-price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
    </div>
</a>
