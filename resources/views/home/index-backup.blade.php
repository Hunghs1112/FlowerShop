@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section with Text Slider -->
<section class="hero" id="heroSection">
    <!-- Background Image - Fixed for all slides -->
    <div class="hero-background">
        <img 
            src="https://images.unsplash.com/photo-1518895949257-7621c3c786d7?q=80&w=2400&auto=format&fit=crop" 
            alt="Premium Fresh Flowers" 
            class="hero-background-image"
            loading="eager"
        >
    </div>

    <!-- Content Container -->
    <div class="hero-container">
        <div class="hero-content">
            <!-- Slide 01 -->
            <div class="hero-slide active" data-slide="0">
                <span class="hero-label">HOA TƯƠI MỖI NGÀY</span>
                <h1 class="hero-title">
                    Trao hoa,<br>
                    trao những điều đẹp nhất
                </h1>
                <p class="hero-description">
                    Những bó hoa tươi được tuyển chọn kỹ lưỡng,
                    gói ghém trọn vẹn tình cảm dành cho người bạn yêu thương.
                </p>
                <a href="{{ locale_route('products.index') }}" class="hero-cta">
                    Khám phá hoa tươi
                    <svg class="hero-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            <!-- Slide 02 -->
            <div class="hero-slide" data-slide="1">
                <span class="hero-label">HOA NHẬP KHẨU</span>
                <h1 class="hero-title">
                    Vẻ đẹp tinh tế<br>
                    từ những mùa hoa trên thế giới
                </h1>
                <p class="hero-description">
                    Khám phá những giống hoa nhập khẩu được tuyển chọn
                    và chăm sóc cẩn thận để giữ trọn vẻ đẹp tự nhiên.
                </p>
                <a href="{{ locale_route('categories.index') }}" class="hero-cta">
                    Khám phá hoa nhập khẩu
                    <svg class="hero-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            <!-- Slide 03 -->
            <div class="hero-slide" data-slide="2">
                <span class="hero-label">DỊP ĐẶC BIỆT</span>
                <h1 class="hero-title">
                    Một bó hoa,<br>
                    ngàn lời muốn nói
                </h1>
                <p class="hero-description">
                    Những thiết kế hoa dành riêng cho sinh nhật,
                    kỷ niệm, tình yêu và những khoảnh khắc đáng nhớ.
                </p>
                <a href="{{ locale_route('products.index') }}?category=special" class="hero-cta">
                    Chọn hoa cho dịp đặc biệt
                    <svg class="hero-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Slider Controls -->
    <div class="hero-controls">
        <!-- Slide Indicators with Progress -->
        <div class="hero-indicators">
            <button class="hero-indicator active" data-index="0" aria-label="Slide 1">
                <div class="hero-indicator-progress"></div>
            </button>
            <button class="hero-indicator" data-index="1" aria-label="Slide 2">
                <div class="hero-indicator-progress"></div>
            </button>
            <button class="hero-indicator" data-index="2" aria-label="Slide 3">
                <div class="hero-indicator-progress"></div>
            </button>
        </div>

        <!-- Slide Counter -->
        <div class="hero-counter">
            <span class="hero-counter-current">01</span>
            <span class="hero-counter-separator">/</span>
            <span class="hero-counter-total">03</span>
        </div>
    </div>
</section>

