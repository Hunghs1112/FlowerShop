@extends('layouts.app')

@section('title', $product->display_name)

@section('content')

<!-- Product Detail Section -->
<div class="product-detail">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('products.index') }}">Sản phẩm</a>
            @if($product->category)
                <span class="separator">/</span>
                <a href="{{ route('products.index') }}?categories[]={{ $product->category->id }}">{{ $product->category->name }}</a>
            @endif
            <span class="separator">/</span>
            <span class="current">{{ $product->display_name }}</span>
        </nav>

        <div class="product-detail-grid">

            {{-- ============= LEFT: Product Gallery ============= --}}
            <div class="product-gallery">
                @php
                    $galleryImages = $product->productImages;
                    if ($galleryImages->isEmpty()) {
                        $galleryImages = collect([
                            (object) ['image_path' => null, 'id' => 0],
                        ]);
                    }
                    $mainImage = $galleryImages->first();
                @endphp

                {{-- Main large image --}}
                <div class="gallery-item--main">
                    <img src="{{ $mainImage->image_path ? asset('storage/' . $mainImage->image_path) : $product->getPrimaryImageUrl() }}"
                         alt="{{ $product->display_name }}"
                         loading="eager"
                         id="mainImage">

                    {{-- Discount badge --}}
                    @if($product->discount_percent)
                        <span class="discount-badge">-{{ $product->discount_percent }}%</span>
                    @endif
                </div>

                {{-- Horizontal thumbnails list --}}
                @if($galleryImages->count() > 1)
                    <div class="gallery-thumbnails">
                        @foreach($galleryImages as $index => $image)
                            <div class="gallery-item--thumb {{ $index === 0 ? 'active' : '' }}" 
                                 onclick="changeMainImage('{{ $image->image_path ? asset('storage/' . $image->image_path) : $product->getPrimaryImageUrl() }}', this)">
                                <img src="{{ $image->image_path ? asset('storage/' . $image->image_path) : $product->getPrimaryImageUrl() }}"
                                     alt="{{ $product->display_name }}"
                                     loading="lazy">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ============= RIGHT: Product Information ============= --}}
            <div class="product-info">

                {{-- Discount badge --}}
                @if($product->discount_percent)
                    <div class="info-badge">-{{ $product->discount_percent }}%</div>
                @elseif($product->is_featured)
                    <div class="info-badge">Nổi bật</div>
                @endif

                {{-- Product Title --}}
                <h1 class="product-title">{{ $product->display_name }}</h1>

                {{-- Rating --}}
                <div class="product-rating">
                    <div class="rating-stars" aria-hidden="true">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <span class="rating-value">(0.0)</span>
                    <span class="rating-count">(0) đánh giá</span>
                </div>

                {{-- Price --}}
                <div class="price-section">
                    <div class="price-row">
                        <span class="price-sale">{{ number_format($product->sale_price ?? $product->price, 0, ',', '.') }} đ</span>
                        @if($product->original_price && $product->original_price > ($product->sale_price ?? $product->price))
                            <span class="price-original">{{ number_format($product->original_price, 0, ',', '.') }} đ</span>
                        @endif
                    </div>
                    @if($product->original_price && $product->original_price > ($product->sale_price ?? $product->price))
                        <div class="price-saved">
                            Tiết kiệm {{ number_format($product->original_price - ($product->sale_price ?? $product->price), 0, ',', '.') }} đ
                        </div>
                    @endif
                </div>

                {{-- Options: Dung tích --}}
                @if($product->volume || $product->size)
                    <div class="product-options">
                        <label class="options-label">Dung tích</label>
                        <div class="options-buttons">
                            <button type="button" class="option-btn active">{{ $product->volume ?? $product->size }}</button>
                        </div>
                    </div>
                @endif

                {{-- Stock --}}
                <div class="product-stock">{{ $product->stock }} sản phẩm có sẵn</div>

                {{-- Quantity + Add to Cart --}}
                <form action="{{ route('cart.add') }}" method="POST" class="cart-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="cart-actions">
                        <div class="quantity-selector">
                            <button type="button" class="qty-btn" onclick="decreaseQty()" aria-label="Giảm">−</button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" readonly>
                            <button type="button" class="qty-btn" onclick="increaseQty({{ $product->stock }})" aria-label="Tăng">+</button>
                        </div>
                        <button type="submit" class="btn-add-cart" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Thêm vào giỏ
                        </button>
                    </div>
                </form>

                {{-- Buy Now --}}
                <button type="button" class="btn-buy-now" onclick="quickOrder({{ $product->id }})" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                    Đặt hàng nhanh
                </button>

                {{-- Accordion --}}
                <div class="product-accordion">
                    <div class="accordion-item">
                        <button type="button" class="accordion-header">
                            <span>Chính sách đổi trả</span>
                            <span class="accordion-icon" aria-hidden="true">+</span>
                        </button>
                        <div class="accordion-content">
                            <p>Chúng tôi cam kết chất lượng sản phẩm 100%. Nếu sản phẩm có vấn đề về chất lượng hoặc không đúng mô tả, quý khách vui lòng liên hệ trong vòng 7 ngày để được đổi/trả hoặc hoàn tiền.</p>
                            <p><strong>Điều kiện đổi trả:</strong></p>
                            <ul>
                                <li>Sản phẩm còn nguyên seal, chưa qua sử dụng</li>
                                <li>Còn hóa đơn mua hàng</li>
                                <li>Lỗi từ nhà sản xuất</li>
                            </ul>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

