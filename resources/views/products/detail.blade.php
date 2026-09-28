@extends('layouts.app')

@section('title', $product->display_name)

@section('content')

<!-- Product Detail Section -->
<div class="product-detail">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">{{ content('breadcrumb_home', 'Trang chủ') }}</a>
            <span class="separator">/</span>
            <a href="{{ route('products.index') }}">{{ content('breadcrumb_products', 'Sản phẩm') }}</a>
            @if($product->category)
                <span class="separator">/</span>
                <a href="{{ route('products.index') }}?categories[]={{ $product->category->id }}">{{ $product->category->name }}</a>
            @endif
            @if($product->subcategory)
                <span class="separator">/</span>
                <span>{{ $product->subcategory->name }}</span>
            @endif
            <span class="separator">/</span>
            <span class="current">{{ $product->display_name }}</span>
        </nav>

        <div class="product-detail-grid">

            {{-- ============= LEFT: Product Gallery ============= --}}
            <div class="product-gallery">
                @php
                    $galleryImages = $product->productImages()->images()->get();
                    $galleryVideos = $product->productImages()->videos()->get();
                    if ($galleryImages->isEmpty() && $galleryVideos->isEmpty()) {
                        $galleryImages = collect([
                            (object) ['image_path' => null, 'id' => 0, 'media_type' => 'image'],
                        ]);
                    }
                    $mainImage = $galleryImages->first();
                @endphp

                {{-- Main large image/video --}}
                <div class="gallery-item--main">
                    <img src="{{ $mainImage && $mainImage->image_path ? asset('storage/' . $mainImage->image_path) : $product->getPrimaryImageUrl() }}"
                         alt="{{ $product->display_name }}"
                         loading="eager"
                         id="mainImage"
                         style="display: block;">
                    
                    <video id="mainVideo" controls style="display: none; width: 100%; height: 100%; object-fit: contain; border-radius: 8px; background: #000;">
                        <source src="" type="video/mp4" id="mainVideoSource">
                        Your browser does not support video.
                    </video>

                    {{-- Discount badge --}}
                    @if($product->discount_percent)
                        <span class="discount-badge">-{{ $product->discount_percent }}%</span>
                    @endif
                </div>

                {{-- Horizontal thumbnails list --}}
                @if($galleryImages->count() > 1 || $galleryVideos->count() > 0)
                    <div class="gallery-thumbnails">
                        @foreach($galleryImages as $index => $image)
                            <div class="gallery-item--thumb {{ $index === 0 ? 'active' : '' }}" 
                                 data-type="image"
                                 onclick="changeMainMedia('{{ $image->image_path ? asset('storage/' . $image->image_path) : $product->getPrimaryImageUrl() }}', 'image', null, this)">
                                <img src="{{ $image->image_path ? asset('storage/' . $image->image_path) : $product->getPrimaryImageUrl() }}"
                                     alt="{{ $product->display_name }}"
                                     loading="lazy">
                            </div>
                        @endforeach
                        
                        @foreach($galleryVideos as $video)
                            <div class="gallery-item--thumb" 
                                 data-type="video"
                                 onclick="changeMainMedia('{{ asset('storage/' . $video->image_path) }}', 'video', '{{ $video->mime_type }}', this)">
                                <div style="position: relative; width: 100%; height: 100%;">
                                    <video style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                                        <source src="{{ asset('storage/' . $video->image_path) }}" type="{{ $video->mime_type }}">
                                    </video>
                                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 32px; height: 32px; background: rgba(0,0,0,0.6); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <svg width="16" height="16" fill="white" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </div>
                                </div>
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
                    <div class="info-badge">{{ content('product_featured_badge', 'Nổi bật') }}</div>
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
                    <span class="rating-count">(0) {{ content('product_reviews_suffix', 'đánh giá') }}</span>
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

                {{-- Variants Selector --}}
                @if($product->variants && $product->variants->count() > 0)
                    <div class="product-options">
                        <label class="options-label">Chọn phiên bản</label>
                        <div class="options-buttons" id="variantSelector">
                            @foreach($product->variants->where('is_active', true) as $index => $variant)
                                @php
                                    // Get all images with fallback to product images
                                    $variantImages = $variant->getAllImages();
                                    $variantImageUrls = $variantImages->map(function($img) {
                                        $path = $img->image_path;
                                        // Handle both ProductImage and ProductVariantImage
                                        if (str_starts_with($path, 'images/')) {
                                            $path = preg_replace('#^/?images/#', '', $path);
                                        }
                                        return asset('storage/' . $path);
                                    })->values();
                                @endphp
                                <button type="button" 
                                        class="option-btn variant-option {{ $index === 0 ? 'active' : '' }}" 
                                        data-variant-id="{{ $variant->id }}"
                                        data-variant-sku="{{ $variant->sku }}"
                                        data-variant-name="{{ $variant->name ?? $variant->sku }}"
                                        data-variant-price="{{ $variant->price ?? $product->price }}"
                                        data-variant-stock="{{ $variant->stock ?? $product->stock }}"
                                        data-variant-images="{{ json_encode($variantImageUrls) }}"
                                        onclick="selectVariant(this)">
                                    {{ $variant->name ?? $variant->sku }}
                                    @if($variant->color)
                                        <span style="font-size: 0.85em; color: var(--color-text-muted);">{{ $variant->color }}</span>
                                    @endif
                                    @if($variant->size)
                                        <span style="font-size: 0.85em; color: var(--color-text-muted);">{{ $variant->size }}</span>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>
                @elseif($product->volume || $product->size)
                    <div class="product-options">
                        <label class="options-label">Dung tích</label>
                        <div class="options-buttons">
                            <button type="button" class="option-btn active">{{ $product->volume ?? $product->size }}</button>
                        </div>
                    </div>
                @endif

                {{-- Short Description --}}
                @if($product->short_description)
                    <div class="product-description">
                        <p>{{ $product->short_description }}</p>
                    </div>
                @endif

                @if($product->specification)
                    <div class="product-description" style="margin-top: 12px;">
                        <strong>Quy cách:</strong> {{ $product->specification }} {{ $product->unit ?? 'bó' }}
                    </div>
                @endif

                {{-- Stock --}}
                <div class="product-stock">{{ $product->stock }} {{ content('product_stock_suffix', 'sản phẩm có sẵn') }}</div>

                {{-- Quantity + Add to Cart --}}
                <form action="{{ route('cart.add') }}" method="POST" class="cart-form" id="cartForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}" id="productIdInput">
                    <input type="hidden" name="variant_id" value="" id="variantIdInput">
                    <div class="cart-actions">
                        <div class="quantity-selector">
                            <button type="button" class="qty-btn" onclick="decreaseQty()" aria-label="{{ content('product_qty_decrease', 'Giảm') }}">−</button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" readonly>
                            <button type="button" class="qty-btn" onclick="increaseQty({{ $product->stock }})" aria-label="{{ content('product_qty_increase', 'Tăng') }}">+</button>
                        </div>
                        <button type="submit" class="btn-add-cart" id="addToCartBtn" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            {{ content('product_add_to_cart', 'Thêm vào giỏ') }}
                        </button>
                    </div>
                </form>

                {{-- Buy Now --}}
                <button type="button" class="btn-buy-now" onclick="quickOrder({{ $product->id }})" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                    {{ content('product_buy_now', 'Đặt hàng nhanh') }}
                </button>

                {{-- Accordion --}}
                <div class="product-accordion">
                    @if($product->description)
                        <div class="accordion-item">
                            <button type="button" class="accordion-header">
                                <span>Mô tả sản phẩm</span>
                                <span class="accordion-icon" aria-hidden="true">+</span>
                            </button>
                            <div class="accordion-content">
                                <x-markdown-renderer :content="$product->description" />
                            </div>
                        </div>
                    @endif
                    
                    <div class="accordion-item">
                        <a href="{{ route('policy', 'chinh-sach-doi-tra') }}" class="accordion-header" style="text-decoration: none;">
                            <span>Chính sách đổi trả</span>
                            <span class="accordion-icon" aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
        </div>
    </div>
