
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
                <span class="hero-label"><?php echo e(content('hero_slide_1_label', 'HOA TƯƠI CAO CẤP')); ?></span>
                <h1 class="hero-title">
                    <?php echo e(content('hero_slide_1_title', 'Tạo Khoảnh Khắc Đặc Biệt')); ?>

                </h1>
                <p class="hero-description">
                    <?php echo e(content('hero_slide_1_description', 'Khám phá bộ sưu tập hoa tươi nhập khẩu cao cấp, được chăm sóc tỉ mỉ để mang đến vẻ đẹp rực rỡ cho mọi dịp.')); ?>

                </p>
                <a href="<?php echo e(route('products.index')); ?>" class="hero-cta">
                    <?php echo e(content('hero_slide_1_button', 'Khám phá ngay')); ?>

                    <svg class="hero-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            
            <div class="hero-slide" data-slide="1">
                <span class="hero-label"><?php echo e(content('hero_slide_2_label', 'BỘ SƯU TẬP MỚI')); ?></span>
                <h1 class="hero-title">
                    <?php echo e(content('hero_slide_2_title', 'Hoa Tươi Cho Mọi Dịp')); ?>

                </h1>
                <p class="hero-description">
                    <?php echo e(content('hero_slide_2_description', 'Từ sinh nhật, kỷ niệm đến những lời chúc yêu thương - chúng tôi có hoa phù hợp cho mọi khoảnh khắc.')); ?>

                </p>
                <a href="<?php echo e(route('categories.index')); ?>" class="hero-cta">
                    <?php echo e(content('hero_slide_2_button', 'Xem danh mục')); ?>

                    <svg class="hero-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            
            <div class="hero-slide" data-slide="2">
                <span class="hero-label"><?php echo e(content('hero_slide_3_label', 'GIAO HÀNG NHANH')); ?></span>
                <h1 class="hero-title">
                    <?php echo e(content('hero_slide_3_title', 'Giao Tận Tay Người Nhận')); ?>

                </h1>
                <p class="hero-description">
                    <?php echo e(content('hero_slide_3_description', 'Dịch vụ giao hoa nhanh chóng chỉ trong 2-4 giờ, đảm bảo hoa tươi rực khi đến tay người nhận.')); ?>

                </p>
                <a href="<?php echo e(route('products.index')); ?>" class="hero-cta">
                    <?php echo e(content('hero_slide_3_button', 'Đặt ngay')); ?>

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

    
    <button class="hero-scroll-btn" id="heroScrollBtn" aria-label="Cuộn xuống">
        <svg class="hero-scroll-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </button>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.hero-slide');
    const indicators = document.querySelectorAll('.hero-indicator');
    const counterCurrent = document.querySelector('.hero-counter-current');
    let currentSlide = 0;
    const totalSlides = slides.length;
    const slideInterval = 5000; // 5 seconds
    let autoplayTimer;

    function goToSlide(index) {
        // Remove active from all slides and indicators
        slides.forEach(slide => slide.classList.remove('active'));
        indicators.forEach(indicator => {
            indicator.classList.remove('active');
            const progress = indicator.querySelector('.hero-indicator-progress');
            progress.style.width = '0';
        });

        // Add active to current slide and indicator
        slides[index].classList.add('active');
        indicators[index].classList.add('active');
        
        // Update counter
        counterCurrent.textContent = String(index + 1).padStart(2, '0');
        
        currentSlide = index;
        
        // Reset autoplay timer
        clearTimeout(autoplayTimer);
        startAutoplay();
    }

    function nextSlide() {
        const next = (currentSlide + 1) % totalSlides;
        goToSlide(next);
    }

    function startAutoplay() {
        autoplayTimer = setTimeout(nextSlide, slideInterval);
    }

    // Indicator click handlers
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            goToSlide(index);
        });
    });

    // Start autoplay
    startAutoplay();
    
    // Pause on hover
    const heroSection = document.getElementById('heroSection');
    heroSection.addEventListener('mouseenter', () => {
        clearTimeout(autoplayTimer);
    });
    
    heroSection.addEventListener('mouseleave', () => {
        startAutoplay();
    });

    // Scroll down button
    const scrollBtn = document.getElementById('heroScrollBtn');
    if (scrollBtn) {
        scrollBtn.addEventListener('click', () => {
            const nextSection = heroSection.nextElementSibling;
            if (nextSection) {
                nextSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }
});
</script>
<?php /**PATH /root/FlowerShop/resources/views/home/sections/hero.blade.php ENDPATH**/ ?>