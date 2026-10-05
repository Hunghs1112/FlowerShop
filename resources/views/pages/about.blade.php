@extends('layouts.app')

@section('title', 'Tám vùng đất, một điểm đến')

@section('content')
<section class="origin-story" id="originStory" aria-labelledby="originStoryTitle">
    <div class="origin-story__shell">
        <header class="origin-story__intro">
            <a class="origin-monogram" href="{{ route('home') }}" aria-label="Lâm Nhiên Thảo — về trang chủ">
                <span aria-hidden="true">LNT</span>
                <small>Lâm Nhiên Thảo</small>
            </a>

            <p class="origin-story__eyebrow">Our flower atlas · 08</p>
            <h1 id="originStoryTitle">Tám vùng đất,<br><em>một điểm đến</em></h1>
            <p class="origin-story__tagline">From remarkable places, to beautiful spaces.</p>
            <p class="origin-story__lead">Lâm Nhiên Thảo tuyển chọn hoa từ những vùng trồng nổi tiếng nhất thế giới và đưa về Hà Nội. Chạm vào từng điểm trên bản đồ để khám phá hành trình của mỗi loài hoa.</p>

            <p class="origin-story__hint">
                <span aria-hidden="true"></span>
                Chọn một điểm trên bản đồ hoặc tên nước bên dưới
            </p>
        </header>

        <div class="flower-atlas">
            @php
                $flowers = [
                    ['id' => 'netherlands', 'x' => 500, 'y' => 127, 'country' => 'Hà Lan', 'flower' => 'Tulip', 'latin' => 'Tulipa gesneriana', 'region' => 'Aalsmeer', 'coordinate' => '52.26°N, 4.76°E', 'image' => 'images/products/product-4.jpg'],
                    ['id' => 'ecuador', 'x' => 280, 'y' => 300, 'country' => 'Ecuador', 'flower' => 'Hoa hồng', 'latin' => 'Rosa hybrida', 'region' => 'Cayambe', 'coordinate' => '0.04°N, 78.14°W', 'image' => 'images/products/product-1.jpg'],
                    ['id' => 'south-africa', 'x' => 548, 'y' => 389, 'country' => 'Nam Phi', 'flower' => 'Protea vua', 'latin' => 'Protea cynaroides', 'region' => 'Western Cape', 'coordinate' => '33.92°S, 18.42°E', 'image' => 'images/products/product-2.jpg'],
                    ['id' => 'china', 'x' => 773, 'y' => 188, 'country' => 'Trung Quốc', 'flower' => 'Mao lương', 'latin' => 'Ranunculus asiaticus', 'region' => 'Vân Nam', 'coordinate' => '24.88°N, 102.83°E', 'image' => 'images/instagram/flowers-2.jpg'],
                    ['id' => 'japan', 'x' => 879, 'y' => 174, 'country' => 'Nhật Bản', 'flower' => 'Cúc zinnia', 'latin' => 'Zinnia elegans', 'region' => 'Tokyo', 'coordinate' => '35.68°N, 139.69°E', 'image' => 'images/products/hoa-cam-chuong.jpg'],
                    ['id' => 'malaysia', 'x' => 773, 'y' => 306, 'country' => 'Malaysia', 'flower' => 'Cúc mẫu đơn', 'latin' => 'Chrysanthemum morifolium', 'region' => 'Cameron Highlands', 'coordinate' => '4.47°N, 101.38°E', 'image' => 'images/products/product-3.jpg'],
                    ['id' => 'vietnam', 'x' => 798, 'y' => 274, 'country' => 'Việt Nam', 'flower' => 'Lan hồ điệp', 'latin' => 'Phalaenopsis', 'region' => 'Đà Lạt', 'coordinate' => '11.94°N, 108.44°E', 'image' => 'images/instagram/flowers-6.jpg'],
                    ['id' => 'new-zealand', 'x' => 957, 'y' => 449, 'country' => 'New Zealand', 'flower' => 'Mẫu đơn', 'latin' => 'Paeonia lactiflora', 'region' => 'Canterbury', 'coordinate' => '43.53°S, 172.64°E', 'image' => 'images/products/hoa-mau-don.jpg'],
                ];
            @endphp
            <div class="flower-atlas__map">
                <svg viewBox="0 0 1000 520" role="group" aria-labelledby="flowerMapTitle flowerMapDescription">
                    <title id="flowerMapTitle">Bản đồ tám vùng hoa của Lâm Nhiên Thảo</title>
                    <desc id="flowerMapDescription">Tám đường bay kết nối các vùng trồng hoa trên thế giới về Hà Nội.</desc>

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

                    <g class="hanoi-marker" aria-label="Điểm đến Hà Nội">
                        <circle class="hanoi-marker__ring hanoi-marker__ring--one" cx="813" cy="238" r="13" />
                        <circle class="hanoi-marker__ring hanoi-marker__ring--two" cx="813" cy="238" r="13" />
                        <circle class="hanoi-marker__core" cx="813" cy="238" r="7" />
                        <text x="830" y="229">Hà Nội</text>
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
                    <img id="flowerImage" src="{{ asset('images/products/product-4.jpg') }}" alt="Hoa tulip từ Hà Lan">
                    <span class="flower-card__index" id="flowerIndex">01</span>
                </div>
                <div class="flower-card__copy">
                    <p class="flower-card__country" id="flowerCountry">Hà Lan</p>
                    <h2 id="flowerName">Tulip</h2>
                    <p class="flower-card__latin" id="flowerLatin">Tulipa gesneriana</p>
                    <dl>
                        <div><dt>Vùng trồng</dt><dd id="flowerRegion">Aalsmeer</dd></div>
                        <div><dt>Toạ độ</dt><dd id="flowerCoordinate">52.26°N, 4.76°E</dd></div>
                    </dl>
                </div>
            </article>

            <div class="flower-tabs" id="flowerTabs" role="tablist" aria-label="Chọn vùng trồng hoa">
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
@endsection

@push('scripts')
<script src="{{ asset('js/about-map.js') }}" defer></script>
@endpush