<!-- Best Selling Products Section -->
<section class="products-section">
    <div class="products-container">
        <!-- Section Header -->
        <div class="products-header">
            <h2 class="products-title">Sản phẩm bán chạy</h2>
            
            <!-- Category Tabs -->
            <div class="products-tabs">
                <button class="products-tab active" data-category="best-selling">Bán chạy nhất</button>
                <button class="products-tab" data-category="new-arrival">Hoa mới về</button>
                <button class="products-tab" data-category="bouquet">Bó hoa</button>
                <button class="products-tab" data-category="box">Hộp hoa</button>
                <button class="products-tab" data-category="imported">Hoa nhập khẩu</button>
            </div>
            
            <div class="products-divider"></div>
        </div>

        <!-- Products Grid -->
        <div class="products-grid" id="productsGrid">
            <!-- Product 1 -->
            <a href="{{ locale_route('products.show', 1) }}" class="product-card">
                <div class="product-image-container">
                    <img 
                        src="https://images.unsplash.com/photo-1561181286-d3fee7d55364?w=600&q=80" 
                        alt="Bó hoa hồng Ecuador thanh lịch" 
                        class="product-image primary"
                        loading="lazy"
                    >
                    <img 
                        src="https://images.unsplash.com/photo-1582794543139-8ac9cb0f7b11?w=600&q=80" 
                        alt="Bó hoa hồng Ecuador - góc khác" 
                        class="product-image secondary"
                        loading="lazy"
                    >
                    <span class="product-discount-badge">-20%</span>
                    
                    <!-- Desktop Wishlist (hover only) -->
                    <button class="product-wishlist-desktop" aria-label="Thêm vào yêu thích">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    
                    <!-- Mobile Wishlist (always visible) -->
                    <button class="product-wishlist-mobile" aria-label="Thêm vào yêu thích">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    
                    <!-- Action Overlay (desktop hover only) -->
                    <div class="product-action-overlay">
                        <a href="{{ locale_route('products.show', 1) }}" class="product-action-btn">
                            Xem chi tiết
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="product-content">
                    <span class="product-category">Hoa hồng</span>
                    <h3 class="product-name">Bó hoa hồng Ecuador thanh lịch</h3>
                    <div class="product-price-wrapper">
                        <span class="product-price">850.000 ₫</span>
                        <span class="product-price-old">1.050.000 ₫</span>
                    </div>
                </div>
            </a>

            <!-- Product 2 -->
            <a href="{{ locale_route('products.show', 2) }}" class="product-card">
                <div class="product-image-container">
                    <img 
                        src="https://images.unsplash.com/photo-1490750967868-88aa4486c946?w=600&q=80" 
                        alt="Bó hoa tulip Hà Lan mùa xuân" 
                        class="product-image primary"
                        loading="lazy"
                    >
                    <img 
                        src="https://images.unsplash.com/photo-1522057306215-929425a4e12d?w=600&q=80" 
                        alt="Bó hoa tulip - góc khác" 
                        class="product-image secondary"
                        loading="lazy"
                    >
                    <span class="product-discount-badge">-17%</span>
                    
                    <button class="product-wishlist-desktop" aria-label="Thêm vào yêu thích">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    
                    <button class="product-wishlist-mobile" aria-label="Thêm vào yêu thích">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    
                    <div class="product-action-overlay">
                        <a href="{{ locale_route('products.show', 2) }}" class="product-action-btn">
                            Xem chi tiết
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="product-content">
                    <span class="product-category">Hoa nhập khẩu</span>
                    <h3 class="product-name">Bó hoa tulip Hà Lan mùa xuân</h3>
                    <div class="product-price-wrapper">
                        <span class="product-price">1.200.000 ₫</span>
                        <span class="product-price-old">1.450.000 ₫</span>
                    </div>
                </div>
            </a>

            <!-- Product 3 -->
            <a href="{{ locale_route('products.show', 3) }}" class="product-card">
                <div class="product-image-container">
                    <img 
                        src="https://images.unsplash.com/photo-1563241527-3004b7be0ffd?w=600&q=80" 
                        alt="Bó hoa pastel dịu dàng" 
                        class="product-image primary"
                        loading="lazy"
                    >
                    <img 
                        src="https://images.unsplash.com/photo-1518895949257-7621c3c786d7?w=600&q=80" 
                        alt="Bó hoa pastel - góc khác" 
                        class="product-image secondary"
                        loading="lazy"
                    >
                    <span class="product-discount-badge">-20%</span>
                    
                    <button class="product-wishlist-desktop" aria-label="Thêm vào yêu thích">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    
                    <button class="product-wishlist-mobile" aria-label="Thêm vào yêu thích">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    
                    <div class="product-action-overlay">
                        <a href="{{ locale_route('products.show', 3) }}" class="product-action-btn">
                            Xem chi tiết
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="product-content">
                    <span class="product-category">Bó hoa</span>
                    <h3 class="product-name">Bó hoa pastel dịu dàng</h3>
                    <div class="product-price-wrapper">
                        <span class="product-price">680.000 ₫</span>
                        <span class="product-price-old">850.000 ₫</span>
                    </div>
                </div>
            </a>

            <!-- Product 4 -->
            <a href="{{ locale_route('products.show', 4) }}" class="product-card">
                <div class="product-image-container">
                    <img 
                        src="https://images.unsplash.com/photo-1535332371349-a5d229f49cb5?w=600&q=80" 
                        alt="Bó hoa cưới trắng tinh khôi" 
                        class="product-image primary"
                        loading="lazy"
                    >
                    <img 
                        src="https://images.unsplash.com/photo-1591886960571-74d43a9d4166?w=600&q=80" 
                        alt="Bó hoa cưới - góc khác" 
                        class="product-image secondary"
                        loading="lazy"
                    >
                    <span class="product-discount-badge">-17%</span>
                    
                    <button class="product-wishlist-desktop" aria-label="Thêm vào yêu thích">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    
                    <button class="product-wishlist-mobile" aria-label="Thêm vào yêu thích">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    
                    <div class="product-action-overlay">
                        <a href="{{ locale_route('products.show', 4) }}" class="product-action-btn">
                            Xem chi tiết
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="product-content">
                    <span class="product-category">Hoa cưới</span>
                    <h3 class="product-name">Bó hoa cưới trắng tinh khôi</h3>
                    <div class="product-price-wrapper">
                        <span class="product-price">950.000 ₫</span>
                        <span class="product-price-old">1.150.000 ₫</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- View All Button -->
        <div class="products-footer">
            <a href="{{ locale_route('products.index') }}" class="products-view-all">
                Xem tất cả sản phẩm
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="section" style="background-color: var(--color-bg-secondary);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Featured Products</h2>
            <p class="section-subtitle">Handpicked selection of our finest flowers</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>

        <div class="section-action">
            <a href="{{ locale_route('products.index') }}" class="btn btn-primary">
                View All Products
            </a>
        </div>
    </div>
