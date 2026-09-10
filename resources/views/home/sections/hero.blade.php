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
                <span class="hero-label">{{ __('messages.home.hero1_label') }}</span>
                <h1 class="hero-title">
                    {{ __('messages.home.hero1_title') }}
                </h1>
                <p class="hero-description">
                    {{ __('messages.home.hero1_desc') }}
                </p>
                <a href="{{ locale_route('products.index') }}" class="hero-cta">
                    {{ __('messages.home.hero1_cta') }}
                    <svg class="hero-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            {{-- Slide 02 --}}
            <div class="hero-slide" data-slide="1">
                <span class="hero-label">{{ __('messages.home.hero2_label') }}</span>
                <h1 class="hero-title">
                    {{ __('messages.home.hero2_title') }}
                </h1>
                <p class="hero-description">
                    {{ __('messages.home.hero2_desc') }}
                </p>
                <a href="{{ locale_route('categories.index') }}" class="hero-cta">
                    {{ __('messages.home.hero2_cta') }}
                    <svg class="hero-cta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            {{-- Slide 03 --}}
            <div class="hero-slide" data-slide="2">
                <span class="hero-label">{{ __('messages.home.hero3_label') }}</span>
                <h1 class="hero-title">
                    {{ __('messages.home.hero3_title') }}
                </h1>
                <p class="hero-description">
                    {{ __('messages.home.hero3_desc') }}
                </p>
                <a href="{{ locale_route('products.index') }}" class="hero-cta">
                    {{ __('messages.home.hero3_cta') }}
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
