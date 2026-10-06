{{-- Categories Discovery Section --}}
<section class="categories-section">
    <div class="container">
        <div class="categories-section-header">
            <span class="categories-section-label">{{ content('home_origins_label', 'Từ những vùng đất đặc biệt') }}</span>
            <h2 class="categories-section-title">{{ content('home_origins_title', 'Chín vùng đất hoa') }}</h2>
        </div>

        <div class="categories-grid">
            @foreach($categories as $index => $category)
                <a href="{{ route('products.index', ['categories' => [$category->id]]) }}" class="category-card">
                    @if($category->image)
                        <img
                            src="{{ $category->image_url }}"
                            alt="{{ $category->display_name }}"
                            class="category-card-image category-card-image-default"
                            loading="lazy"
                        >
                        @if($category->hover_image)
                            <img
                                src="{{ $category->hover_image_url }}"
                                alt="{{ $category->display_name }}"
                                class="category-card-image category-card-image-hover"
                                loading="lazy"
                            >
                        @endif
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
                        <span class="category-card-count">{{ $category->products_count ?? $category->products()->count() }} {{ content('categories_products_suffix', 'sản phẩm') }}</span>
                        <span class="category-card-link">
                            <span>{{ content('categories_explore', 'Khám phá') }}</span>
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
