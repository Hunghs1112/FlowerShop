{{-- Categories Discovery Section --}}
<section class="categories-section">
    <div class="container">
        <div class="categories-section-header">
            <span class="categories-section-label">Danh mục sản phẩm</span>
            <h2 class="categories-section-title">Khám Phá Bộ Sưu Tập</h2>
        </div>

        <div class="categories-grid">
            @foreach($categories->take(6) as $index => $category)
                <a href="{{ route('categories.show', $category->display_slug) }}" class="category-card">
                    @if($category->image)
                        <img
                            src="{{ $category->image_url }}"
                            alt="{{ $category->display_name }}"
                            class="category-card-image"
                            loading="lazy"
                        >
                    @else
                        <img
                            src="{{ asset('images/categories/placeholder.jpg') }}"
                            alt="{{ $category->display_name }}"
                            class="category-card-image"
                            loading="lazy"
                        >
                    @endif
                    
                    <div class="category-card-overlay"></div>
                    
                    <div class="category-card-content">
                        <h3 class="category-card-title">{{ $category->display_name }}</h3>
                        <span class="category-card-count">{{ $category->products_count ?? $category->products()->count() }} sản phẩm</span>
                        <span class="category-card-link">
                            <span>Khám phá</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
