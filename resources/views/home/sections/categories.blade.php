{{-- Categories Discovery Section --}}
<section class="categories-section">
    <div class="categories-container">
        {{-- Left Side - Image Cards (first 2 categories from DB) --}}
        <div class="categories-images">
            @foreach($categories->take(2) as $catCard)
            <a href="{{ locale_route('categories.show', $catCard->display_slug) }}" class="category-image-card">
                @if($catCard->icon)
                    <img
                        src="{{ asset('storage/' . $catCard->icon) }}"
                        alt="{{ $catCard->display_name }}"
                        loading="lazy"
                    >
                @else
                    <img
                        src="{{ asset('images/categories/category-' . $loop->iteration . '.jpg') }}"
                        alt="{{ $catCard->display_name }}"
                        loading="lazy"
                    >
                @endif
                <div class="category-image-overlay"></div>
                <div class="category-image-content">
                    <h3 class="category-image-title">{{ Str::upper($catCard->display_name) }}</h3>
                    <p class="category-image-count">{{ $catCard->products_count ?? $catCard->products()->count() }}+ {{ Str::lower(__('messages.categories.product_count')) }}</p>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Right Side - Content --}}
        <div class="categories-content">
            <span class="categories-label">{{ __('messages.home.categories_title') }}</span>
            <h2 class="categories-heading">{{ __('messages.home.categories_title') }}</h2>
            <div class="categories-heading-decoration"></div>

            <ul class="categories-list">
                @foreach($categories as $cat)
                    <li class="category-list-item">
                        <a href="{{ locale_route('categories.show', $cat->display_slug) }}" class="category-list-link">
                            <span class="category-list-name">{{ $cat->display_name }}</span>
                            <div class="category-list-arrow">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
