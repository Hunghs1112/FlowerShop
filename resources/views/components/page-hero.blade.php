@props([
    'title',
    'description' => '',
    'breadcrumbs' => [],
    'image' => null,
    'height' => '400px'
])

<section class="page-hero" style="height: {{ $height }}">
    @if($image)
        <img 
            src="{{ asset($image) }}" 
            alt="{{ $title }}"
            class="page-hero-image"
        >
    @endif
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        @if(count($breadcrumbs) > 0)
            <div class="page-breadcrumb">
                @foreach($breadcrumbs as $index => $breadcrumb)
                    @if($index > 0)
                        <span>/</span>
                    @endif
                    @if(isset($breadcrumb['url']))
                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                    @else
                        <span>{{ $breadcrumb['label'] }}</span>
                    @endif
                @endforeach
            </div>
        @endif
        <h1 class="page-hero-heading">{{ $title }}</h1>
        @if($description)
            <p class="page-hero-description">{{ $description }}</p>
        @endif
    </div>
</section>

@push('styles')
<style>
    .page-hero {
        position: relative;
        width: 100%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    }

    .page-hero-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .page-hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            to bottom,
            rgba(0, 0, 0, 0.3) 0%,
            rgba(0, 0, 0, 0.45) 100%
        );
    }

    .page-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: #FFFFFF;
        max-width: 720px;
        padding: 0 24px;
    }

    .page-breadcrumb {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 13px;
        font-weight: 400;
        margin-bottom: 24px;
        color: rgba(255, 255, 255, 0.95);
    }

    .page-breadcrumb a {
        color: inherit;
        text-decoration: none;
        transition: all 0.2s ease;
        border-bottom: 1px solid transparent;
    }

    .page-breadcrumb a:hover {
        border-bottom-color: rgba(255, 255, 255, 0.7);
    }

    .page-hero-heading {
        font-size: 56px;
        font-weight: 700;
        letter-spacing: -1.5px;
        margin: 0 0 20px 0;
        line-height: 1.1;
        color: #FFFFFF;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .page-hero-description {
        font-size: 17px;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.95);
        max-width: 600px;
        margin: 0 auto;
        text-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .page-hero-heading {
            font-size: 48px;
            letter-spacing: -1.2px;
        }
        
        .page-hero-description {
            font-size: 16px;
        }
    }

    @media (max-width: 768px) {
        .page-hero-content {
            padding: 0 20px;
        }
        
        .page-breadcrumb {
            font-size: 12px;
            margin-bottom: 20px;
        }
        
        .page-hero-heading {
            font-size: 36px;
            letter-spacing: -1px;
            margin-bottom: 16px;
        }
        
        .page-hero-description {
            font-size: 15px;
        }
    }

@endpush
