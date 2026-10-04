@extends('layouts.app')

@section('title', 'Danh mục sản phẩm')


@section('content')
<!-- Hero Banner -->
<section class="categories-hero" style="--banner-height-desktop: {{ $siteBannerSizes['categories']['desktop'] }}px; --banner-height-mobile: {{ $siteBannerSizes['categories']['mobile'] }}px;">
    <img
        src="{{ $siteBanners['categories'] ?? asset('images/banners/danh-muc-hero.jpg') }}"
        alt="Danh mục sản phẩm"
        class="categories-hero-image"
    >
    @unless($siteBannerHideOverlay['categories'] ?? false)
    <div class="categories-hero-overlay"></div>
    @endunless
    <div class="categories-hero-content">
        <h1 class="categories-hero-heading">Danh mục sản phẩm</h1>
        <p class="categories-hero-description">Khám phá các danh mục hoa tươi đa dạng của chúng tôi</p>
    </div>
</section>

<!-- Categories Grid -->
<section class="categories-index-section">
    <div class="categories-index-grid">
        @forelse($categories as $category)
        <a href="{{ route('categories.show', $category->display_slug) }}" class="category-card">
            <img
                src="{{ $category->image ? $category->image_url : asset('images/categories/category-default.jpg') }}"
                alt="{{ $category->display_name }}"
                class="category-card-image"
            >
            <div class="category-card-overlay">
                <h3 class="category-card-name">{{ $category->display_name }}</h3>
                <p class="category-card-count">{{ $category->products_count ?? 0 }} sản phẩm</p>
            </div>
        </a>
        @empty
        <div class="categories-empty">
            <p>Không có danh mục nào.</p>
        </div>
        @endforelse
    </div>
</section>
@endsection
