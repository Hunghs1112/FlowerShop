{{-- Product Card Component --}}
@props(['product'])

<a href="{{ locale_route('products.show', $product->display_slug) }}" class="product-card">
    <div class="product-card-image-wrapper">
        <img
            src="{{ $product->getPrimaryImageUrl() }}"
            alt="{{ $product->display_name }}"
            class="product-card-image"
            loading="lazy"
        >

        <div class="product-card-overlay">
            <span class="product-card-view-button">{{ __('messages.common.view_details') }}</span>
        </div>
    </div>

    <span class="product-card-category">{{ $product->category->display_name ?? __('messages.products.default_category') }}</span>
    <h3 class="product-card-name">{{ $product->display_name }}</h3>
    <div class="product-card-price-wrapper">
        <span class="product-card-price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
    </div>
</a>
