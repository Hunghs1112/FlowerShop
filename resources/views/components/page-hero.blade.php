@props([
    'title',
    'description' => '',
    'breadcrumbs' => [],
    'image' => null,
    'height' => '400px'
])

<section class="page-hero">
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


