@props([
    'title',
    'description' => '',
    'label' => '',
    'breadcrumbs' => [],
    'image' => null,
    'variant' => 'default',
    'hideOverlay' => false,
    'hideContent' => false,
    'bannerKey' => null,
])

@php($bannerSize = $bannerKey ? ($siteBannerSizes[$bannerKey] ?? null) : null)

<section class="page-hero {{ $image ? 'page-hero--with-image' : '' }} {{ $variant === 'compact' ? 'page-hero--compact' : '' }} {{ ($hideOverlay || $hideContent) ? 'page-hero--no-overlay' : '' }}" @if($bannerSize) style="--banner-height-desktop: {{ $bannerSize['desktop'] }}px; --banner-height-mobile: {{ $bannerSize['mobile'] }}px;" @endif>
    @if($image)
        <div class="page-hero-background">
            <img 
                src="{{ asset($image) }}" 
                alt="{{ $title }}"
                class="page-hero-background-image"
                loading="eager"
            >
        </div>
    @endif
    
    <div class="page-hero-container container {{ $hideContent ? 'page-hero-container--hidden' : '' }}" @if($hideContent) aria-hidden="true" @endif>
        @if(count($breadcrumbs) > 0)
            <nav class="page-hero-breadcrumb" aria-label="Breadcrumb">
                @foreach($breadcrumbs as $index => $breadcrumb)
                    <div class="page-hero-breadcrumb-item">
                        @if($index > 0)
                            <span class="page-hero-breadcrumb-separator">/</span>
                        @endif
                        @if(isset($breadcrumb['url']))
                            <a href="{{ $breadcrumb['url'] }}" class="page-hero-breadcrumb-link">{{ $breadcrumb['label'] }}</a>
                        @else
                            <span class="page-hero-breadcrumb-current">{{ $breadcrumb['label'] }}</span>
                        @endif
                    </div>
                @endforeach
            </nav>
        @endif
        
        <div class="page-hero-content">
            @if($label)
                <span class="page-hero-label">{{ $label }}</span>
            @endif
            
            <h1 class="page-hero-title">{{ $title }}</h1>
            
            @if($description)
                <p class="page-hero-description">{{ $description }}</p>
            @endif
            
            {{ $slot }}
        </div>
    </div>
    
    @if(!$image)
        <div class="page-hero-decoration">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 20C100 20 120 40 120 60C120 80 110 90 100 90C90 90 80 80 80 60C80 40 100 20 100 20Z" stroke-width="2"/>
                <path d="M100 90C100 90 85 95 75 105C65 115 65 130 75 140C85 150 100 150 100 150" stroke-width="2"/>
                <path d="M100 90C100 90 115 95 125 105C135 115 135 130 125 140C115 150 100 150 100 150" stroke-width="2"/>
                <circle cx="100" cy="160" r="8" stroke-width="2"/>
            </svg>
        </div>
    @endif
</section>
