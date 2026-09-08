@extends('layouts.app')

@section('title', 'Tất cả sản phẩm')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/toolbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/grid.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/editorial.css') }}">
@endpush

@section('content')
<!-- Hero Banner -->
<section class="products-hero">
    <img 
        src="{{ asset('images/products/hero-banner.jpg') }}" 
        alt="Tất cả sản phẩm"
        class="products-hero-image"
    >
    <div class="products-hero-overlay"></div>
    <div class="products-hero-content">
        <div class="products-breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span>/</span>
            <span>Tất cả sản phẩm</span>
        </div>
        <h1 class="products-hero-heading">Tất cả sản phẩm</h1>
        <p class="products-hero-description">Khám phá những bó hoa tươi được tuyển chọn mỗi ngày, mang vẻ đẹp tự nhiên và cảm xúc đến mọi khoảnh khắc.</p>
    </div>
</section>

<!-- Toolbar -->
<section class="products-toolbar">
    <div class="products-toolbar-left">
        <button class="products-filter-button" id="filterToggle">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            Bộ lọc
        </button>
        <span class="products-count">{{ $products->total() }} sản phẩm</span>
    </div>
    
    <div class="products-toolbar-right">
        <div class="products-sort-dropdown">
            <button class="products-sort-button" id="sortToggle">
                <span>Sắp xếp: <span id="sortLabel">
                    @php
                        $sortLabels = [
                            'latest'      => 'Mặc định',
                            'newest'      => 'Mới nhất',
                            'bestseller'  => 'Bán chạy nhất',
                            'price-asc'   => 'Giá thấp → cao',
                            'price-desc'  => 'Giá cao → thấp',
                        ];
                        echo $sortLabels[request('sort_by', 'latest')] ?? 'Mặc định';
                    @endphp
                </span></span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="products-sort-menu" id="sortMenu">
                <a class="products-sort-item {{ request('sort_by', 'latest') === 'latest' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'latest', 'page' => null]) }}">Mặc định</a>
                <a class="products-sort-item {{ request('sort_by') === 'newest' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'newest', 'page' => null]) }}">Mới nhất</a>
                <a class="products-sort-item {{ request('sort_by') === 'bestseller' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'bestseller', 'page' => null]) }}">Bán chạy nhất</a>
                <a class="products-sort-item {{ request('sort_by') === 'price-asc' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'price-asc', 'page' => null]) }}">Giá thấp → cao</a>
                <a class="products-sort-item {{ request('sort_by') === 'price-desc' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'price-desc', 'page' => null]) }}">Giá cao → thấp</a>
            </div>
        </div>
    </div>
</section>

