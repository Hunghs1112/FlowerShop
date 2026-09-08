@extends('layouts.app')

@section('title', $category->name)

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
        alt="{{ $category->name }}"
        class="products-hero-image"
    >
    <div class="products-hero-overlay"></div>
    <div class="products-hero-content">
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
        <h1 class="products-hero-heading">{{ $category->name }}</h1>
        @if($category->description)
        <p class="products-hero-description">{{ $category->description }}</p>
        @endif
    </div>
</section>

<!-- Subcategories -->
@if($category->children && $category->children->count() > 0)
<section style="padding: 2rem; background: #f9fafb;">
    <div style="max-width: 1400px; margin: 0 auto;">
        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">Danh mục con</h3>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            @foreach($category->children as $child)
            <a href="{{ route('categories.show', $child->slug) }}" 
               style="padding: 0.5rem 1rem; background: white; border: 1px solid #e5e7eb; border-radius: 8px; text-decoration: none; color: #374151; transition: all 0.2s;"
               onmouseover="this.style.borderColor='#10b981'; this.style.color='#10b981';"
               onmouseout="this.style.borderColor='#e5e7eb'; this.style.color='#374151';">
                {{ $child->name }}
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
            Bộ lọc
        </button>
        <span class="products-count">{{ $products->total() }} sản phẩm</span>
    </div>
    
    <div class="products-toolbar-right">
        <div class="products-sort-dropdown">
            <button class="products-sort-button" id="sortToggle">
                <span>Sắp xếp: <span id="sortLabel">
                    @switch($filters['sort_by'] ?? 'latest')
                        @case('price_asc') Giá thấp → cao @break
                        @case('price_desc') Giá cao → thấp @break
                        @case('name') Tên A-Z @break
                        @default Mới nhất
                    @endswitch
                </span></span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="products-sort-menu" id="sortMenu">
                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'latest']) }}" class="products-sort-item {{ ($filters['sort_by'] ?? 'latest') === 'latest' ? 'active' : '' }}">Mới nhất</a>
                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'price_asc']) }}" class="products-sort-item {{ ($filters['sort_by'] ?? '') === 'price_asc' ? 'active' : '' }}">Giá thấp → cao</a>
                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'price_desc']) }}" class="products-sort-item {{ ($filters['sort_by'] ?? '') === 'price_desc' ? 'active' : '' }}">Giá cao → thấp</a>
                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'name']) }}" class="products-sort-item {{ ($filters['sort_by'] ?? '') === 'name' ? 'active' : '' }}">Tên A-Z</a>
            </div>
        </div>
    </div>
</section>

<!-- Filter Sidebar -->
<div class="products-filter-overlay" id="filterOverlay"></div>
<aside class="products-filter-sidebar" id="filterSidebar">
    <div class="products-filter-header">
        <h3 class="products-filter-title">Bộ lọc</h3>
        <button class="products-filter-close" id="filterClose">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    
    <form action="{{ route('categories.show', $category->slug) }}" method="GET" id="filterForm">
        <div class="products-filter-body">
            <!-- Khoảng giá -->
            <div class="products-filter-group">
                <h4 class="products-filter-group-title">Khoảng giá</h4>
                <div class="products-filter-options">
                    <div style="padding: 1rem 0;">
                        <input type="number" name="min_price" placeholder="Từ" value="{{ $filters['min_price'] ?? '' }}" 
                               style="width: 100%; padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 6px; margin-bottom: 0.5rem;">
                        <input type="number" name="max_price" placeholder="Đến" value="{{ $filters['max_price'] ?? '' }}"
                               style="width: 100%; padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 6px;">
                    </div>
                </div>
            </div>
            
            <!-- Còn hàng -->
            <div class="products-filter-group">
                <label class="products-filter-option">
                    <input type="checkbox" name="in_stock" value="1" {{ ($filters['in_stock'] ?? false) ? 'checked' : '' }} class="products-filter-checkbox">
                    <span class="products-filter-label">Chỉ hiển thị sản phẩm còn hàng</span>
                </label>
            </div>
        </div>
        
        <div class="products-filter-footer">
            <a href="{{ route('categories.show', $category->slug) }}" class="products-filter-clear">Xóa bộ lọc</a>
            <button type="submit" class="products-filter-apply">Áp dụng</button>
        </div>
    </form>
</aside>

<!-- Products Grid -->
<section class="products-grid-section">
    <div class="products-grid-container">
        <div class="products-grid" id="productsGrid">
            @forelse($products as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                <div class="product-card-image-wrapper">
                    <img 
                        src="{{ $product->image ?? asset('images/products/product-default.jpg') }}" 
                        alt="{{ $product->name }}"
                        class="product-card-image"
                    >
                    
                    @if($product->discount_percentage)
                    <span class="product-card-badge">-{{ $product->discount_percentage }}%</span>
                    @endif
                    
                    @auth
                    <button class="product-card-wishlist" aria-label="Thêm vào yêu thích"
                            onclick="event.preventDefault(); toggleFavorite({{ $product->id }})">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    @endauth
                    
                    <div class="product-card-overlay">
                        <button class="product-card-view-button">Xem chi tiết</button>
                    </div>
                </div>
                
                <span class="product-card-category">{{ $product->category->name ?? '' }}</span>
                <h3 class="product-card-name">{{ $product->name }}</h3>
                
                <div class="product-card-price-wrapper">
                    <span class="product-card-price">{{ number_format($product->price) }}đ</span>
                    @if($product->old_price)
                    <span class="product-card-old-price">{{ number_format($product->old_price) }}đ</span>
                    @endif
                </div>
            </a>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                <p style="color: #666;">Không có sản phẩm nào trong danh mục này.</p>
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

@auth
function toggleFavorite(productId) {
    fetch('{{ route("favorites.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Toggle visual state
            event.target.closest('.product-card-wishlist').classList.toggle('active');
        }
    });
}
@endauth
</script>
@endpush
