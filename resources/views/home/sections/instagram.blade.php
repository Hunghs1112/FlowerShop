{{-- Instagram Gallery Section --}}
@php
    $instagramUrl = $siteSettings['instagram_url'] ?? null;
    $siteName     = $siteSettings['site_name'] ?? config('app.name');
    $instagramHandle = '';
    if ($instagramUrl) {
        $instagramHandle = '@' . rtrim(basename(rtrim($instagramUrl, '/')), '/');
    }
@endphp

<section class="instagram-section">
    <div class="container">
        {{-- Header --}}
        <div class="instagram-section-header">
            <span class="instagram-section-label">{{ content('instagram_label', 'Kết nối với chúng tôi') }}</span>
            <h2 class="instagram-section-title">{{ content('instagram_title', $siteName . ' trên Instagram') }}</h2>
            @if($instagramUrl)
                <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="instagram-section-handle">{{ $instagramHandle }}</a>
            @endif
        </div>

        {{-- Instagram Gallery Grid --}}
        <div class="instagram-gallery">
            @php
            $instagramImages = [
                ['url' => asset('images/instagram/flowers-6.jpg'), 'alt' => 'Bouquet arrangement'],
                ['url' => asset('images/instagram/flowers-2.jpg'), 'alt' => 'Flower arrangement'],
                ['url' => asset('images/instagram/flowers-3.jpg'), 'alt' => 'Florist studio'],
                ['url' => asset('images/instagram/roses.jpg'), 'alt' => 'Flower close-up'],
                ['url' => asset('images/instagram/flowers-5.jpg'), 'alt' => 'Lifestyle flower photo'],
                ['url' => asset('images/instagram/flowers-1.jpg'), 'alt' => 'Wedding bouquet'],
            ];
            @endphp

            @foreach($instagramImages as $image)
            <a href="{{ $instagramUrl ?? '#' }}" target="_blank" rel="noopener noreferrer" class="instagram-item">
                <img
                    src="{{ $image['url'] }}"
                    alt="{{ $image['alt'] }}"
                    class="instagram-item-image"
                    loading="lazy"
                    width="400"
                    height="400"
                >
                <div class="instagram-item-overlay">
                    <div class="instagram-item-icon-wrap">
                        <svg class="instagram-item-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Follow Button --}}
        @if($instagramUrl)
        <div class="instagram-section-footer">
            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline">
                {{ content('instagram_follow_button', 'Theo dõi trên Instagram') }}
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
        @endif
    </div>
</section>
