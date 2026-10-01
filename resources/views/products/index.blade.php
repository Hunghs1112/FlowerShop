@extends('layouts.app')

@section('title', content('products_page_title', 'Sản phẩm'))

@section('content')
<!-- Page Hero - Unified Style -->
@if(isset($breadcrumb) && !empty($breadcrumb))
    {{-- Category page with full breadcrumb --}}
    <section class="products-hero">
        <img 
            src="{{ $bannerImage ?? ($siteBanners['categories'] ?? asset('images/banners/danh-muc-hero.jpg')) }}" 
            alt="{{ $activeCategory->display_name ?? 'Sản phẩm' }}"
            class="products-hero-image"
        >
        @unless($activeCategory?->hide_banner_content)
        <div class="products-hero-overlay"></div>
        @endunless
        <div class="products-hero-content {{ $activeCategory?->hide_banner_content ? 'products-hero-content--hidden' : '' }}" @if($activeCategory?->hide_banner_content) aria-hidden="true" @endif>
            <div class="products-breadcrumb">
                <a href="{{ route('home') }}">Trang chủ</a>
                <span>/</span>
                <a href="{{ route('categories.index') }}">Danh mục</a>
                @foreach($breadcrumb as $item)
                <span>/</span>
                @if($loop->last)
                <span>{{ $item['name'] }}</span>
                @else
                <a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                @endif
                @endforeach
            </div>
            <h1 class="products-hero-heading">{{ $activeCategory->display_name ?? 'Sản phẩm' }}</h1>
            @if(isset($activeCategory) && $activeCategory->display_description)
            <p class="products-hero-description">{{ $activeCategory->display_description }}</p>
            @endif
        </div>
    </section>

    {{-- Subcategories bar for category pages --}}
    @if(isset($category) && $category->children && $category->children->count() > 0)
    <section class="subcategories-bar">
        <div class="subcategories-inner">
            <h3 class="subcategories-title">Danh mục con</h3>
            <div class="subcategories-list">
                @foreach($category->children as $child)
                <a href="{{ route('categories.show', $child->slug) }}" class="subcategory-link">
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
        :title="$activeCategory ? $activeCategory->display_name : 'Sản phẩm'"
        :description="$activeCategory && $activeCategory->description ? $activeCategory->description : 'Khám phá bộ sưu tập hoa tươi cao cấp của chúng tôi'"
        :breadcrumbs="[
            ['label' => content('breadcrumb_home', 'Trang chủ'), 'url' => route('home')],
            ['label' => $activeCategory ? $activeCategory->display_name : content('breadcrumb_all_products', 'Tất cả sản phẩm')]
        ]"
        :image="$bannerImage ?? null"
        :hide-content="$activeCategory?->hide_banner_content ?? false"
    />
@endif

<!-- Active Filter Chips -->
@if(!empty($activeFilterChips))
<section class="filter-chips-section">
    <div class="filter-chips-container">
        <div class="filter-chips">
            <span class="filter-chips-label">{{ content('filter_chips_label', 'Đang lọc:') }}</span>
            @foreach($activeFilterChips as $chip)
                @php
                    // Build removal URL by removing only the specific filter parameter
                    $removeParams = request()->query();
                    
                    // Determine the clear URL based on context
                    $clearRoute = isset($category) ? route('categories.show', $category->slug) : route('products.index');
                    
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
                        ? route('categories.show', array_merge(['category' => $category->slug], $removeParams))
                        : route('products.index', $removeParams);
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
                <span class="filter-chip-text">{{ content('filter_clear_all', 'Xóa tất cả') }}</span>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Toolbar -->