</section>

<!-- Latest Blog Posts -->
@if($latestPosts->count() > 0)
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Tips & Trends</h2>
            <p class="section-subtitle">Latest news, care tips, and floral inspiration</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($latestPosts as $post)
                <article class="post-card">
                    @if($post->image_url)
                        <div class="post-card-image">
                            <a href="{{ locale_route('blog.show', $post->slug) }}">
                                <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                            </a>
                        </div>
                    @endif
                    <div class="post-card-body">
                        <div class="post-card-meta">
                            <span class="post-card-date">
                                {{ $post->published_at->format('M d, Y') }}
                            </span>
                        </div>
                        <h3 class="post-card-title">
                            <a href="{{ locale_route('blog.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="post-card-excerpt">
                            {{ Str::limit($post->excerpt, 100) }}
                        </p>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="section-action">
            <a href="{{ locale_route('blog.index') }}" class="btn btn-outline">
                Read More Articles
            </a>
        </div>
    </div>
</section>
@endif

@push('styles')
<style>
    .section {
        padding: var(--space-16) 0;
    }
    
    .section-header {
        text-align: center;
        margin-bottom: var(--space-12);
    }
    
    .section-title {
        font-size: var(--font-size-3xl);
        font-weight: var(--font-bold);
        margin-bottom: var(--space-3);
    }
    
    .section-subtitle {
        font-size: var(--font-size-lg);
        color: var(--color-text-secondary);
    }
    
    .section-action {
        text-align: center;
        margin-top: var(--space-12);
    }
    
    .grid {
        display: grid;
    }
    
    .grid-cols-1 {
        grid-template-columns: 1fr;
    }
    
    .gap-6 {
        gap: var(--space-6);
    }
    
    @media (min-width: 768px) {
        .md\\:grid-cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }
        .md\\:grid-cols-3 {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (min-width: 1024px) {
        .lg\\:grid-cols-4 {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    
    .category-card {
        background-color: var(--color-bg-secondary);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        transition: all var(--transition-base);
        display: block;
    }
    
    .category-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--color-accent-cool);
    }
    
    .category-card-image {
        aspect-ratio: 4/3;
        overflow: hidden;
    }
    
    .category-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform var(--transition-slow);
    }
    
    .category-card:hover .category-card-image img {
        transform: scale(1.05);
    }
    
    .category-card-body {
        padding: var(--space-4);
    }
    
    .category-card-title {
        font-size: var(--font-size-lg);
        font-weight: var(--font-semibold);
        margin-bottom: var(--space-1);
    }
    
    .category-card-count {
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
    }
