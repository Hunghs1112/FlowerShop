@extends('layouts.app')

@section('title', 'Danh mục sản phẩm')

@push('styles')
<style>
.categories-hero {
    position: relative;
    height: 400px;
    overflow: hidden;
}

.categories-hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.categories-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.5));
}

.categories-hero-content {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
    padding: 2rem;
}

.categories-hero-heading {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.categories-hero-description {
    font-size: 1.125rem;
    max-width: 600px;
}

.categories-section {
    padding: 4rem 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
}

.category-card {
    position: relative;
    height: 350px;
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.3s ease;
    text-decoration: none;
    display: block;
}

.category-card:hover {
    transform: translateY(-8px);
}

.category-card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.category-card:hover .category-card-image {
    transform: scale(1.1);
}

.category-card-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 2rem;
}

.category-card-name {
    color: white;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.category-card-count {
    color: rgba(255,255,255,0.9);
    font-size: 0.875rem;
}
</style>
@endpush

@section('content')
<!-- Hero Banner -->
<section class="categories-hero">
    <img 
        src="{{ asset('images/categories/category-hero.jpg') }}" 
        alt="Danh mục"
        class="categories-hero-image"
    >
    <div class="categories-hero-overlay"></div>
    <div class="categories-hero-content">
        <h1 class="categories-hero-heading">Danh mục sản phẩm</h1>
        <p class="categories-hero-description">Khám phá bộ sưu tập hoa tươi đa dạng của chúng tôi, từ hoa hồng cổ điển đến những loài hoa hiếm độc đáo.</p>
    </div>
</section>

<!-- Categories Grid -->
<section class="categories-section">
    <div class="categories-grid">
        @forelse($categories as $category)
        <a href="{{ route('categories.show', $category->slug) }}" class="category-card">
            <img 
                src="{{ $category->image ?? asset('images/categories/category-default.jpg') }}" 
                alt="{{ $category->name }}"
                class="category-card-image"
            >
            <div class="category-card-overlay">
                <h3 class="category-card-name">{{ $category->name }}</h3>
                <p class="category-card-count">{{ $category->products_count ?? 0 }} sản phẩm</p>
            </div>
        </a>
        @empty
        <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
            <p style="color: #666;">Chưa có danh mục nào.</p>
        </div>
        @endforelse
    </div>
</section>
@endsection