<section class="products-toolbar">
    <div class="products-toolbar-left">
        <button class="products-filter-button" id="filterToggle" aria-label="{{ content('filter_open_label', 'Mở bộ lọc') }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            {{ content('filter_button', 'Lọc') }}
            @if(count($activeFilterChips ?? []) > 0)
                <span class="filter-badge">{{ count($activeFilterChips) }}</span>
            @endif
        </button>
        <span class="products-count">
            {{ content('products_showing', 'Hiển thị') }} {{ $products->count() }} / {{ $products->total() }} {{ content('products_suffix', 'sản phẩm') }}
        </span>
    </div>
    
    <div class="products-toolbar-right">
        <div class="products-sort-dropdown">
            <button class="products-sort-button" id="sortToggle" aria-expanded="false" aria-haspopup="true">
                <span>Sắp xếp: <span id="sortLabel">
                    @php
                        $sortLabels = [
                            'latest'      => 'Mặc định',
                            'newest'      => 'Mới nhất',
                            'bestseller'  => 'Bán chạy',
                            'price-asc'   => 'Giá: Thấp đến cao',
                            'price-desc'  => 'Giá: Cao đến thấp',
                        ];
                        echo $sortLabels[request('sort_by', 'latest')] ?? 'Mặc định';
                    @endphp
                </span></span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="products-sort-menu" id="sortMenu" role="menu">
                <a class="products-sort-item {{ request('sort_by', 'latest') === 'latest' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'latest', 'page' => null]) }}" role="menuitem">
                    Mặc định
                </a>
                <a class="products-sort-item {{ request('sort_by') === 'newest' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'newest', 'page' => null]) }}" role="menuitem">
                    Mới nhất
                </a>
                <a class="products-sort-item {{ request('sort_by') === 'bestseller' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'bestseller', 'page' => null]) }}" role="menuitem">
                    Bán chạy
                </a>
                <a class="products-sort-item {{ request('sort_by') === 'price-asc' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'price-asc', 'page' => null]) }}" role="menuitem">
                    Giá: Thấp đến cao
                </a>
                <a class="products-sort-item {{ request('sort_by') === 'price-desc' ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'price-desc', 'page' => null]) }}" role="menuitem">
                    Giá: Cao đến thấp
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Filter Sidebar -->
@php
    $filterAction = isset($category) ? route('categories.show', $category->slug) : route('products.index');
    $clearUrl = isset($category) ? route('categories.show', $category->slug) : route('products.index');
