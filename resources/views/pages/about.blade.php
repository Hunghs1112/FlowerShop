@extends('layouts.app')

@section('title', 'V? ch?ng t?i')

@section('content')
<x-page-hero
    title="V? ch?ng t?i"
    description="C?u chuy?n v? ch?ng t?i v? s? m?nh mang v? ??p hoa t??i ??n m?i nh?"
    :breadcrumbs="[
        ['label' => 'Trang ch?', 'url' => route('home')],
        ['label' => 'V? ch?ng t?i']
    ]"
    :image="$pageBanner['custom'] ?? $siteBanners['about'] ?? null"
    :hideOverlay="$pageBanner['hide_overlay'] ?? ($siteBannerHideOverlay['about'] ?? false)"
    banner-key="about"
/>

<section class="origin-story" id="originStory" aria-labelledby="originStoryTitle">
    <div class="origin-story__shell">
        <header class="origin-story__intro">
            <a class="origin-monogram" href="{{ route('home') }}" aria-label="L?m Nhi?n Th?o ? v? trang ch?">
                <span aria-hidden="true">LNT</span>
                <small>L?m Nhi?n Th?o</small>
            </a>

            <p class="origin-story__eyebrow">Our flower atlas ? 08</p>
            <h1 id="originStoryTitle">T?m v?ng ??t,<br><em>m?t ?i?m ??n</em></h1>
            <p class="origin-story__tagline">From remarkable places, to beautiful spaces.</p>
            <p class="origin-story__lead">L?m Nhi?n Th?o tuy?n ch?n hoa t? nh?ng v?ng tr?ng n?i ti?ng nh?t th? gi?i v? ??a v? TP. H? Ch? Minh. Ch?m v?o t?ng ?i?m tr?n b?n ?? ?? kh?m ph? h?nh tr?nh c?a m?i lo?i hoa.</p>

            <p class="origin-story__hint">
                <span aria-hidden="true"></span>
                Ch?n m?t ?i?m tr?n b?n ?? ho?c t?n n??c b?n d??i
            </p>
        </header>

        <div class="flower-atlas">
            @php
                $flowers = [
                    ['id' => 'netherlands', 'x' => 500, 'y' => 127, 'country' => 'H? Lan', 'flower' => 'Tulip', 'latin' => 'Tulipa gesneriana', 'region' => 'Aalsmeer', 'coordinate' => '52.26?N, 4.76?E', 'image' => 'images/products/product-4.jpg'],
                    ['id' => 'ecuador', 'x' => 280, 'y' => 300, 'country' => 'Ecuador', 'flower' => 'Hoa h?ng', 'latin' => 'Rosa hybrida', 'region' => 'Cayambe', 'coordinate' => '0.04?N, 78.14?W', 'image' => 'images/products/product-1.jpg'],
                    ['id' => 'south-africa', 'x' => 548, 'y' => 389, 'country' => 'Nam Phi', 'flower' => 'Protea vua', 'latin' => 'Protea cynaroides', 'region' => 'Western Cape', 'coordinate' => '33.92?S, 18.42?E', 'image' => 'images/products/product-2.jpg'],
                    ['id' => 'china', 'x' => 773, 'y' => 188, 'country' => 'Trung Qu?c', 'flower' => 'Mao l??ng', 'latin' => 'Ranunculus asiaticus', 'region' => 'V?n Nam', 'coordinate' => '24.88?N, 102.83?E', 'image' => 'images/instagram/flowers-2.jpg'],
                    ['id' => 'japan', 'x' => 879, 'y' => 174, 'country' => 'Nh?t B?n', 'flower' => 'C?c zinnia', 'latin' => 'Zinnia elegans', 'region' => 'Tokyo', 'coordinate' => '35.68?N, 139.69?E', 'image' => 'images/products/hoa-cam-chuong.jpg'],
                    ['id' => 'malaysia', 'x' => 773, 'y' => 306, 'country' => 'Malaysia', 'flower' => 'C?c m?u ??n', 'latin' => 'Chrysanthemum morifolium', 'region' => 'Cameron Highlands', 'coordinate' => '4.47?N, 101.38?E', 'image' => 'images/products/product-3.jpg'],
                    ['id' => 'vietnam', 'x' => 798, 'y' => 274, 'country' => 'Vi?t Nam', 'flower' => 'Lan h? ?i?p', 'latin' => 'Phalaenopsis', 'region' => '?? L?t', 'coordinate' => '11.94?N, 108.44?E', 'image' => 'images/instagram/flowers-6.jpg'],
                    ['id' => 'new-zealand', 'x' => 957, 'y' => 449, 'country' => 'New Zealand', 'flower' => 'M?u ??n', 'latin' => 'Paeonia lactiflora', 'region' => 'Canterbury', 'coordinate' => '43.53?S, 172.64?E', 'image' => 'images/products/hoa-mau-don.jpg'],
                ];
            @endphp
            <div class="flower-atlas__map">
                <svg viewBox="0 0 1000 520" role="group" aria-labelledby="flowerMapTitle flowerMapDescription">
                    <title id="flowerMapTitle">B?n ?? t?m v?ng hoa c?a L?m Nhi?n Th?o</title>
                    <desc id="flowerMapDescription">T?m ???ng bay k?t n?i c?c v?ng tr?ng hoa tr?n th? gi?i v? TP. H? Ch? Minh.</desc>

                    <defs>
                        <pattern id="atlasDots" width="11" height="11" patternUnits="userSpaceOnUse">
                            <circle cx="2.5" cy="2.5" r="2.15" class="flower-atlas__land-dot" />
                        </pattern>
                        <filter id="routeGlow" x="-20%" y="-20%" width="140%" height="140%">
                            <feGaussianBlur stdDeviation="2.5" result="blur" />
                            <feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge>
                        </filter>
                    </defs>

                    <g class="flower-atlas__land" aria-hidden="true">
                        <path d="M57 116 88 83l68-31 91 4 53 31 44 10 23 30-29 18-12 35-29 3-23 28-44 12-28 45-35-14-9-38-31-17-17-29-47-13Z" />
                        <path d="m278 254 57 6 42 34 5 41-24 35-10 60-31 56-24-36 4-49-22-43-20-50Z" />
                        <path d="m425 120 42-35 82-9 40 20 24 29-29 15-35-5-25 21-45-8-37 15-30-16Z" />
                        <path d="m478 171 65-19 57 24 30 50-22 43-18 76-39 61-41-14-15-54-29-43 12-61-25-35Z" />
                        <path d="m593 117 45-38 101-25 100 14 79 41-8 37-57 4-33 32-52-5-34 37-55 3-43-36-52-18Z" />
                        <path d="m674 224 38 5 31 37 38 14 11 40-27 12-32-28-34-11-13-35Z" />
                        <path d="m803 354 63-23 72 28-1 54-42 32-61-10-39-38Z" />
                        <path d="m945 430 22 12 14 34-20 19-14-29-19-16Z" />
                        <path d="m387 105 15-25 27-11 17 19-18 24Z" />
                    </g>

                    <g class="flower-atlas__routes" aria-hidden="true">
                        <path class="flight-route" data-region="netherlands" style="--route-index:0" pathLength="1" d="M500 127 Q665 76 813 238" />
                        <path class="flight-route" data-region="ecuador" style="--route-index:1" pathLength="1" d="M280 300 Q535 112 813 238" />
                        <path class="flight-route" data-region="south-africa" style="--route-index:2" pathLength="1" d="M548 389 Q650 236 813 238" />
                        <path class="flight-route" data-region="china" style="--route-index:3" pathLength="1" d="M773 188 Q805 201 813 238" />
                        <path class="flight-route" data-region="japan" style="--route-index:4" pathLength="1" d="M879 174 Q835 175 813 238" />
                        <path class="flight-route" data-region="malaysia" style="--route-index:5" pathLength="1" d="M773 306 Q782 263 813 238" />
                        <path class="flight-route" data-region="vietnam" style="--route-index:6" pathLength="1" d="M798 274 Q820 259 813 238" />
                        <path class="flight-route" data-region="new-zealand" style="--route-index:7" pathLength="1" d="M957 449 Q951 303 813 238" />
                    </g>

                    <g class="hanoi-marker" aria-label="?i?m ??n TP. H? Ch? Minh">
                        <circle class="hanoi-marker__ring hanoi-marker__ring--one" cx="813" cy="238" r="13" />
                        <circle class="hanoi-marker__ring hanoi-marker__ring--two" cx="813" cy="238" r="13" />
                        <circle class="hanoi-marker__core" cx="813" cy="238" r="7" />
                        <text x="830" y="229">TP. H? Ch? Minh</text>
                    </g>

                    <g class="flower-atlas__pins">
                        @foreach($flowers as $flower)
                            <g class="map-pin" data-region="{{ $flower['id'] }}" tabindex="0" role="button" aria-label="{{ $flower['country'] }}: {{ $flower['flower'] }}" aria-pressed="false">
                                <circle class="map-pin__hit" cx="{{ $flower['x'] }}" cy="{{ $flower['y'] }}" r="20" />
                                <circle class="map-pin__halo" cx="{{ $flower['x'] }}" cy="{{ $flower['y'] }}" r="10" />
                                <circle class="map-pin__dot" cx="{{ $flower['x'] }}" cy="{{ $flower['y'] }}" r="5.5" />
                                <text x="{{ $flower['x'] }}" y="{{ $flower['y'] - 16 }}">{{ $flower['country'] }}</text>
                            </g>
                        @endforeach
                    </g>
                </svg>
            </div>

            <article class="flower-card" id="flowerCard" aria-live="polite">
                <div class="flower-card__image-wrap">
                    <img id="flowerImage" src="{{ asset('images/products/product-4.jpg') }}" alt="Hoa tulip t? H? Lan">
                    <span class="flower-card__index" id="flowerIndex">01</span>
                </div>
                <div class="flower-card__copy">
                    <p class="flower-card__country" id="flowerCountry">H? Lan</p>
                    <h2 id="flowerName">Tulip</h2>
                    <p class="flower-card__latin" id="flowerLatin">Tulipa gesneriana</p>
                    <dl>
                        <div><dt>V?ng tr?ng</dt><dd id="flowerRegion">Aalsmeer</dd></div>
                        <div><dt>To? ??</dt><dd id="flowerCoordinate">52.26?N, 4.76?E</dd></div>
                    </dl>
                </div>
            </article>

            <div class="flower-tabs" id="flowerTabs" role="tablist" aria-label="Ch?n v?ng tr?ng hoa">
                @foreach($flowers as $index => $flower)
                    <button
                        type="button"
                        role="tab"
                        id="flower-tab-{{ $flower['id'] }}"
                        data-region="{{ $flower['id'] }}"
                        data-country="{{ $flower['country'] }}"
                        data-flower="{{ $flower['flower'] }}"
                        data-latin="{{ $flower['latin'] }}"
                        data-growing-region="{{ $flower['region'] }}"
                        data-coordinate="{{ $flower['coordinate'] }}"
                        data-image="{{ asset($flower['image']) }}"
                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                    >
                        <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>{{ $flower['country'] }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</section>

<div class="container page-wrapper">
    <div class="about-layout">

        {{-- N?u c? trang "gioi-thieu" trong DB th? d?ng n?i dung ?? --}}
        @if(!empty($introPage))
            <x-markdown-renderer :content="$introPage->content" class="page-body-content" />
        @else
            {{-- Fallback: n?i dung t?nh --}}
            <div class="content-section">
                <h2>Ch?o m?ng ??n v?i {{ $siteInfo['site_name'] ?? $siteSettings['site_name'] ?? config('app.name') }}</h2>
                <p>{{ $siteInfo['about'] ?? $siteSettings['site_description'] ?? 'Ch?ng t?i ?am m? mang ??n v? ??p c?a hoa t??i v? hoa nh?p kh?u ??n m?i d?p ??c bi?t.' }}</p>
            </div>

            <div class="content-section">
                <h2>S? m?nh c?a ch?ng t?i</h2>
                <p>Cung c?p hoa cao c?p v? d?ch v? xu?t s?c ?? bi?n m?i kho?nh kh?c tr? n?n ??c bi?t.</p>
            </div>

            <div class="content-section">
                <h2>T?i sao ch?n ch?ng t?i</h2>
                <ul>
                    <li><strong>Ch?t l??ng cao c?p:</strong> Ch?ng t?i ch? l?a ch?n nh?ng b?ng hoa t??i nh?t t? nh? cung c?p uy t?n</li>
                    <li><strong>?a d?ng l?a ch?n:</strong> Kh?m ph? b? s?u t?p phong ph? cho m?i d?p</li>
                    <li><strong>Ch?m s?c chuy?n nghi?p:</strong> ??i ng? c?a ch?ng t?i ??m b?o m?i thi?t k? ??u ho?n h?o</li>
                    <li><strong>D?ch v? t?n t?m:</strong> Ch?ng t?i l?m vi?c c?ng b?n ?? t?m ra nh?ng b?ng hoa ho?n h?o</li>
                </ul>
            </div>
        @endif

        {{-- Lu?n hi?n th? c?c th? ?i?m m?nh --}}
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h3>Ch?t l??ng ??m b?o</h3>
                <p>Hoa t??i nh?p kh?u v? n?i ??a ???c ki?m so?t ch?t ch? t? kh?u ch?n h?ng ??n giao t?n tay.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                    </svg>
                </div>
                <h3>Florist chuy?n nghi?p</h3>
                <p>??i ng? ???c ??o t?o b?i b?n, am hi?u ng?n ng? hoa v? xu h??ng thi?t k? hi?n ??i.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3>Giao h?ng trong ng?y</h3>
                <p>Giao hoa t?n n?i to?n TP.HCM, ??m b?o hoa t??i v? ??p khi ??n tay ng??i nh?n.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3>T? v?n t?n t?m</h3>
                <p>H? tr? ch?n hoa ph? h?p cho t?ng d?p, phong c?ch v? ng?n s?ch ? ho?n to?n mi?n ph?.</p>
            </div>
        </div>

        {{-- Th?ng tin li?n h? --}}
        <div class="content-section contact-section">
            <h2>Li?n h? v?i ch?ng t?i</h2>
            <div class="contact-info">
                @if($siteInfo['phone'] ?? null)
                    <div class="contact-item">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <div>
                            <div class="contact-label">?i?n tho?i / Zalo</div>
                            <a href="tel:{{ $siteInfo['phone'] }}" class="contact-value">{{ $siteInfo['phone'] }}</a>
                        </div>
                    </div>
                @endif

                @if($siteInfo['email'] ?? null)
                    <div class="contact-item">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <div class="contact-label">Email</div>
                            <a href="mailto:{{ $siteInfo['email'] }}" class="contact-value">{{ $siteInfo['email'] }}</a>
                        </div>
                    </div>
                @endif

                @if($siteInfo['address'] ?? null)
                    <div class="contact-item">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div>
                            <div class="contact-label">??a ch?</div>
                            <span class="contact-value">{{ $siteInfo['address'] }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <div class="contact-cta-wrapper">
                <a href="{{ route('contact') }}" class="btn btn-primary">G?i tin nh?n cho ch?ng t?i</a>
            </div>
        </div>

    </div>
</div>


@endsection
