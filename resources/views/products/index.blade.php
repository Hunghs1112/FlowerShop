@extends('layouts.app')

@section('title', content('products_page_title', __('ui.products_title')))

@section('body-class', 'reference-seasonal-page')
@section('content')
<div class="seasonal-catalog">
<!-- Page Hero - Unified Style -->
@if(isset($breadcrumb) && !empty($breadcrumb))
    {{-- Category page with full breadcrumb --}}
    <section class="products-hero {{ $activeCategory?->hide_banner_content ? 'products-hero--image-only' : '' }}">
        <img 
            src="{{ $bannerImage ?? ($siteBanners['categories'] ?? asset('images/banners/danh-muc-hero.jpg')) }}" 
            alt="{{ $activeCategory->display_name ?? __('ui.products_title') }}"
            class="products-hero-image"
        >
        @unless($activeCategory?->hide_banner_content || ($siteBannerHideOverlay['categories'] ?? false))
        <div class="products-hero-overlay"></div>
        @endunless
        <div class="products-hero-content {{ $activeCategory?->hide_banner_content ? 'products-hero-content--hidden' : '' }}" @if($activeCategory?->hide_banner_content) aria-hidden="true" @endif>
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
            <h1 class="products-hero-heading">{{ $activeCategory->display_name ?? __('ui.products_title') }}</h1>
            @if(isset($activeCategory) && $activeCategory->display_description)
            <p class="products-hero-description">{{ $activeCategory->display_description }}</p>
            @endif
        </div>
    </section>

    {{-- Subcategories bar for category pages --}}
    @if(isset($category) && $category->children && $category->children->count() > 0)
    <section class="subcategories-bar">
        <div class="subcategories-inner">
            <h3 class="subcategories-title">{{ __('ui.subcategories_title') }}</h3>
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
@else
    {{-- Products index page with simple hero --}}
    <x-page-hero
        :title="$activeCategory ? $activeCategory->display_name : __('ui.products_title')"
        :description="$activeCategory && $activeCategory->display_description ? $activeCategory->display_description : __('ui.products_description')"
        :breadcrumbs="[
            ['label' => content('breadcrumb_home', __('ui.home')), 'url' => localized_route('home')],
            ['label' => $activeCategory ? $activeCategory->display_name : content('breadcrumb_all_products', __('ui.all_products_label'))]
        ]"
        :image="$bannerImage ?? ($siteBanners['products'] ?? null)"
        :hideOverlay="$siteBannerHideOverlay['products'] ?? false"
        :hide-content="$activeCategory?->hide_banner_content ?? false"
        variant="products"
    />
@endif

<!-- Active Filter Chips -->
@if(!empty($activeFilterChips))
<section class="filter-chips-section">
    <div class="filter-chips-container">
        <div class="filter-chips">
            <span class="filter-chips-label">{{ content('filter_chips_label', __('ui.filter_currently')) }}</span>
            @foreach($activeFilterChips as $chip)
                @php
                    // Build removal URL by removing only the specific filter parameter
                    $removeParams = request()->query();
                    
                    // Determine the clear URL based on context
                    $clearRoute = isset($category) ? localized_route('categories.show', $category->display_slug) : localized_route('products.index');
                    
                    if ($chip['type'] === 'category') {
                        // Handle both array and string formats
                        $currentCategories = $removeParams['categories'] ?? [];
                        if (is_string($currentCategories)) {
                            $currentCategories = explode(',', $currentCategories);
                        }
                        
                        $catIds = array_filter($currentCategories, function($id) use ($chip) {
                            return $id != $chip['value'];
                        });
                        
                        if (!empty($catIds)) {
                            $removeParams['categories'] = $catIds;
                        } else {
                            unset($removeParams['categories']);
                        }
                    } elseif ($chip['type'] === 'subcategory') {
                        // Handle subcategory removal
                        $currentSubcategories = $removeParams['subcategories'] ?? [];
                        if (is_string($currentSubcategories)) {
                            $currentSubcategories = explode(',', $currentSubcategories);
                        }
                        
                        $subIds = array_filter($currentSubcategories, function($id) use ($chip) {
                            return $id != $chip['value'];
                        });
                        
                        if (!empty($subIds)) {
                            $removeParams['subcategories'] = $subIds;
                        } else {
                            unset($removeParams['subcategories']);
                        }
                    } else {
                        unset($removeParams[$chip['param']]);
                    }
                    // Always remove page when changing filters
                    unset($removeParams['page']);
                    
                    // Build the remove URL based on context
                    $removeUrl = isset($category) 
                        ? localized_route('categories.show', array_merge(['category' => $category->display_slug], $removeParams))
                        : localized_route('products.index', $removeParams);
                @endphp
                <a href="{{ $removeUrl }}" 
                   class="filter-chip" 
                   data-type="{{ $chip['type'] }}">
                    <span class="filter-chip-text">{!! $chip['label'] !!}</span>
                    <svg class="filter-chip-remove" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            @endforeach
            <a href="{{ $clearRoute }}" class="filter-chip filter-chip-clear">
                <span class="filter-chip-text">{{ content('filter_clear_all', __('ui.filter_clear_all')) }}</span>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Toolbar -->
