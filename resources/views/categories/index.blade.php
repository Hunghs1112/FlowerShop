@extends('layouts.app')

@section('title', __('messages.categories.page_title'))


@section('content')
<!-- Hero Banner -->
<section class="categories-hero">
    <img
        src="{{ asset('images/categories/category-hero.jpg') }}"
        alt="{{ __('messages.categories.page_title') }}"
        class="categories-hero-image"
    >
    <div class="categories-hero-overlay"></div>
    <div class="categories-hero-content">
        <h1 class="categories-hero-heading">{{ __('messages.categories.page_title') }}</h1>
        <p class="categories-hero-description">{{ __('messages.categories.page_desc') }}</p>
    </div>
</section>

<!-- Categories Grid -->
<section class="categories-index-section">
    <div class="categories-index-grid">
        @forelse($categories as $category)
        <a href="{{ locale_route('categories.show', $category->display_slug) }}" class="category-card">
            <img
                src="{{ $category->image ?? asset('images/categories/category-default.jpg') }}"
                alt="{{ $category->display_name }}"
                class="category-card-image"
            >
            <div class="category-card-overlay">
                <h3 class="category-card-name">{{ $category->display_name }}</h3>
                <p class="category-card-count">{!! str_replace(':count', $category->products_count ?? 0, __('messages.categories.product_count')) !!}</p>
            </div>
        </a>
        @empty
        <div class="categories-empty">
            <p>{{ __('messages.categories.no_categories') }}</p>
        </div>
        @endforelse
    </div>
</section>
@endsection