<!-- Filter Sidebar -->
<!-- Filter Sidebar — wraps in a real form so Apply submits to controller -->
<form id="filterForm" method="GET" action="{{ route('products.index') }}" style="display:contents">
<div class="products-filter-overlay" id="filterOverlay"></div>
<aside class="products-filter-sidebar" id="filterSidebar">
    <div class="products-filter-header">
        <h3 class="products-filter-title">Bộ lọc</h3>
        <button type="button" class="products-filter-close" id="filterClose">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    
    <div class="products-filter-body">
        <!-- Danh mục từ DB -->
        <div class="products-filter-group">
            <h4 class="products-filter-group-title">Danh mục</h4>
            <div class="products-filter-options">
                @foreach($categories as $cat)
                <label class="products-filter-option">
                    <input type="checkbox"
                           class="products-filter-checkbox"
                           name="categories[]"
                           value="{{ $cat->id }}"
                           {{ in_array($cat->id, (array)($filters['category_ids'] ?? [])) ? 'checked' : '' }}>
                    <span class="products-filter-label">{{ $cat->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Khoảng giá -->
        <div class="products-filter-group">
            <h4 class="products-filter-group-title">Khoảng giá</h4>
            <div class="products-filter-options">
                @php
                    $priceRanges = [
                        'under-500k' => 'Dưới 500.000đ',
                        '500k-1m'    => '500.000đ – 1.000.000đ',
                        '1m-2m'      => '1.000.000đ – 2.000.000đ',
                        'over-2m'    => 'Trên 2.000.000đ',
                    ];
                    $activePriceRange = request('price_range');
                @endphp
                @foreach($priceRanges as $rangeKey => $rangeLabel)
                <label class="products-filter-option">
                    <input type="radio"
                           class="products-filter-checkbox"
                           name="price_range"
                           value="{{ $rangeKey }}"
                           {{ $activePriceRange === $rangeKey ? 'checked' : '' }}>
                    <span class="products-filter-label">{{ $rangeLabel }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Tìm kiếm -->
        <div class="products-filter-group">
            <h4 class="products-filter-group-title">Tìm kiếm</h4>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Tên sản phẩm..."
                   class="products-filter-search-input"
                   style="width:100%;padding:8px 12px;border:1px solid var(--color-border);border-radius:6px;font-size:14px;">
        </div>
    </div>
    
    <div class="products-filter-footer">
        <button type="button" class="products-filter-clear" id="filterClear">Xóa bộ lọc</button>
        <button type="submit" class="products-filter-apply" id="filterApply">Áp dụng</button>
    </div>
</aside>
</form>

<!-- Products Grid -->
<section class="products-grid-section">
    <div class="products-grid-container">
        <div class="products-grid" id="productsGrid">
            @forelse($products as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                <div class="product-card-image-wrapper">
                    <img 
                        src="{{ $product->getPrimaryImageUrl() }}" 
                        alt="{{ $product->name }}"
                        class="product-card-image"
                        loading="lazy"
                    >
                    
                    <button class="product-card-wishlist" aria-label="Thêm vào yêu thích" data-product-id="{{ $product->id }}">
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
            @empty
            <div class="products-empty">
                <p>Không tìm thấy sản phẩm nào.</p>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($products->hasPages())
        <nav class="products-pagination" aria-label="Phân trang sản phẩm">
            {{-- Prev --}}
            @if($products->onFirstPage())
                <span class="products-pagination-item disabled" aria-label="Trang trước">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </span>
            @else
                <a href="{{ $products->previousPageUrl() }}" class="products-pagination-item" aria-label="Trang trước">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach($products->links()->elements[0] ?? [] as $page => $url)
                @if($page == $products->currentPage())
                    <span class="products-pagination-item active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="products-pagination-item">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="products-pagination-item" aria-label="Trang sau">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <span class="products-pagination-item disabled" aria-label="Trang sau">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            @endif
        </nav>
        @endif
    </div>
</section>

<!-- Editorial Section -->
<section class="products-editorial">
    <div class="products-editorial-container">
        <img 
            src="{{ asset('images/detail/detail-1.jpg') }}" 
            alt="Flower Journal"
            class="products-editorial-image"
        >
        
        <div class="products-editorial-content">
            <div class="products-editorial-eyebrow">FLOWER JOURNAL</div>
            <h2 class="products-editorial-heading">Không chỉ là một bó hoa, mà là một câu chuyện.</h2>
            <p class="products-editorial-description">Mỗi bó hoa được {{ $siteSettings['site_name'] ?? 'Lâm Nhiên Thảo' }} tuyển chọn và phối hợp từ những cành hoa tươi đẹp nhất, dành riêng cho những khoảnh khắc đáng nhớ.</p>
            <a href="{{ route('blog.index') }}" class="products-editorial-button">
                Khám phá câu chuyện
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter sidebar toggle
    const filterToggle = document.getElementById('filterToggle');
    const filterSidebar = document.getElementById('filterSidebar');
    const filterOverlay = document.getElementById('filterOverlay');
    const filterClose = document.getElementById('filterClose');
    const filterApply = document.getElementById('filterApply');
    const filterClear = document.getElementById('filterClear');

    function openFilter() {
        filterSidebar.classList.add('active');
        filterOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeFilter() {
        filterSidebar.classList.remove('active');
        filterOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    filterToggle.addEventListener('click', openFilter);
    filterClose.addEventListener('click', closeFilter);
    filterOverlay.addEventListener('click', closeFilter);

    // Clear filters — navigate to clean products page
    filterClear.addEventListener('click', function() {
        window.location.href = '{{ route('products.index') }}';
    });

    // Sort dropdown toggle
    const sortToggle = document.getElementById('sortToggle');
    const sortMenu = document.getElementById('sortMenu');

    sortToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        sortToggle.classList.toggle('active');
        sortMenu.classList.toggle('active');
    });

    document.addEventListener('click', function(e) {
        if (!sortToggle.contains(e.target) && !sortMenu.contains(e.target)) {
            sortToggle.classList.remove('active');
            sortMenu.classList.remove('active');
        }
    });

    // Wishlist toggle
    const wishlistButtons = document.querySelectorAll('.product-card-wishlist');
    wishlistButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.toggle('active');
        });
    });
});
</script>
@endpush
@endsection