
<section class="hero" id="heroSection">
    
    <div class="hero-background">
        <img 
            src="<?php echo e($siteBanners['home'] ?? asset('images/banners/home-hero.jpg')); ?>"
            alt="Premium Fresh Flowers"
            class="hero-background-image"
            loading="eager"
        >
    </div>

    
    <div class="hero-container">
        <div class="hero-content">
            
            <div class="hero-slide active" data-slide="0">
                <span class="hero-label">HOA TƯƠI CAO CẤP</span>
                <h1 class="hero-title">
                    Tạo Khoảnh Khắc Đặc Biệt
                </h1>
                <p class="hero-description">
                    Khám phá bộ sưu tập hoa tươi nhập khẩu cao cấp, được chăm sóc tỉ mỉ để mang đến vẻ đẹp rực rỡ cho mọi dịp.
                </p>
                <a href="<?php echo e(route('products.index')); ?>" class="hero-cta">
                    Khám phá ngay
                    <svg class="hero-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            
            <div class="hero-slide" data-slide="1">
                <span class="hero-label">BỘ SƯU TẬP MỚI</span>
                <h1 class="hero-title">
                    Hoa Tươi Cho Mọi Dịp
                </h1>
                <p class="hero-description">
                    Từ sinh nhật, kỷ niệm đến những lời chúc yêu thương - chúng tôi có hoa phù hợp cho mọi khoảnh khắc.
                </p>
                <a href="<?php echo e(route('categories.index')); ?>" class="hero-cta">
                    Xem danh mục
                    <svg class="hero-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            
            <div class="hero-slide" data-slide="2">
                <span class="hero-label">GIAO HÀNG NHANH</span>
                <h1 class="hero-title">
                    Giao Tận Tay Người Nhận
                </h1>
                <p class="hero-description">
                    Dịch vụ giao hoa nhanh chóng chỉ trong 2-4 giờ, đảm bảo hoa tươi rực khi đến tay người nhận.
                </p>
                <a href="<?php echo e(route('products.index')); ?>" class="hero-cta">
                    Đặt ngay
                    <svg class="hero-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    
    <div class="hero-controls">
        <div class="hero-indicators">
            <button class="hero-indicator active" data-slide="0">
                <div class="hero-indicator-progress"></div>
            </button>
            <button class="hero-indicator" data-slide="1">
                <div class="hero-indicator-progress"></div>
            </button>
            <button class="hero-indicator" data-slide="2">
                <div class="hero-indicator-progress"></div>
            </button>
        </div>
        
        <div class="hero-counter">
            <span class="hero-counter-current">01</span>
            <span class="hero-counter-separator">/</span>
            <span class="hero-counter-total">03</span>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop\resources\views/home/sections/hero.blade.php ENDPATH**/ ?>