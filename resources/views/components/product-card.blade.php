{{-- Product Card — Unified Editorial Florist Edition --}}
@props(['product', 'showQuickAdd' => false])

@php
    $primaryImage = $product->productImages()->where('is_primary', true)->first()
        ?? $product->productImages()->first();
    $secondaryImage = $product->productImages()->skip(1)->first();
@endphp

<article class="product-card">
    <a href="{{ route('products.show', $product->display_slug) }}" class="product-card__full-link" aria-label="{{ $product->display_name }}">
        <div class="product-card__image-wrap">
            {{-- Primary image --}}
            <img
                src="{{ $primaryImage?->image_url ?? asset('images/products/placeholder.jpg') }}"
                alt="{{ $product->display_name }}"
                class="product-card__image product-card__image--primary"
                loading="lazy"
                width="300"
                height="375"
            >

            {{-- Secondary image (on hover) --}}
            @if($secondaryImage)
                <img
                    src="{{ $secondaryImage->image_url }}"
                    alt="{{ $product->display_name }}"
                    class="product-card__image product-card__image--secondary"
                    loading="lazy"
                    width="300"
                    height="375"
                >
            @endif

            {{-- Featured badge --}}
            @if($product->is_featured)
                <span class="product-card__badge product-card__badge--featured">
                    Nổi bật
                </span>
            @endif

            {{-- Wishlist button --}}
            <button
                class="product-card__wishlist {{ $product->isFavoritedBy(auth()->user()) ? 'active' : '' }}"
                aria-label="Yêu thích"
                title="Yêu thích"
                data-product-id="{{ $product->id }}"
            >
                <svg viewBox="0 0 24 24" fill="{{ $product->isFavoritedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
            </button>

            {{-- Hover overlay with CTA --}}
            <div class="product-card__overlay">
                <span class="product-card__cta">
                    <span>Xem chi tiết</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </span>
            </div>
        </div>

        {{-- Product Info --}}
        <div class="product-card__info">
            @if($product->category)
                <span class="product-card__category">{{ $product->category->display_name }}</span>
            @endif

            <h3 class="product-card__name">
                {{ $product->display_name }}
            </h3>

            <div class="product-card__price-row">
                <span class="product-card__price">
                    {{ number_format($product->price, 0, ',', '.') }}đ
                </span>
            </div>
        </div>
    </a>
</article>
