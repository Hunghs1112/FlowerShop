@extends('layouts.app')

@section('title', $category->display_name)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/toolbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/grid.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/pagination.css') }}">
@endpush

@section('content')
<!-- Hero Banner -->
<section class="products-hero">
    <img 
        src="{{ $category->image ?? asset('images/categories/category-show-default.jpg') }}" 
        alt="{{ $category->display_name }}"
        class="products-hero-image"
    >
    <div class="products-hero-overlay"></div>
    <div class="products-hero-content">
        <div class="products-breadcrumb">
            <a href="{{ locale_route('home') }}">{{ __('messages.nav.home') }}</a>
            <span>/</span>
            <a href="{{ locale_route('categories.index') }}">{{ __('messages.categories.index_title') ?? 'Danh mục' }}</a>
            @foreach($breadcrumb as $item)
            <span>/</span>
            @if($loop->last)
            <span>{{ $item['name'] }}</span>
            @else
            <a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
            @endif
            @endforeach
        </div>
        <h1 class="products-hero-heading">{{ $category->display_name }}</h1>
        @if($category->display_description)
        <p class="products-hero-description">{{ $category->display_description }}</p>
        @endif
    </div>
</section>

<!-- Subcategories -->
@if($category->children && $category->children->count() > 0)
<section class="subcategories-bar">
    <div class="subcategories-inner">
        <h3 class="subcategories-title">{{ __('messages.categories.subcategories_title') ?? 'Danh mục con' }}</h3>
        <div class="subcategories-list">
            @foreach($category->children as $child)
            <a href="{{ locale_route('categories.show', $child->slug) }}" class="subcategory-link">
                {{ $child->display_name }}
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

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
                <span>{{ __('messages.products.sort') }}: <span id="sortLabel">
                    @switch($filters['sort_by'] ?? 'latest')
                        @case('price_asc') {{ __('messages.products.sort_price_asc') }} @break
                        @case('price_desc') {{ __('messages.products.sort_price_desc') }} @break
                        @case('name') {{ __('messages.products.sort_name_az') ?? 'Tên A-Z' }} @break
                        @default {{ __('messages.products.sort_newest') }}
                    @endswitch
                </span></span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="products-sort-menu" id="sortMenu">
                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'latest']) }}" class="products-sort-item {{ ($filters['sort_by'] ?? 'latest') === 'latest' ? 'active' : '' }}">{{ __('messages.products.sort_newest') }}</a>
                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'price_asc']) }}" class="products-sort-item {{ ($filters['sort_by'] ?? '') === 'price_asc' ? 'active' : '' }}">{{ __('messages.products.sort_price_asc') }}</a>
                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'price_desc']) }}" class="products-sort-item {{ ($filters['sort_by'] ?? '') === 'price_desc' ? 'active' : '' }}">{{ __('messages.products.sort_price_desc') }}</a>
                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'name']) }}" class="products-sort-item {{ ($filters['sort_by'] ?? '') === 'name' ? 'active' : '' }}">{{ __('messages.products.sort_name_az') ?? 'Tên A-Z' }}</a>
            </div>
        </div>
    </div>
</section>

<!-- Filter Sidebar -->
<div class="products-filter-overlay" id="filterOverlay"></div>
<aside class="products-filter-sidebar" id="filterSidebar">
    <div class="products-filter-header">
        <h3 class="products-filter-title">{{ __('messages.products.filter') }}</h3>
        <button class="products-filter-close" id="filterClose">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    
    <form action="{{ locale_route('categories.show', $category->slug) }}" method="GET" id="filterForm">
        <div class="products-filter-body">
            <!-- Khoảng giá -->
            <div class="products-filter-group">
                <h4 class="products-filter-group-title">{{ __('messages.products.filter_price') }}</h4>
                <div class="products-filter-options">
                    <div class="filter-price-group">
                        <input type="number" name="min_price" placeholder="{{ __('messages.products.price_from') ?? 'Từ' }}" value="{{ $filters['min_price'] ?? '' }}"
                               class="filter-price-input">
                        <input type="number" name="max_price" placeholder="{{ __('messages.products.price_to') ?? 'Đến' }}" value="{{ $filters['max_price'] ?? '' }}"
                               class="filter-price-input">
                    </div>
                </div>
            </div>
            
            <!-- Còn hàng -->
            <div class="products-filter-group">
                <label class="products-filter-option">
                    <input type="checkbox" name="in_stock" value="1" {{ ($filters['in_stock'] ?? false) ? 'checked' : '' }} class="products-filter-checkbox">
                    <span class="products-filter-label">{{ __('messages.products.in_stock_only') ?? 'Chỉ hiển thị sản phẩm còn hàng' }}</span>
                </label>
            </div>
        </div>
        
        <div class="products-filter-footer">
            <a href="{{ locale_route('categories.show', $category->slug) }}" class="products-filter-clear">{{ __('messages.products.clear_filters') }}</a>
            <button type="submit" class="products-filter-apply">{{ __('messages.products.apply_filters') }}</button>
        </div>
    </form>
</aside>

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
            {{ $products->links() }}
        </nav>
        @endif
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter sidebar toggle
    const filterToggle = document.getElementById('filterToggle');
    const filterSidebar = document.getElementById('filterSidebar');
    const filterOverlay = document.getElementById('filterOverlay');
    const filterClose = document.getElementById('filterClose');
    
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