@endphp
<form id="filterForm" method="GET" action="{{ $filterAction }}" class="products-filter-form">
    <input type="hidden" name="sort_by" value="{{ request('sort_by', 'latest') }}">
    <div class="products-filter-overlay" id="filterOverlay"></div>
    <aside class="products-filter-sidebar" id="filterSidebar" aria-label="Bộ lọc sản phẩm">
        <div class="products-filter-header">
            <h3 class="products-filter-title">Bộ lọc</h3>
            <button type="button" class="products-filter-close" id="filterClose" aria-label="Đóng bộ lọc">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <div class="products-filter-body">
            <!-- Search in Filter -->
            <div class="products-filter-group">
                <h4 class="products-filter-group-title">Tìm kiếm</h4>
                <div class="filter-search-wrapper">
                    <input type="text"
                           name="q"
                           value="{{ request('q') ?: request('search') }}"
                           placeholder="Nhập tên sản phẩm..."
                           class="products-filter-search-input"
                           aria-label="Tìm kiếm sản phẩm">
                    @if(request('q') || request('search'))
                        <a href="{{ request()->fullUrlWithQuery(array_diff_key(request()->query(), ['q' => '', 'search' => ''])) }}" 
                           class="filter-search-clear" aria-label="Xóa tìm kiếm">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Danh mục từ DB -->
            <div class="products-filter-group">
                <h4 class="products-filter-group-title">Danh mục</h4>
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

            <!-- Danh mục phụ -->
            <div class="products-filter-group">
                <h4 class="products-filter-group-title">Danh mục phụ</h4>
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

            <!-- Khoảng giá -->
            <div class="products-filter-group">
                <h4 class="products-filter-group-title">Khoảng giá</h4>
                <div class="products-filter-options">
                    @php
                        $priceRanges = [
                            'under-500k' => 'Dưới 500K',
                            '500k-1m'    => '500K - 1M',
                            '1m-2m'      => '1M - 2M',
                            'over-2m'    => 'Trên 2M',
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
                        <span>hoặc</span>
                    </div>
                    <div class="filter-price-inputs">
                        <input type="number"
                               name="min_price"
                               value="{{ request('min_price') }}"
                               placeholder="Từ"
                               min="0"
                               class="filter-price-input"
                               aria-label="Giá tối thiểu">
                        <span class="filter-price-separator">-</span>
                        <input type="number"
                               name="max_price"
                               value="{{ request('max_price') }}"
                               placeholder="Đến"
                               min="0"
                               class="filter-price-input"
                               aria-label="Giá tối đa">
                    </div>
                </div>
            </div>

            <!-- Tình trạng -->
            <div class="products-filter-group">
                <h4 class="products-filter-group-title">Tình trạng</h4>
                <div class="products-filter-options">
                    <label class="products-filter-option">
                        <input type="checkbox"
                               class="products-filter-checkbox"
                               name="in_stock"
                               value="1"
                               {{ request('in_stock') ? 'checked' : '' }}>
                        <span class="products-filter-label">Chỉ hiển thị sản phẩm còn hàng</span>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="products-filter-footer">
            <a href="{{ $clearUrl }}" class="products-filter-clear" id="filterClear">
                Đặt lại
            </a>
            <button type="submit" class="products-filter-apply">
                Áp dụng
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
                        Không tìm thấy sản phẩm nào
                    @else
                        Không có sản phẩm nào
                    @endif
                </h3>
                <p class="products-empty-description">
                    @if(request('q') || request('search'))
                        Không có sản phẩm nào phù hợp với "{{ request('q') ?: request('search') }}"
                    @elseif(count($activeFilterChips ?? []) > 0)
                        Không có sản phẩm nào phù hợp với bộ lọc đã chọn
                    @else
                        Hiện tại chưa có sản phẩm nào
                    @endif
                </p>
                
                <!-- Suggestions -->
                <div class="products-empty-suggestions">
                    <h4 class="products-empty-suggestions-title">Gợi ý:</h4>
                    <ul class="products-empty-suggestions-list">
                        <li>Thử tìm kiếm với từ khóa khác</li>
                        <li>Xóa bớt bộ lọc để xem nhiều sản phẩm hơn</li>
                        <li>Danh mục sản phẩm đa dạng đang chờ bạn khám phá</li>
                    </ul>
                </div>
                
                @if(request('q') || request('search') || count($activeFilterChips ?? []) > 0)
                    <a href="{{ route('products.index') }}" class="products-empty-action btn btn-primary">
                        Xem tất cả sản phẩm
                    </a>
                @endif
            </div>
        @else
            <div class="products-grid" id="productsGrid">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
                <nav class="products-pagination" role="navigation" aria-label="Pagination">
                    {{-- Previous Page Link --}}
                    @if ($products->onFirstPage())
                        <span class="pagination-item disabled" aria-disabled="true" aria-label="Trang trước">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="pagination-item" rel="prev" aria-label="Trang trước">
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
                        <a href="{{ $products->nextPageUrl() }}" class="pagination-item" rel="next" aria-label="Trang kế">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @else
                        <span class="pagination-item disabled" aria-disabled="true" aria-label="Trang kế">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    @endif
                </nav>
                
                <div class="pagination-info">
                    Trang {{ $products->currentPage() }} / {{ $products->lastPage() }} 
                    ({{ $products->total() }} sản phẩm)
                </div>
            @endif
            </div>
        @endif
    </div>
</section>

<!-- Editorial Section -->
<section class="products-editorial">
    <div class="products-editorial-container">
        <img 
            src="{{ $siteBanners['products'] ?? asset('images/editorial/detail-1.jpg') }}" 
            alt="Flower Journal"
            class="products-editorial-image"
        >
        
        <div class="products-editorial-content">
            <div class="products-editorial-eyebrow">FLOWER JOURNAL</div>
            <h2 class="products-editorial-heading">Câu chuyện về hoa</h2>
            <p class="products-editorial-description">Khám phá thế giới hoa tươi, những ý nghĩa đằng sau mỗi loài hoa và cách chăm sóc để giữ hoa tươi lâu hơn.</p>
            <a href="{{ route('blog.index') }}" class="products-editorial-button">
                Đọc ngay
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
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

    // Product card wishlist toggle
    const wishlistBtns = document.querySelectorAll('.product-card-wishlist');
    wishlistBtns.forEach(btn => {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = this.dataset.productId;
            const isActive = this.classList.contains('active');
            
            try {
                const response = await fetch('/san-pham/' + productId + '/favorite', {
                    method: isActive ? 'DELETE' : 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Content-Type': 'application/json',
                    },
                });
                
                if (response.ok) {
                    this.classList.toggle('active');
                }
            } catch (error) {
                console.error('Error toggling wishlist:', error);
            }
        });
    });
});
</script>
@endpush
