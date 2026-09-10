{{-- Best Selling Products Section --}}
<section class="products-section">
    <div class="products-container">
        {{-- Section Header --}}
        <div class="products-header">
            <h2 class="products-title">{{ __('messages.home.products_title') }}</h2>

            {{-- Category Tabs — IDs embedded from DB, no hardcoding in JS --}}
            <div class="products-tabs">
                <button class="products-tab active" data-category="best-selling">{{ __('messages.nav.best_sellers') }}</button>
                <button class="products-tab" data-category="new-arrival">{{ __('messages.nav.new_flowers') }}</button>
                @foreach($categories->take(3) as $tabCat)
                    <button class="products-tab"
                            data-category="category"
                            data-category-id="{{ $tabCat->id }}">{{ $tabCat->name }}</button>
                @endforeach
            </div>

            <div class="products-divider"></div>
        </div>

        {{-- Products Grid --}}
        <div class="products-grid" id="productsGrid">
            {{-- Products will be loaded dynamically via JavaScript --}}
            <div class="products-loading">{{ __('messages.common.loading') }}</div>
        </div>

        {{-- View All Button --}}
        <div class="products-footer">
            <a href="{{ locale_route('products.index') }}" class="products-view-all">
                {{ __('messages.home.products_link') }}
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