{{-- ============= Recommended Products ============= --}}
<section class="recommended" style="margin-bottom: 4rem;">
    <div class="container">
        <h2 class="section-header">Có thể bạn cũng thích</h2>
        <div class="products-grid">
            @forelse($recommendedProducts as $recommendedProduct)
                <x-product-card :product="$recommendedProduct" />
            @empty
                <p class="empty-text">Đang cập nhật sản phẩm...</p>
            @endforelse
        </div>
    </div>
</section>

{{-- ============= Recently Viewed ============= --}}
<section class="recently-viewed" style="margin-bottom: 4rem;">
    <div class="container">
        <h2 class="section-header">Sản phẩm đã xem gần đây</h2>
        <div class="products-grid">
            @forelse($recentlyViewed as $viewedProduct)
                <x-product-card :product="$viewedProduct" />
            @empty
                <p class="empty-text">Chưa có sản phẩm đã xem.</p>
            @endforelse
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Change main image on thumbnail click
    function changeMainImage(src, thumbElement) {
        const mainImage = document.getElementById('mainImage');
        mainImage.src = src;
        
        // Update active state
        document.querySelectorAll('.gallery-item--thumb').forEach(thumb => {
            thumb.classList.remove('active');
        });
        thumbElement.classList.add('active');
    }

    // Quantity controls
    function increaseQty(max) {
        const input = document.getElementById('quantity');
        const current = parseInt(input.value) || 1;
        if (current < max) {
            input.value = current + 1;
        }
    }

    function decreaseQty() {
        const input = document.getElementById('quantity');
        const current = parseInt(input.value) || 1;
        if (current > 1) {
            input.value = current - 1;
        }
    }

    function quickOrder(productId) {
        @auth
            window.location.href = '{{ route("checkout.index") }}';
        @else
            alert('Vui lòng đăng nhập để đặt hàng nhanh');
            window.location.href = '{{ route("login") }}';
        @endauth
    }

    // Accordion functionality
    document.addEventListener('DOMContentLoaded', function() {
        const accordionHeaders = document.querySelectorAll('.accordion-header');

        accordionHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const item = this.parentElement;
                const isActive = item.classList.contains('active');

                // Close all
                document.querySelectorAll('.accordion-item').forEach(i => {
                    i.classList.remove('active');
                });

                // Open clicked if it was closed
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });
    });
</script>
@endpush

@endsection