</style>
@endpush

<!-- Categories Discovery Section -->
<section class="categories-section">
    <div class="categories-container">
        <!-- Left Side - Image Cards -->
        <div class="categories-images">
            <!-- Category Card 1 - Roses -->
            <a href="{{ locale_route('products.index', ['category' => 'roses']) }}" class="category-image-card">
                <img 
                    src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=800&q=80" 
                    alt="Hoa hồng cao cấp"
                    loading="lazy"
                >
                <div class="category-image-overlay"></div>
                <div class="category-image-content">
                    <h3 class="category-image-title">HOA HỒNG</h3>
                    <p class="category-image-count">120+ sản phẩm</p>
                </div>
            </a>
            
            <!-- Category Card 2 - Imported Flowers -->
            <a href="{{ locale_route('products.index', ['category' => 'imported']) }}" class="category-image-card">
                <img 
                    src="https://images.unsplash.com/photo-1563241527-3004b7be0ffd?w=800&q=80" 
                    alt="Hoa nhập khẩu cao cấp"
                    loading="lazy"
                >
                <div class="category-image-overlay"></div>
                <div class="category-image-content">
                    <h3 class="category-image-title">HOA NHẬP KHẨU</h3>
                    <p class="category-image-count">85+ sản phẩm</p>
                </div>
            </a>
        </div>
        
        <!-- Right Side - Content -->
        <div class="categories-content">
            <span class="categories-label">KHÁM PHÁ HOA</span>
            <h2 class="categories-heading">Khám phá danh mục</h2>
            <div class="categories-heading-decoration"></div>
            
            <ul class="categories-list">
                <li class="category-list-item">
                    <a href="{{ locale_route('products.index', ['category' => 'fresh-flowers']) }}" class="category-list-link">
                        <span class="category-list-name">Hoa tươi</span>
                        <div class="category-list-arrow">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </a>
                </li>
                
                <li class="category-list-item">
                    <a href="{{ locale_route('products.index', ['category' => 'imported']) }}" class="category-list-link">
                        <span class="category-list-name">Hoa nhập khẩu</span>
                        <div class="category-list-arrow">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </a>
                </li>
                
                <li class="category-list-item">
                    <a href="{{ locale_route('products.index', ['category' => 'bouquet']) }}" class="category-list-link">
                        <span class="category-list-name">Bó hoa</span>
                        <div class="category-list-arrow">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </a>
                </li>
                
                <li class="category-list-item">
                    <a href="{{ locale_route('products.index', ['category' => 'box']) }}" class="category-list-link">
                        <span class="category-list-name">Hộp hoa</span>
                        <div class="category-list-arrow">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </a>
                </li>
                
                <li class="category-list-item">
                    <a href="{{ locale_route('products.index', ['category' => 'wedding']) }}" class="category-list-link">
                        <span class="category-list-name">Hoa cưới</span>
                        <div class="category-list-arrow">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </a>
                </li>
                
                <li class="category-list-item">
                    <a href="{{ locale_route('products.index', ['category' => 'seasonal']) }}" class="category-list-link">
                        <span class="category-list-name">Hoa theo mùa</span>
                        <div class="category-list-arrow">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- Brand Values Section -->
