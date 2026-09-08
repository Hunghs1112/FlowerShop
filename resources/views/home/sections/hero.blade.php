{{-- Hero Section with Text Slider --}}
<section class="hero" id="heroSection">
    {{-- Background Image - Fixed for all slides --}}
    <div class="hero-background">
        <img 
            src="{{ asset('images/hero/hero-bg.jpg') }}" 
            alt="Premium Fresh Flowers" 
            class="hero-background-image"
            loading="eager"
        >
    </div>

    {{-- Content Container --}}
    <div class="hero-container">
        <div class="hero-content">
            {{-- Slide 01 --}}
            <div class="hero-slide active" data-slide="0">
                <span class="hero-label">HOA TƯƠI MỖI NGÀY</span>
                <h1 class="hero-title">
                    Trao hoa,<br>
                    trao những điều đẹp nhất
                </h1>
                <p class="hero-description">
                    Những bó hoa tươi được tuyển chọn kỹ lưỡng,
                    gói ghém trọn vẹn tình cảm dành cho người bạn yêu thương.
                </p>
                <a href="{{ route('products.index') }}" class="hero-cta">
                    Khám phá hoa tươi
                    <svg class="hero-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            {{-- Slide 02 --}}
            <div class="hero-slide" data-slide="1">
                <span class="hero-label">HOA NHẬP KHẨU</span>
                <h1 class="hero-title">
                    Vẻ đẹp tinh tế<br>
                    từ những mùa hoa trên thế giới
                </h1>
                <p class="hero-description">
                    Khám phá những giống hoa nhập khẩu được tuyển chọn
                    và chăm sóc cẩn thận để giữ trọn vẻ đẹp tự nhiên.
                </p>
                <a href="{{ route('categories.index') }}" class="hero-cta">
                    Khám phá hoa nhập khẩu
                    <svg class="hero-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            {{-- Slide 03 --}}
            <div class="hero-slide" data-slide="2">
                <span class="hero-label">DỊCH VỤ ĐẶC BIỆT</span>
                <h1 class="hero-title">
                    Thiết kế riêng<br>
                    theo phong cách của bạn
                </h1>
                <p class="hero-description">
                    Đội ngũ florist chuyên nghiệp sẵn sàng tư vấn và thiết kế
                    những bó hoa độc đáo, phù hợp với mọi dịp đặc biệt.
                </p>
                <a href="{{ route('products.index') }}" class="hero-cta">
                    Tư vấn thiết kế
                    <svg class="hero-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {{-- Slider Controls --}}
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
