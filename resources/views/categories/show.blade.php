@extends('layouts.app')

@section('title', $category->display_name)

@section('content')
<!-- Hero Banner -->
<section class="products-hero {{ $category->hide_banner_content ? 'products-hero--image-only' : '' }}">
    <img 
        src="{{ $category->banner_image ? $category->banner_image_url : ($category->image ? $category->image_url : ($siteBanners['categories'] ?? asset('images/banners/danh-muc-hero.jpg'))) }}" 
        alt="{{ $category->display_name }}"
        class="products-hero-image"
    >
    @unless($category->hide_banner_content || ($siteBannerHideOverlay['categories'] ?? false))
    <div class="products-hero-overlay"></div>
    <div class="products-hero-content">
        <div class="products-breadcrumb">
            <a href="{{ localized_route('home') }}">{{ __('ui.home') }}</a>
            <span>/</span>
            <a href="{{ localized_route('categories.index') }}">{{ __('ui.categories_label') }}</a>
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
    @endunless
</section>

<!-- Subcategories -->
@if($category->children && $category->children->count() > 0)
<section class="subcategories-bar">
    <div class="subcategories-inner">
        <h3 class="subcategories-title">{{ __('storefront.subcategories') }}</h3>
        <div class="subcategories-list">
            @foreach($category->children as $child)
            <a href="{{ localized_route('categories.show', $child->display_slug) }}" class="subcategory-link">
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
            {{ __('storefront.filter') }}
        </button>
        <span class="products-count">
            {{ __('ui.products_showing') }} {{ $products->count() }} / {{ $products->total() }} {{ __('ui.products_suffix') }}
        </span>
    </div>
    
    <div class="products-toolbar-right">
        <div class="products-sort-dropdown">
            <button class="products-sort-button" id="sortToggle">
                <span>{{ __('storefront.sort') }} <span id="sortLabel">
                    @switch($filters['sort_by'] ?? 'latest')
                        @case('price_asc') {{ __('storefront.price_low_high') }} @break
                        @case('price_desc') {{ __('storefront.price_high_low') }} @break
                        @case('name') {{ __('storefront.name_az') }} @break
                        @default {{ __('storefront.newest') }}
                    @endswitch
                </span></span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="products-sort-menu" id="sortMenu">
                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'latest']) }}" class="products-sort-item {{ ($filters['sort_by'] ?? 'latest') === 'latest' ? 'active' : '' }}">{{ __('storefront.newest') }}</a>
                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'price_asc']) }}" class="products-sort-item {{ ($filters['sort_by'] ?? '') === 'price_asc' ? 'active' : '' }}">{{ __('storefront.price_low_high') }}</a>
                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'price_desc']) }}" class="products-sort-item {{ ($filters['sort_by'] ?? '') === 'price_desc' ? 'active' : '' }}">{{ __('storefront.price_high_low') }}</a>
                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'name']) }}" class="products-sort-item {{ ($filters['sort_by'] ?? '') === 'name' ? 'active' : '' }}">{{ __('storefront.name_az') }}</a>
            </div>
        </div>
    </div>
</section>

<!-- Filter Sidebar -->
<div class="products-filter-overlay" id="filterOverlay"></div>
<aside class="products-filter-sidebar" id="filterSidebar">
    <div class="products-filter-header">
        <h3 class="products-filter-title">{{ __('storefront.filter') }}</h3>
        <button class="products-filter-close" id="filterClose">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    
    <form action="{{ localized_route('categories.show', $category->display_slug) }}" method="GET" id="filterForm">
        <div class="products-filter-body">
            <!-- Khoảng giá -->
            <div class="products-filter-group">
                <h4 class="products-filter-group-title">{{ __('storefront.price_range') }}</h4>
                <div class="products-filter-options">
                    <div class="filter-price-group">
                        <input type="number" name="min_price" placeholder="{{ __('storefront.from') }}" value="{{ $filters['min_price'] ?? '' }}"
                               class="filter-price-input">
                        <input type="number" name="max_price" placeholder="{{ __('storefront.to') }}" value="{{ $filters['max_price'] ?? '' }}"
                               class="filter-price-input">
                    </div>
                </div>
            </div>
            
            <!-- Availability -->
            <div class="products-filter-group">
                <label class="products-filter-option">
                    <input type="checkbox" name="in_stock" value="1" {{ ($filters['in_stock'] ?? false) ? 'checked' : '' }} class="products-filter-checkbox">
                    <span class="products-filter-label">{{ __('storefront.in_stock') }}</span>
                </label>
            </div>
        </div>
        
        <div class="products-filter-footer">
            <a href="{{ localized_route('categories.show', $category->display_slug) }}" class="products-filter-clear">{{ __('storefront.reset') }}</a>
            <button type="submit" class="products-filter-apply">{{ __('storefront.apply') }}</button>
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
                <p>{{ __('storefront.no_products') }}</p>
            </div>
            @endforelse
        </div>
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