<section class="brand-values-section">
    <div class="brand-values-container">
        <div class="brand-values-grid">
            <!-- Value 1 - Fresh Flowers -->
            <div class="brand-value-item">
                <div class="brand-value-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 5v10m-5-5h10"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.5c0 .5-2 3-2 6s2 5.5 2 6 2-3 2-6-2-5.5-2-6zm-4 4c-.5 0-3 2-6 2s-5.5 2-6 2 3 2 6 2 5.5-2 6-2zm8 0c.5 0 3 2 6 2s5.5 2 6 2-3 2-6 2-5.5-2-6-2z"/>
                    </svg>
                </div>
                <h3 class="brand-value-heading">Hoa tươi được tuyển chọn mỗi ngày</h3>
                <p class="brand-value-description">Chúng tôi lựa chọn những bông hoa đẹp nhất từ các nhà vườn uy tín để đảm bảo độ tươi và vẻ đẹp tự nhiên.</p>
            </div>
            
            <!-- Value 2 - Careful Delivery -->
            <div class="brand-value-item">
                <div class="brand-value-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                    </svg>
                </div>
                <h3 class="brand-value-heading">Gói hoa chỉn chu, giao tận tay</h3>
                <p class="brand-value-description">Mỗi bó hoa được thiết kế và đóng gói cẩn thận trước khi trao đến người bạn yêu thương.</p>
            </div>
            
            <!-- Value 3 - Natural Beauty -->
            <div class="brand-value-item">
                <div class="brand-value-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <h3 class="brand-value-heading">Đẹp tự nhiên, trọn vẹn cảm xúc</h3>
                <p class="brand-value-description">Ưu tiên hoa theo mùa, vật liệu thân thiện và những thiết kế giữ trọn vẻ đẹp tự nhiên của hoa.</p>
            </div>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="partners-section">
    <div class="partners-container">
        <!-- Header -->
        <div class="partners-header">
            <h2 class="partners-heading">Những nhà vườn<br>chúng tôi tin tưởng</h2>
            <p class="partners-subheading">Đồng hành cùng những nhà vườn và đối tác uy tín để mang đến những mùa hoa đẹp nhất.</p>
        </div>
        
        <!-- Logo Showcase -->
        <div class="partners-logos">
            <!-- Partner 1 -->
            <div class="partner-logo-item">
                <div class="partner-logo-text">FlowerFarm</div>
            </div>
            
            <!-- Partner 2 -->
            <div class="partner-logo-item">
                <div class="partner-logo-text">EcoGarden</div>
            </div>
            
            <!-- Partner 3 -->
            <div class="partner-logo-item">
                <div class="partner-logo-text">BloomCo</div>
            </div>
            
            <!-- Partner 4 -->
            <div class="partner-logo-item">
                <div class="partner-logo-text">PetalSource</div>
            </div>
            
            <!-- Partner 5 -->
            <div class="partner-logo-item">
                <div class="partner-logo-text">GreenValley</div>
            </div>
        </div>
    </div>
</section>

