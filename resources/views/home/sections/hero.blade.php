{{-- Hero Section with Banner Slider --}}
<section class="hero" id="heroSection">
    @if($banners->isNotEmpty())
        {{-- Dynamic Banner Slider --}}
        <div class="hero-slider">
            {{-- Background Images (all backgrounds at same level for smooth transition) --}}
            @foreach($banners as $index => $banner)
                <div class="hero-background {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                    <img 
                        src="{{ $banner->image_url }}"
                        alt="{{ $banner->title ?? 'Banner' }}"
                        class="hero-background-image"
                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                    >
                </div>
            @endforeach

            {{-- Content Slides --}}
            <div class="hero-container">
                <div class="hero-content-wrapper">
                    <div class="hero-content">
                        @foreach($banners as $index => $banner)
                            @if($banner->hasText() || $banner->hasCta())
                                <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                                    @if($banner->title)
                                        <span class="hero-label">{{ $banner->title }}</span>
                                    @endif
                                    @if($banner->subtitle)
                                        <h1 class="hero-title">{{ $banner->subtitle }}</h1>
                                    @endif
                                    @if($banner->hasCta())
                                        <a href="{{ $banner->button_link }}" class="hero-cta">
                                            {{ $banner->button_text }}
                                            <svg class="hero-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>

                    {{-- Slider Controls (only show if more than 1 banner) --}}
                    @if($banners->count() > 1)
                        <div class="hero-controls">
                            <div class="hero-indicators">
                                @foreach($banners as $index => $banner)
                                    <button class="hero-indicator {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}" aria-label="Banner {{ $index + 1 }}">
                                        <div class="hero-indicator-progress"></div>
                                    </button>
                                @endforeach
                            </div>
                            
                            <div class="hero-counter">
                                <span class="hero-counter-current">01</span>
                                <span class="hero-counter-separator">/</span>
                                <span class="hero-counter-total">{{ str_pad($banners->count(), 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Scroll Down Button --}}
        <button class="hero-scroll-btn" id="heroScrollBtn" aria-label="Cuộn xuống">
            <svg class="hero-scroll-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </button>

    @else
        {{-- Fallback: Use static banner from settings if no dynamic banners --}}
        <div class="hero-background">
            <img 
                src="{{ $siteBanners['home'] ?? asset('images/banners/home-hero.jpg') }}"
                alt="Premium Fresh Flowers"
                class="hero-background-image"
                loading="eager"
            >
        </div>

        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-slide active" data-slide="0">
                    <span class="hero-label">{{ content('hero_slide_1_label', 'HOA TƯƠI CAO CẤP') }}</span>
                    <h1 class="hero-title">
                        {{ content('hero_slide_1_title', 'Tạo Khoảnh Khắc Đặc Biệt') }}
                    </h1>
                    <p class="hero-description">
                        {{ content('hero_slide_1_description', 'Khám phá bộ sưu tập hoa tươi nhập khẩu cao cấp, được chăm sóc tỉ mỉ để mang đến vẻ đẹp rực rỡ cho mọi dịp.') }}
                    </p>
                    <a href="{{ route('products.index') }}" class="hero-cta">
                        {{ content('hero_slide_1_button', 'Khám phá ngay') }}
                        <svg class="hero-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <button class="hero-scroll-btn" id="heroScrollBtn" aria-label="Cuộn xuống">
            <svg class="hero-scroll-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </button>
    @endif
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contentSlides = document.querySelectorAll('.hero-slide');
    const backgrounds = document.querySelectorAll('.hero-background');
    const indicators = document.querySelectorAll('.hero-indicator');
    const counterCurrent = document.querySelector('.hero-counter-current');
    const totalSlides = contentSlides.length;

    // Only run slider if there's more than 1 slide
    if (totalSlides <= 1) {
        // Just handle scroll button
        const scrollBtn = document.getElementById('heroScrollBtn');
        if (scrollBtn) {
            scrollBtn.addEventListener('click', () => {
                const heroSection = document.getElementById('heroSection');
                const nextSection = heroSection?.nextElementSibling;
                if (nextSection) {
                    nextSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        }
        return;
    }

    let currentSlide = 0;
    const slideInterval = 5000; // 5 seconds
    let autoplayTimer;

    function goToSlide(index) {
        // Remove active from all content slides, backgrounds, and indicators
        contentSlides.forEach(slide => slide.classList.remove('active'));
        backgrounds.forEach(bg => bg.classList.remove('active'));
        indicators.forEach(indicator => {
            indicator.classList.remove('active');
            const progress = indicator.querySelector('.hero-indicator-progress');
            if (progress) progress.style.width = '0';
        });

        // Add active to current slide, background, and indicator
        if (contentSlides[index]) contentSlides[index].classList.add('active');
        if (backgrounds[index]) backgrounds[index].classList.add('active');
        if (indicators[index]) indicators[index].classList.add('active');
        
        // Update counter
        if (counterCurrent) {
            counterCurrent.textContent = String(index + 1).padStart(2, '0');
        }
        
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
    if (heroSection) {
        heroSection.addEventListener('mouseenter', () => {
            clearTimeout(autoplayTimer);
        });
        
        heroSection.addEventListener('mouseleave', () => {
            startAutoplay();
        });
    }

    // Scroll down button
    const scrollBtn = document.getElementById('heroScrollBtn');
    if (scrollBtn) {
        scrollBtn.addEventListener('click', () => {
            const nextSection = heroSection?.nextElementSibling;
            if (nextSection) {
                nextSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }
});
</script>
