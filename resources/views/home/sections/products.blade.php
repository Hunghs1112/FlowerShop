{{-- Best Selling Products Section --}}
<section class="products-section">
    <div class="container">
        {{-- Section Header --}}
        <div class="products-section-header">
            <span class="products-section-label">{{ content('products_label', 'Sản phẩm nổi bật') }}</span>
            <h2 class="products-section-title">{{ content('products_title', 'Hoa Tươi Bán Chạy') }}</h2>
            <p class="products-section-description">
                {{ content('products_description', 'Những bó hoa được yêu thích nhất, được chọn lọc kỹ càng từ những loài hoa tươi nhập khẩu cao cấp.') }}
            </p>
        </div>

        {{-- Products Grid --}}
        <div class="products-section-grid" id="productsGrid">
            @foreach($bestsellingProducts->take(8) as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        {{-- View All Button --}}
        <div class="products-section-footer">
            <a href="{{ route('products.index') }}" class="btn btn-outline">
                {{ content('products_view_all', 'Xem tất cả sản phẩm') }}
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