<!-- Inspiration/Blog Section -->
<section class="inspiration-section">
    <div class="inspiration-container">
        <!-- Header -->
        <div class="inspiration-header">
            <div class="inspiration-eyebrow">GÓC NHỎ CỦA CHÚNG TÔI</div>
            <h2 class="inspiration-heading">Cảm hứng từ những mùa hoa</h2>
            <p class="inspiration-description">Những câu chuyện, bí quyết chăm hoa và cảm hứng để bạn mang vẻ đẹp của hoa vào cuộc sống mỗi ngày.</p>
        </div>
        
        <!-- Blog Grid -->
        <div class="inspiration-grid">
            <!-- Blog Card 1 -->
            <a href="#" class="blog-card">
                <div class="blog-card-image-container">
                    <img 
                        src="https://images.unsplash.com/photo-1490750967868-88aa4486c946?w=800&q=80" 
                        alt="Cách giữ hoa tươi lâu"
                        class="blog-card-image"
                        loading="lazy"
                    >
                    <span class="blog-card-category">Chăm hoa</span>
                </div>
                <div class="blog-card-content">
                    <h3 class="blog-card-title">Cách giữ hoa tươi lâu và đẹp trong nhiều ngày</h3>
                    <p class="blog-card-excerpt">Một vài mẹo đơn giản giúp bó hoa của bạn luôn giữ được vẻ đẹp tự nhiên...</p>
                    <span class="blog-card-link">
                        Đọc bài viết
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </span>
                </div>
            </a>
            
            <!-- Blog Card 2 -->
            <a href="#" class="blog-card">
                <div class="blog-card-image-container">
                    <img 
                        src="https://images.unsplash.com/photo-1455659817273-f96807779a8a?w=800&q=80" 
                        alt="Hoa theo mùa"
                        class="blog-card-image"
                        loading="lazy"
                    >
                    <span class="blog-card-category">Hoa theo mùa</span>
                </div>
                <div class="blog-card-content">
                    <h3 class="blog-card-title">Những loài hoa đẹp nhất mùa xuân</h3>
                    <p class="blog-card-excerpt">Khám phá vẻ đẹp của những loài hoa đặc trưng mùa xuân và ý nghĩa của chúng...</p>
                    <span class="blog-card-link">
                        Đọc bài viết
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </span>
                </div>
            </a>
            
            <!-- Blog Card 3 -->
            <a href="#" class="blog-card">
                <div class="blog-card-image-container">
                    <img 
                        src="https://images.unsplash.com/photo-1519037523943-7e595a6cec01?w=800&q=80" 
                        alt="Cảm hứng cắm hoa"
                        class="blog-card-image"
                        loading="lazy"
                    >
                    <span class="blog-card-category">Cảm hứng</span>
                </div>
                <div class="blog-card-content">
                    <h3 class="blog-card-title">Nghệ thuật phối màu trong cắm hoa</h3>
                    <p class="blog-card-excerpt">Học cách kết hợp màu sắc và hoa để tạo nên những bó hoa hài hòa và ấn tượng...</p>
                    <span class="blog-card-link">
                        Đọc bài viết
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </span>
                </div>
            </a>
            
            <!-- Blog Card 4 -->
            <a href="#" class="blog-card">
                <div class="blog-card-image-container">
                    <img 
                        src="https://images.unsplash.com/photo-1464297162577-f5295c892194?w=800&q=80" 
                        alt="Ý nghĩa hoa hồng"
                        class="blog-card-image"
                        loading="lazy"
                    >
                    <span class="blog-card-category">Kiến thức hoa</span>
                </div>
                <div class="blog-card-content">
                    <h3 class="blog-card-title">Ý nghĩa màu sắc của hoa hồng</h3>
                    <p class="blog-card-excerpt">Mỗi màu hoa hồng mang một thông điệp riêng, tìm hiểu để chọn hoa phù hợp nhất...</p>
                    <span class="blog-card-link">
                        Đọc bài viết
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </span>
                </div>
            </a>
        </div>
        
        <!-- View All Button -->
        <div class="inspiration-footer">
            <a href="#" class="inspiration-view-all">
                Xem tất cả bài viết
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Instagram Gallery Section -->
<section class="instagram-section">
    <div class="instagram-container">
        <!-- Header -->
        <div class="instagram-header">
            <h2 class="instagram-heading">Fello trên Instagram</h2>
            <p class="instagram-description">Khám phá những bó hoa mới, khoảnh khắc đẹp và cảm hứng từ thế giới hoa của chúng tôi.</p>
            <a href="https://instagram.com/fello" target="_blank" rel="noopener noreferrer" class="instagram-username">@fello</a>
        </div>
        
        <!-- Instagram Gallery Grid -->
        <div class="instagram-gallery">
            <!-- Instagram Item 1 -->
            <a href="https://instagram.com/fello" target="_blank" rel="noopener noreferrer" class="instagram-item">
                <img 
                    src="https://images.unsplash.com/photo-1487070183336-b863922373d4?w=800&q=80" 
                    alt="Bouquet arrangement"
                    class="instagram-item-image"
                    loading="lazy"
                >
                <div class="instagram-item-overlay">
                    <svg class="instagram-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span class="instagram-view-text">Xem trên Instagram</span>
                </div>
            </a>
            
            <!-- Instagram Item 2 -->
            <a href="https://instagram.com/fello" target="_blank" rel="noopener noreferrer" class="instagram-item">
                <img 
                    src="https://images.unsplash.com/photo-1563241527-3004b7be0ffd?w=800&q=80" 
                    alt="Flower arrangement"
                    class="instagram-item-image"
                    loading="lazy"
                >
                <div class="instagram-item-overlay">
                    <svg class="instagram-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span class="instagram-view-text">Xem trên Instagram</span>
                </div>
            </a>
            
            <!-- Instagram Item 3 -->
            <a href="https://instagram.com/fello" target="_blank" rel="noopener noreferrer" class="instagram-item">
                <img 
                    src="https://images.unsplash.com/photo-1550989460-0adf9ea622e2?w=800&q=80" 
                    alt="Florist studio"
                    class="instagram-item-image"
                    loading="lazy"
                >
                <div class="instagram-item-overlay">
                    <svg class="instagram-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span class="instagram-view-text">Xem trên Instagram</span>
                </div>
            </a>
            
            <!-- Instagram Item 4 -->
            <a href="https://instagram.com/fello" target="_blank" rel="noopener noreferrer" class="instagram-item">
                <img 
                    src="https://images.unsplash.com/photo-1606092545919-58b19c4a41e8?w=800&q=80" 
                    alt="Flower close-up"
                    class="instagram-item-image"
                    loading="lazy"
                >
                <div class="instagram-item-overlay">
                    <svg class="instagram-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span class="instagram-view-text">Xem trên Instagram</span>
                </div>
            </a>
            
            <!-- Instagram Item 5 -->
            <a href="https://instagram.com/fello" target="_blank" rel="noopener noreferrer" class="instagram-item">
                <img 
                    src="https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=800&q=80" 
                    alt="Lifestyle flower photo"
                    class="instagram-item-image"
                    loading="lazy"
                >
                <div class="instagram-item-overlay">
                    <svg class="instagram-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span class="instagram-view-text">Xem trên Instagram</span>
                </div>
            </a>
        </div>
        
        <!-- Follow Button -->
        <div class="instagram-footer">
            <a href="https://instagram.com/fello" target="_blank" rel="noopener noreferrer" class="instagram-follow-button">
                Theo dõi Instagram
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Hero Text Slider with Autoplay
(function() {
    const heroSection = document.getElementById('heroSection');
    if (!heroSection) return;

    const slides = heroSection.querySelectorAll('.hero-slide');
    const indicators = heroSection.querySelectorAll('.hero-indicator');
    const counterCurrent = heroSection.querySelector('.hero-counter-current');
    
    let currentSlide = 0;
    let autoplayInterval = null;
    let isPaused = false;
    const slideDuration = 6000; // 6 seconds per slide
    
    // Check for reduced motion preference
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Initialize
    function init() {
        // Set up indicator click handlers
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                goToSlide(index);
                resetAutoplay();
            });
        });

        // Pause on hover
        heroSection.addEventListener('mouseenter', () => {
            isPaused = true;
            pauseProgressAnimation();
        });

        heroSection.addEventListener('mouseleave', () => {
            isPaused = false;
            resumeProgressAnimation();
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                previousSlide();
                resetAutoplay();
            } else if (e.key === 'ArrowRight') {
                nextSlide();
                resetAutoplay();
            }
        });

        // Start autoplay if motion is not reduced
        if (!prefersReducedMotion) {
            startAutoplay();
        }
    }

    // Go to specific slide
    function goToSlide(index) {
        if (index === currentSlide) return;

        // Remove active class from current slide and indicator
        slides[currentSlide].classList.remove('active');
        indicators[currentSlide].classList.remove('active');

        // Update current slide
        currentSlide = index;

        // Add active class to new slide and indicator
        slides[currentSlide].classList.add('active');
        indicators[currentSlide].classList.add('active');

        // Update counter
        updateCounter();
    }

    // Next slide
    function nextSlide() {
        const nextIndex = (currentSlide + 1) % slides.length;
        goToSlide(nextIndex);
    }

    // Previous slide
    function previousSlide() {
        const prevIndex = (currentSlide - 1 + slides.length) % slides.length;
        goToSlide(prevIndex);
    }

    // Update counter display
    function updateCounter() {
        counterCurrent.textContent = String(currentSlide + 1).padStart(2, '0');
    }

    // Start autoplay
    function startAutoplay() {
        if (autoplayInterval) return;
        
        autoplayInterval = setInterval(() => {
            if (!isPaused) {
                nextSlide();
            }
        }, slideDuration);
    }

    // Stop autoplay
    function stopAutoplay() {
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
            autoplayInterval = null;
        }
    }

    // Reset autoplay
    function resetAutoplay() {
        stopAutoplay();
        if (!prefersReducedMotion) {
            startAutoplay();
        }
    }

    // Pause progress animation
    function pauseProgressAnimation() {
        const activeIndicator = indicators[currentSlide];
        if (activeIndicator) {
            activeIndicator.classList.add('paused');
        }
    }

    // Resume progress animation
    function resumeProgressAnimation() {
        const activeIndicator = indicators[currentSlide];
        if (activeIndicator) {
            activeIndicator.classList.remove('paused');
        }
    }

    // Visibility change handler (pause when tab is hidden)
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            isPaused = true;
            pauseProgressAnimation();
        } else {
            isPaused = false;
            resumeProgressAnimation();
        }
    });

    // Initialize on DOM ready
    init();

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        stopAutoplay();
    });
})();