<section class="products-toolbar">
    <div class="products-toolbar-left">
        <button class="products-filter-button" id="filterToggle" aria-label="{{ content('filter_open_label', __('ui.filter_open')) }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            {{ content('filter_button', __('ui.filter_button')) }}
            @if(count($activeFilterChips ?? []) > 0)
                <span class="filter-badge">{{ count($activeFilterChips) }}</span>
            @endif
        </button>
        <span class="products-count">
            {{ content('products_showing', __('ui.products_showing')) }} {{ $products->count() }} / {{ $products->total() }} {{ content('products_suffix', __('ui.products_suffix')) }}
        </span>
    </div>
    
    <div class="products-toolbar-right">
        <div class="products-sort-dropdown">
            <button class="products-sort-button" id="sortToggle" aria-expanded="false" aria-haspopup="true">
                <span>{{ __('ui.sort_label') }} <span id="sortLabel">
                    @php
                        $sortLabels = [
                            'latest'      => __('ui.sort_default'),
                            'newest'      => __('ui.sort_newest'),
                            'bestseller'  => __('ui.sort_bestseller'),
                            'price-asc'   => __('ui.sort_price_asc'),
                            'price-desc'  => __('ui.sort_price_desc'),
                        ];
                        echo $sortLabels[request('sort_by', 'latest')] ?? __('ui.sort_default');
                    @endphp
                </span></span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="products-sort-menu" id="sortMenu" role="menu">
                <a class="products-sort-item {{ request('sort_by', 'latest') === 'latest' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'latest', 'page' => null]) }}" role="menuitem">
                    {{ __('ui.sort_default') }}
                </a>
                <a class="products-sort-item {{ request('sort_by') === 'newest' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'newest', 'page' => null]) }}" role="menuitem">
                    {{ __('ui.sort_newest') }}
                </a>
                <a class="products-sort-item {{ request('sort_by') === 'bestseller' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'bestseller', 'page' => null]) }}" role="menuitem">
                    {{ __('ui.sort_bestseller') }}
                </a>
                <a class="products-sort-item {{ request('sort_by') === 'price-asc' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'price-asc', 'page' => null]) }}" role="menuitem">
                    {{ __('ui.sort_price_asc') }}
                </a>
                <a class="products-sort-item {{ request('sort_by') === 'price-desc' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'price-desc', 'page' => null]) }}" role="menuitem">
                    {{ __('ui.sort_price_desc') }}
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Filter Sidebar -->
@php
    $filterAction = isset($category) ? localized_route('categories.show', $category->display_slug) : localized_route('products.index');
    $clearUrl = isset($category) ? localized_route('categories.show', $category->display_slug) : localized_route('products.index');
