@extends('layouts.app')

@section('title', __('messages.products.page_title'))

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
        alt="{{ __('messages.products.page_title') }}"
        class="products-hero-image"
    >
    <div class="products-hero-overlay"></div>
    <div class="products-hero-content">
        <div class="products-breadcrumb">
            <a href="{{ locale_route('home') }}">{{ __('messages.products.breadcrumb_home') }}</a>
            <span>/</span>
            <span>{{ __('messages.products.breadcrumb_all') }}</span>
        </div>
        <h1 class="products-hero-heading">{{ __('messages.products.page_title') }}</h1>
        <p class="products-hero-description">{{ __('messages.products.page_subtitle') }}</p>
    </div>
</section>

<!-- Toolbar -->
<section class="products-toolbar">
    <div class="products-toolbar-left">
        <button class="products-filter-button" id="filterToggle">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            {{ __('messages.products.filter') }}
        </button>
        <span class="products-count">{!! str_replace(':count', $products->total(), __('messages.products.products_count')) !!}</span>
    </div>
    
    <div class="products-toolbar-right">
        <div class="products-sort-dropdown">
            <button class="products-sort-button" id="sortToggle">
                <span>Sắp xếp: <span id="sortLabel">
                    @php
                        $sortLabels = [
                            'latest'      => __('messages.products.sort_default'),
                            'newest'      => __('messages.products.sort_newest'),
                            'bestseller'  => __('messages.products.sort_bestseller'),
                            'price-asc'   => __('messages.products.sort_price_asc'),
                            'price-desc'  => __('messages.products.sort_price_desc'),
                        ];
                        echo $sortLabels[request('sort_by', 'latest')] ?? __('messages.products.sort_default');
                    @endphp
                </span></span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="products-sort-menu" id="sortMenu">
                <a class="products-sort-item {{ request('sort_by', 'latest') === 'latest' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'latest', 'page' => null]) }}">{{ __('messages.products.sort_default') }}</a>
                <a class="products-sort-item {{ request('sort_by') === 'newest' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'newest', 'page' => null]) }}">{{ __('messages.products.sort_newest') }}</a>
                <a class="products-sort-item {{ request('sort_by') === 'bestseller' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'bestseller', 'page' => null]) }}">{{ __('messages.products.sort_bestseller') }}</a>
                <a class="products-sort-item {{ request('sort_by') === 'price-asc' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'price-asc', 'page' => null]) }}">{{ __('messages.products.sort_price_asc') }}</a>
                <a class="products-sort-item {{ request('sort_by') === 'price-desc' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'price-desc', 'page' => null]) }}">{{ __('messages.products.sort_price_desc') }}</a>
            </div>
        </div>
    </div>
</section>

<!-- Filter Sidebar -->
<!-- Filter Sidebar — wraps in a real form so Apply submits to controller -->
<form id="filterForm" method="GET" action="{{ locale_route('products.index') }}" style="display:contents">
<div class="products-filter-overlay" id="filterOverlay"></div>
<aside class="products-filter-sidebar" id="filterSidebar">
    <div class="products-filter-header">
            <h3 class="products-filter-title">{{ __('messages.products.filter') }}</h3>
        <button type="button" class="products-filter-close" id="filterClose">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    
    <div class="products-filter-body">
        <!-- Danh mục từ DB -->
                <div class="products-filter-group">
            <h4 class="products-filter-group-title">{{ __('messages.products.filter_category') }}</h4>
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
            <h4 class="products-filter-group-title">{{ __('messages.products.filter_price') }}</h4>
            <div class="products-filter-options">
                @php
                    $priceRanges = [
                        'under-500k' => __('messages.products.price_under_500k'),
                        '500k-1m'    => __('messages.products.price_500k_1m'),
                        '1m-2m'      => __('messages.products.price_1m_2m'),
                        'over-2m'    => __('messages.products.price_over_2m'),
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
            <h4 class="products-filter-group-title">{{ __('messages.products.filter_search') }}</h4>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="{{ __('messages.products.filter_search_placeholder') }}"
                   class="products-filter-search-input">
        </div>
    </div>
    
    <div class="products-filter-footer">
        <button type="button" class="products-filter-clear" id="filterClear">{{ __('messages.products.clear_filters') }}</button>
        <button type="submit" class="products-filter-apply" id="filterApply">{{ __('messages.products.apply_filters') }}</button>
    </div>
</aside>
</form>

<!-- Products Grid -->
<section class="products-grid-section">
    <div class="products-grid-container">
        <div class="products-grid" id="productsGrid">
            @forelse($products as $product)
            <x-product-card :product="$product" />
            @empty
            <div class="products-empty">
                <p>{{ __('messages.products.no_products') }}</p>
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
            <h2 class="products-editorial-heading">{{ __('messages.products.editorial_title') }}</h2>
            <p class="products-editorial-description">{{ __('messages.products.editorial_desc') }}</p>
            <a href="{{ locale_route('blog.index') }}" class="products-editorial-button">
                {{ __('messages.products.editorial_cta') }}
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
        window.location.href = '{{ locale_route('products.index') }}';
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
});
</script>
@endpush
@endsection