// Products Section - Tab Switching
(function() {
    const tabs = document.querySelectorAll('.products-tab');
    
    if (tabs.length === 0) return;
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Get category
            const category = this.dataset.category;
            
            // In real implementation, you would filter products here
            // For now, we just update the UI
            console.log('Selected category:', category);
        });
    });
})();

// Wishlist Toggle
(function() {
    const wishlistButtons = document.querySelectorAll('.product-wishlist-desktop, .product-wishlist-mobile');
    
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            this.classList.toggle('active');
            
            // In real implementation, you would save to backend here
            const isActive = this.classList.contains('active');
            console.log('Wishlist toggled:', isActive);
        });
    });
})();

// Brand Values - Scroll Animation
(function() {
    const brandValueItems = document.querySelectorAll('.brand-value-item');
    
    if (brandValueItems.length === 0) return;
    
    // Check for reduced motion preference
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    
    if (prefersReducedMotion) {
        // If user prefers reduced motion, show all items immediately
        brandValueItems.forEach(item => {
            item.classList.add('visible');
        });
        return;
    }
    
    // Intersection Observer for scroll animation
    const observerOptions = {
        threshold: 0.2,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);
    
    brandValueItems.forEach(item => {
        observer.observe(item);
    });
})();
</script>
@endpush