@endphp
<form id="filterForm" method="GET" action="{{ $filterAction }}" class="products-filter-form">
    <input type="hidden" name="sort_by" value="{{ request('sort_by', 'latest') }}">
    <div class="products-filter-overlay" id="filterOverlay"></div>
    <aside class="products-filter-sidebar" id="filterSidebar" aria-label="{{ __('ui.filter_sidebar_aria') }}">
        <div class="products-filter-header">
            <h3 class="products-filter-title">{{ __('ui.filter_label') }}</h3>
            <button type="button" class="products-filter-close" id="filterClose" aria-label="{{ __('ui.filter_close') }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <div class="products-filter-body">
            <!-- Search in Filter -->
            <div class="products-filter-group">
                <h4 class="products-filter-group-title">{{ __('ui.search') }}</h4>
                <div class="filter-search-wrapper">
                    <input type="text"
                           name="q"
                           value="{{ request('q') ?: request('search') }}"
                           placeholder="{{ __('ui.filter_search_placeholder') }}"
                           class="products-filter-search-input"
                           aria-label="{{ __('ui.filter_search_aria') }}">
                    @if(request('q') || request('search'))
                        <a href="{{ request()->fullUrlWithQuery(array_diff_key(request()->query(), ['q' => '', 'search' => ''])) }}" 
                           class="filter-search-clear" aria-label="{{ __('ui.filter_search_clear_aria') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            <div class="products-filter-group">
                <h4 class="products-filter-group-title">{{ __('ui.filter_group_categories') }}</h4>
                <div class="products-filter-options">
                    @foreach($categories as $cat)
                        @php
                            // Check if this category is selected
                            $isChecked = false;
                            if (isset($category) && $category->id == $cat->id) {
                                $isChecked = true;
                            } elseif (isset($filters['category_ids']) && in_array($cat->id, (array)$filters['category_ids'])) {
                                $isChecked = true;
                            }
                        @endphp
                        <label class="products-filter-option">
                            <input type="checkbox"
                                   class="products-filter-checkbox"
                                   name="categories[]"
                                   value="{{ $cat->id }}"
                                   {{ $isChecked ? 'checked' : '' }}>
                            <span class="products-filter-label">{{ $cat->name }}</span>
                            <span class="products-filter-count">({{ $cat->products_count ?? '' }})</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Subcategories -->
            <div class="products-filter-group">
                <h4 class="products-filter-group-title">{{ __('ui.filter_group_subcategories') }}</h4>
                <div class="products-filter-options">
                    @foreach($subcategories ?? [] as $subcat)
                        <label class="products-filter-option">
                            <input type="checkbox"
                                   class="products-filter-checkbox"
                                   name="subcategories[]"
                                   value="{{ $subcat->id }}"
                                   {{ in_array($subcat->id, (array)($filters['subcategory_ids'] ?? [])) ? 'checked' : '' }}>
                            <span class="products-filter-label">
                                <small style="color: var(--color-text-muted); font-size: 0.85em;">{{ $subcat->category->name }} →</small>
                                {{ $subcat->name }}
                            </span>
                            <span class="products-filter-count">({{ $subcat->products_count ?? 0 }})</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Price range -->
            <div class="products-filter-group">
                <h4 class="products-filter-group-title">{{ __('ui.filter_group_price') }}</h4>
                <div class="products-filter-options">
                    @php
                        $priceRanges = [
                            'under-500k' => __('ui.filter_price_under_500k'),
                            '500k-1m'    => __('ui.filter_price_500k_1m'),
                            '1m-2m'      => __('ui.filter_price_1m_2m'),
                            'over-2m'    => __('ui.filter_price_over_2m'),
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
                
                <!-- Custom price range -->
                <div class="filter-custom-price">
                    <div class="filter-price-divider">
                        <span>{{ __('ui.filter_price_or') }}</span>
                    </div>
                    <div class="filter-price-inputs">
                        <input type="number"
                               name="min_price"
                               value="{{ request('min_price') }}"
                               placeholder="{{ __('ui.filter_price_from_placeholder') }}"
                               min="0"
                               class="filter-price-input"
                               aria-label="{{ __('ui.filter_price_from_aria') }}">
                        <span class="filter-price-separator">-</span>
                        <input type="number"
                               name="max_price"
                               value="{{ request('max_price') }}"
                               placeholder="{{ __('ui.filter_price_to_placeholder') }}"
                               min="0"
                               class="filter-price-input"
                               aria-label="{{ __('ui.filter_price_to_aria') }}">
                    </div>
                </div>
            </div>

            <!-- Availability -->
            <div class="products-filter-group">
                <h4 class="products-filter-group-title">{{ __('ui.filter_group_status') }}</h4>
                <div class="products-filter-options">
                    <label class="products-filter-option">
                        <input type="checkbox"
                               class="products-filter-checkbox"
                               name="in_stock"
                               value="1"
                               {{ request('in_stock') ? 'checked' : '' }}>
                        <span class="products-filter-label">{{ __('ui.filter_in_stock_only') }}</span>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="products-filter-footer">
            <a href="{{ $clearUrl }}" class="products-filter-clear" id="filterClear">
                {{ __('ui.filter_reset') }}
            </a>
            <button type="submit" class="products-filter-apply">
                {{ __('ui.filter_apply') }}
            </button>
        </div>
    </aside>
</form>

<!-- Products Grid -->
<section class="products-grid-section">
    <div class="products-grid-container">
        @if($products->isEmpty())
            <!-- Empty State -->
            <div class="products-empty-state">
                <div class="products-empty-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="products-empty-title">
                    @if(request('q') || request('search'))
                        {{ __('ui.products_empty_search') }}
                    @else
                        {{ __('ui.products_empty_none') }}
                    @endif
                </h3>
                <p class="products-empty-description">
                    @if(request('q') || request('search'))
                        {{ __('ui.products_empty_query', ['query' => request('q') ?: request('search')]) }}
                    @elseif(count($activeFilterChips ?? []) > 0)
                        {{ __('ui.products_empty_filter') }}
                    @else
                        {{ __('ui.products_empty_default') }}
                    @endif
                </p>
                
                <!-- Suggestions -->
                <div class="products-empty-suggestions">
                    <h4 class="products-empty-suggestions-title">{{ __('ui.products_empty_suggestions_title') }}</h4>
                    <ul class="products-empty-suggestions-list">
                        <li>{{ __('ui.products_empty_tip_1') }}</li>
                        <li>{{ __('ui.products_empty_tip_2') }}</li>
                        <li>{{ __('ui.products_empty_tip_3') }}</li>
                    </ul>
                </div>
                
                @if(request('q') || request('search') || count($activeFilterChips ?? []) > 0)
                    <a href="{{ localized_route('products.index') }}" class="products-empty-action btn btn-primary">
                        {{ __('ui.products_view_all') }}
                    </a>
                @endif
            </div>
        @else
            <div class="products-grid" id="productsGrid">
                @foreach($products as $product)
                    <x-product-card :product="$product" :route-label="(strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', (string) $product->sku), 0, 3)) ?: 'LNT') . ' → HAN'" />
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
                <nav class="products-pagination" role="navigation" aria-label="Pagination">
                    {{-- Previous Page Link --}}
                    @if ($products->onFirstPage())
                        <span class="pagination-item disabled" aria-disabled="true" aria-label="{{ __('ui.pagination_prev') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="pagination-item" rel="prev" aria-label="{{ __('ui.pagination_prev') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($products->links()->elements[0] ?? [] as $page => $url)
                        @if ($page == $products->currentPage())
                            <span class="pagination-item active" aria-current="page">{{ $page }}</span>
                        @elseif ($url)
                            <a href="{{ $url }}" class="pagination-item">{{ $page }}</a>
                        @else
                            <span class="pagination-dots">...</span>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="pagination-item" rel="next" aria-label="{{ __('ui.pagination_next') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @else
                        <span class="pagination-item disabled" aria-disabled="true" aria-label="{{ __('ui.pagination_next') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    @endif
                </nav>
                
                <div class="pagination-info">
                    {{ __('ui.pagination_info', ['current' => $products->currentPage(), 'last' => $products->lastPage(), 'total' => $products->total()]) }}
                </div>
            @endif
            </div>
        @endif
    </div>
</section>

<!-- Suggestion Collections (gợi ý theo bộ sưu tập / màu) -->
@if(isset($suggestionCollections) && $suggestionCollections->isNotEmpty())
<section class="products-suggestions products-grid-section">
    <div class="products-suggestions-container products-grid-container">
        <h2 class="products-suggestions-heading">{{ __('ui.products_suggestion_heading') }}</h2>
        @foreach($suggestionCollections as $collection)
        <div class="suggestion-block" style="--accent: {{ $collection->accent_color }};">
            <header class="suggestion-block-header">
                <div>
                    <h3 class="suggestion-block-title">{{ $collection->display_name }}</h3>
                    @if($collection->display_criterion)
                        <p class="suggestion-block-criterion">{{ $collection->display_criterion }}</p>
                    @endif
                </div>
                <a href="{{ localized_route('products.index', ['collection' => $collection->display_slug]) }}" class="suggestion-block-link">{{ __('ui.products_suggestion_view_all') }}</a>
            </header>
            <div class="suggestion-block-grid products-grid">
                @foreach($collection->products as $product)
                    <x-product-card :product="$product" :route-label="(strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', (string) $product->sku), 0, 3)) ?: 'LNT') . ' → HAN'" />
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- Editorial Section -->
<section class="products-editorial">
    <div class="products-editorial-container">
        <img
            src="{{ $productsEditorialImage ?? asset('images/editorial/detail-1.jpg') }}"
            alt="Flower Journal"
            class="products-editorial-image"
        >
        
        <div class="products-editorial-content">
            <div class="products-editorial-eyebrow">{{ __('ui.products_editorial_eyebrow') }}</div>
            <h2 class="products-editorial-heading">{{ __('ui.products_editorial_heading') }}</h2>
            <p class="products-editorial-description">{{ __('ui.products_editorial_description') }}</p>
            <a href="{{ localized_route('blog.index') }}" class="products-editorial-button">
                {{ __('ui.products_editorial_read') }}
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter sidebar toggle
    const filterToggle = document.getElementById('filterToggle');
    const filterSidebar = document.getElementById('filterSidebar');
    const filterOverlay = document.getElementById('filterOverlay');
    const filterClose = document.getElementById('filterClose');
    const filterForm = document.getElementById('filterForm');
    
    function openFilter() {
        filterSidebar.classList.add('active');
        filterOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        filterToggle.setAttribute('aria-expanded', 'true');
    }

    function closeFilter() {
        filterSidebar.classList.remove('active');
        filterOverlay.classList.remove('active');
        document.body.style.overflow = '';
        filterToggle.setAttribute('aria-expanded', 'false');
    }

    if (filterToggle) filterToggle.addEventListener('click', openFilter);
    if (filterClose) filterClose.addEventListener('click', closeFilter);
    if (filterOverlay) filterOverlay.addEventListener('click', closeFilter);
    
    // Close on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && filterSidebar.classList.contains('active')) {
            closeFilter();
        }
    });

    // Sort dropdown toggle
    const sortToggle = document.getElementById('sortToggle');
    const sortMenu = document.getElementById('sortMenu');

    if (sortToggle && sortMenu) {
        sortToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = sortMenu.classList.toggle('active');
            sortToggle.setAttribute('aria-expanded', isOpen);
        });

        document.addEventListener('click', function(e) {
            if (!sortToggle.contains(e.target) && !sortMenu.contains(e.target)) {
                sortMenu.classList.remove('active');
                sortToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // Price range validation
    const minPriceInput = document.querySelector('input[name="min_price"]');
    const maxPriceInput = document.querySelector('input[name="max_price"]');
    
    function validatePriceInputs() {
        const minVal = parseFloat(minPriceInput?.value) || 0;
        const maxVal = parseFloat(maxPriceInput?.value) || Infinity;
        
        if (minPriceInput && maxPriceInput && minVal > maxVal && maxVal > 0) {
            // Swap values if min > max
            const temp = minPriceInput.value;
            minPriceInput.value = maxPriceInput.value;
            maxPriceInput.value = temp;
        }
    }
    
    if (minPriceInput) minPriceInput.addEventListener('change', validatePriceInputs);
    if (maxPriceInput) maxPriceInput.addEventListener('change', validatePriceInputs);
    
    // Handle checkbox changes - auto-submit for better UX
    const filterCheckboxes = document.querySelectorAll('.products-filter-checkbox[name="categories[]"]');
    filterCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // Could auto-submit here, but keeping manual apply for now
        });
    });

    // Prevent negative values in price inputs
    document.querySelectorAll('input[type="number"][min="0"]').forEach(input => {
        input.addEventListener('input', function() {
            if (this.value < 0) this.value = 0;
        });
    });

});
</script>
@endpush