</div>

{{-- ============= Recommended Products ============= --}}
<section class="recommended" style="margin-bottom: 4rem;">
    <div class="container">
        <h2 class="section-header">{{ content('product_recommended_title', 'Có thể bạn cũng thích') }}</h2>
        <div class="products-grid">
            @forelse($recommendedProducts as $recommendedProduct)
                <x-product-card :product="$recommendedProduct" />
            @empty
                <p class="empty-text">{{ content('product_recommended_empty', 'Đang cập nhật sản phẩm...') }}</p>
            @endforelse
        </div>
    </div>
</section>

{{-- ============= Recently Viewed ============= --}}
<section class="recently-viewed" style="margin-bottom: 4rem;">
    <div class="container">
        <h2 class="section-header">{{ content('product_recently_viewed_title', 'Sản phẩm đã xem gần đây') }}</h2>
        <div class="products-grid">
            @forelse($recentlyViewed as $viewedProduct)
                <x-product-card :product="$viewedProduct" />
            @empty
                <p class="empty-text">{{ content('product_recently_viewed_empty', 'Chưa có sản phẩm đã xem.') }}</p>
            @endforelse
        </div>
    </div>
</section>

@push('scripts')
<script>
    let currentStock = {{ $product->stock }};
    let currentVariantImages = [];
    let originalImages = [];
    
    // Store original product images on page load
    document.addEventListener('DOMContentLoaded', function() {
        const mainImage = document.getElementById('mainImage');
        const thumbnails = document.querySelectorAll('.gallery-item--thumb');
        
        if (mainImage && mainImage.src) {
            originalImages.push(mainImage.src);
        }
        
        thumbnails.forEach(thumb => {
            const img = thumb.querySelector('img');
            if (img && img.src && thumb.dataset.type === 'image') {
                if (!originalImages.includes(img.src)) {
                    originalImages.push(img.src);
                }
            }
        });
        
        // Set first variant as selected if exists
        const firstVariant = document.querySelector('.variant-option');
        if (firstVariant) {
            selectVariant(firstVariant);
        }
    });
    
    // Select variant and update UI
    function selectVariant(button) {
        // Update active state
        document.querySelectorAll('.variant-option').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        
        // Get variant data
        const variantId = button.dataset.variantId;
        const variantPrice = parseFloat(button.dataset.variantPrice);
        const variantStock = parseInt(button.dataset.variantStock);
        const variantImages = JSON.parse(button.dataset.variantImages || '[]');
        
        // Update hidden form inputs
        document.getElementById('variantIdInput').value = variantId;
        
        // Update price display
        const priceElement = document.querySelector('.price-sale');
        if (priceElement) {
            priceElement.textContent = new Intl.NumberFormat('vi-VN').format(variantPrice) + ' đ';
        }
        
        // Update stock display and controls
        currentStock = variantStock;
        const stockElement = document.querySelector('.product-stock');
        if (stockElement) {
            stockElement.textContent = variantStock + ' {{ content("product_stock_suffix", "sản phẩm có sẵn") }}';
        }
        
        // Update quantity max
        const qtyInput = document.getElementById('quantity');
        if (qtyInput) {
            qtyInput.max = variantStock;
            if (parseInt(qtyInput.value) > variantStock) {
                qtyInput.value = Math.max(1, variantStock);
            }
        }
        
        // Update add to cart button state
        const addToCartBtn = document.getElementById('addToCartBtn');
        const buyNowBtn = document.querySelector('.btn-buy-now');
        if (addToCartBtn) {
            if (variantStock <= 0) {
                addToCartBtn.disabled = true;
                if (buyNowBtn) buyNowBtn.disabled = true;
            } else {
                addToCartBtn.disabled = false;
                if (buyNowBtn) buyNowBtn.disabled = false;
            }
        }
        
        // Update gallery images - always use variant images (fallback already included in data)
        if (variantImages.length > 0) {
            currentVariantImages = variantImages;
            updateGallery(variantImages);
        }
    }
    
    // Update gallery with variant images
    function updateGallery(images) {
        const mainImage = document.getElementById('mainImage');
        const mainVideo = document.getElementById('mainVideo');
        const thumbnailsContainer = document.querySelector('.gallery-thumbnails');
        
        // Hide video, show image
        if (mainVideo) {
            mainVideo.style.display = 'none';
        }
        if (mainImage) {
            mainImage.style.display = 'block';
            // Set first image as main
            if (images.length > 0) {
                mainImage.src = images[0];
            }
        }
        
        // Update thumbnails
        if (thumbnailsContainer) {
            if (images.length > 1) {
                thumbnailsContainer.innerHTML = images.map((img, index) => `
                    <div class="gallery-item--thumb ${index === 0 ? 'active' : ''}" 
                         data-type="image"
                         onclick="changeMainMedia('${img}', 'image', null, this)">
                        <img src="${img}" alt="Product image" loading="lazy">
                    </div>
                `).join('');
                thumbnailsContainer.style.display = 'grid';
            } else {
                // Hide thumbnails if only one image
                thumbnailsContainer.style.display = 'none';
            }
        }
    }

    // Change main media (image or video) on thumbnail click
    function changeMainMedia(src, type, mimeType, thumbElement) {
        const mainImage = document.getElementById('mainImage');
        const mainVideo = document.getElementById('mainVideo');
        const mainVideoSource = document.getElementById('mainVideoSource');
        
        if (type === 'video') {
            // Show video, hide image
            mainImage.style.display = 'none';
            mainVideo.style.display = 'block';
            mainVideoSource.src = src;
            mainVideoSource.type = mimeType;
            mainVideo.load();
        } else {
            // Show image, hide video
            mainVideo.style.display = 'none';
            mainImage.style.display = 'block';
            mainImage.src = src;
        }
        
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
        const actualMax = currentStock || max;
        if (current < actualMax) {
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
        
        // Auto-select first variant if exists
        const firstVariant = document.querySelector('.variant-option.active');
        if (firstVariant) {
            selectVariant(firstVariant);
        }
    });
</script>
@endpush

@endsection
