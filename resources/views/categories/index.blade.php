@extends('layouts.app')

@section('title', __('storefront.category_title'))


@section('content')
<!-- Hero Banner -->
<section class="categories-hero">
    <img
        src="{{ $siteBanners['categories'] ?? asset('images/banners/danh-muc-hero.jpg') }}"
        alt="{{ __('storefront.category_title') }}"
        class="categories-hero-image"
    >
    @unless($siteBannerHideOverlay['categories'] ?? false)
    <div class="categories-hero-overlay"></div>
    @endunless
    <div class="categories-hero-content">
        <h1 class="categories-hero-heading">{{ __('storefront.category_title') }}</h1>
        <p class="categories-hero-description">{{ __('storefront.category_description') }}</p>
    </div>
</section>

<!-- Categories Grid -->
<section class="categories-index-section">
    <div class="categories-index-grid">
        @forelse($categories as $category)
        <a href="{{ localized_route('categories.show', $category->display_slug) }}" class="category-card">
            <img
                src="{{ $category->image ? $category->image_url : asset('images/categories/category-default.jpg') }}"
                alt="{{ $category->display_name }}"
                class="category-card-image"
            >
            <div class="category-card-overlay">
                <h3 class="category-card-name">{{ $category->display_name }}</h3>
                <p class="category-card-count">{{ __('storefront.product_count', ['count' => $category->products_count ?? 0]) }}</p>
            </div>
        </a>
        @empty
        <div class="categories-empty">
            <p>{{ __('storefront.empty_categories') }}</p>
        </div>
        @endforelse
    </div>
</section>
@endsection
