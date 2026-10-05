@extends('layouts.app')

@php
    $categoryFor = fn (string $country) => $flowerCategories->get($country);
    $flowers = [
        ['id' => 'cn', 'country' => 'Trung Quốc', 'flower' => 'Mao lương', 'latin' => 'Ranunculus asiaticus', 'region' => 'Vân Nam', 'coord' => '24.88°N, 102.83°E', 'image' => 'images/instagram/flowers-2.jpg'],
        ['id' => 'nl', 'country' => 'Hà Lan', 'flower' => 'Tulip', 'latin' => 'Tulipa gesneriana', 'region' => 'Aalsmeer', 'coord' => '52.26°N, 4.76°E', 'image' => 'images/products/hoa-tulip.jpg'],
        ['id' => 'ec', 'country' => 'Ecuador', 'flower' => 'Hoa hồng', 'latin' => 'Rosa hybrida', 'region' => 'Cayambe', 'coord' => '0.04°N, 78.14°W', 'image' => 'images/products/hoa-hong-do-ecuador.jpg'],
        ['id' => 'za', 'country' => 'Nam Phi', 'flower' => 'Protea vua', 'latin' => 'Protea cynaroides', 'region' => 'Western Cape', 'coord' => '33.92°S, 18.42°E', 'image' => 'images/products/product-2.jpg'],
        ['id' => 'jp', 'country' => 'Nhật Bản', 'flower' => 'Hoa hồng Ohara', 'latin' => 'Rosa hybrida', 'region' => 'Tokyo', 'coord' => '35.68°N, 139.69°E', 'image' => 'images/products/hoa-hong-phot-ohara.jpg'],
        ['id' => 'my', 'country' => 'Malaysia', 'flower' => 'Cúc mẫu đơn', 'latin' => 'Chrysanthemum morifolium', 'region' => 'Cameron Highlands', 'coord' => '4.47°N, 101.38°E', 'image' => 'images/products/product-3.jpg'],
        ['id' => 'vn', 'country' => 'Việt Nam', 'flower' => 'Lan hồ điệp', 'latin' => 'Phalaenopsis', 'region' => 'Đà Lạt', 'coord' => '11.94°N, 108.44°E', 'image' => 'images/products/flowers-6.jpg'],
        ['id' => 'co', 'country' => 'Colombia', 'flower' => 'Hoa hồng', 'latin' => 'Rosa hybrida', 'region' => 'Bogotá', 'coord' => '4.71°N, 74.07°W', 'image' => 'images/products/roses.jpg'],
        ['id' => 'nz', 'country' => 'New Zealand', 'flower' => 'Mẫu đơn', 'latin' => 'Paeonia lactiflora', 'region' => 'Canterbury', 'coord' => '43.53°S, 172.64°E', 'image' => 'images/products/hoa-mau-don.jpg'],
    ];
    foreach ($flowers as &$flower) {
        $flower['category'] = $categoryFor($flower['id']);
        $flower['category_url'] = $flower['category'] ? route('categories.show', $flower['category']->display_slug) : route('categories.index');
    }
    unset($flower);
@endphp

@section('title', 'Về chúng tôi · Lâm Nhiên Thảo')

@section('content')
<section class="about" id="aboutAtlas" aria-labelledby="aboutTitle">
    <div class="intro">
        <a class="about-mark" href="{{ route('home') }}" aria-label="Lâm Nhiên Thảo — trang chủ">LNT<small>Lâm Nhiên Thảo</small></a>
        <p class="eyebrow">Our flower atlas · {{ str_pad(count($flowers), 2, '0', STR_PAD_LEFT) }}</p>
        <h1 id="aboutTitle">Chín vùng đất,<br><em>một điểm đến</em></h1>
        <p class="tag">From remarkable places, to beautiful spaces.</p>
        <p class="lead">Lâm Nhiên Thảo tuyển chọn hoa từ những vùng trồng nổi tiếng và đưa về gần bạn. Chạm vào từng điểm trên bản đồ để khám phá loài hoa, vùng trồng và danh mục tương ứng trong cửa hàng.</p>
        <p class="hint">Chọn một điểm trên bản đồ hoặc tên vùng bên dưới</p>

        <div class="stats" aria-label="Thông tin cửa hàng">
            <div><b>{{ $categories->count() }}</b><span>Danh mục</span></div>
            <div><b>{{ $categories->sum('products_count') }}</b><span>Sản phẩm</span></div>
        </div>

        <section class="passport" aria-labelledby="passportTitle">
            <div class="pp-head"><span id="passportTitle">HỘ CHIẾU HOA</span><span>{{ count($flowers) }} vùng</span></div>
            <p class="pp-sub">Khám phá các bộ sưu tập hoa theo nguồn gốc và nhu cầu của bạn.</p>
            <div class="pp-grid">
                @foreach($flowers as $index => $flower)
                    <a class="stamp" href="{{ $flower['category_url'] }}" title="Xem danh mục {{ $flower['category']?->display_name ?? 'hoa' }}">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</a>
                @endforeach
            </div>
            <p class="pp-tip">Mỗi dấu mở ra một danh mục hoa đang có trong cửa hàng.</p>
        </section>
    </div>

    <div class="map-wrap">
        <svg viewBox="0 0 1000 520" role="group" aria-label="Bản đồ các vùng hoa của Lâm Nhiên Thảo">
            <g class="land" aria-hidden="true">
                <path d="M57 116 88 83l68-31 91 4 53 31 44 10 23 30-29 18-12 35-29 3-23 28-44 12-28 45-35-14-9-38-31-17-17-29-47-13Z" />
                <path d="m278 254 57 6 42 34 5 41-24 35-10 60-31 56-24-36 4-49-22-43-20-50Z" />
                <path d="m593 117 45-38 101-25 100 14 79 41-8 37-57 4-33 32-52-5-34 37-55 3-43-36-52-18Z" />
                <path d="m803 354 63-23 72 28-1 54-42 32-61-10-39-38Z" />
            </g>
            <g class="arcs" aria-hidden="true">
                @foreach($flowers as $index => $flower)
                    <path class="arc" data-id="{{ $flower['id'] }}" style="--d: {{ $index * .12 }}s" pathLength="1" d="M{{ 100 + ($index * 86) }} {{ 70 + (($index * 31) % 300) }} Q{{ 520 + (($index * 13) % 100) }} {{ 100 + (($index * 17) % 170) }} 805 238" />
                @endforeach
            </g>
            <g class="home" id="hn" aria-label="Điểm đến Hà Nội">
                <circle class="ring" cx="805" cy="238" r="13" /><circle class="core" cx="805" cy="238" r="7" /><text x="824" y="229">Hà Nội</text>
            </g>
            @foreach($flowers as $index => $flower)
                @php $x = 100 + ($index * 86); $y = 70 + (($index * 31) % 300); @endphp
                <g class="pin" data-id="{{ $flower['id'] }}" tabindex="0" role="button" aria-pressed="false" aria-label="{{ $flower['country'] }}: {{ $flower['flower'] }}">
                    <circle class="hit" cx="{{ $x }}" cy="{{ $y }}" r="24" /><circle class="dot" cx="{{ $x }}" cy="{{ $y }}" r="7" /><text x="{{ $x }}" y="{{ $y - 17 }}">{{ $flower['country'] }}</text>
                </g>
            @endforeach
        </svg>

        <article class="card" id="aboutCard" aria-live="polite">
            <img id="cardImage" src="{{ asset($flowers[0]['image']) }}" alt="{{ $flowers[0]['flower'] }} từ {{ $flowers[0]['country'] }}">
            <div><p class="card-country" id="cardCountry">{{ $flowers[0]['country'] }}</p><h2 id="cardFlower">{{ $flowers[0]['flower'] }}</h2><p class="card-latin" id="cardLatin">{{ $flowers[0]['latin'] }}</p><p class="card-region" id="cardRegion">{{ $flowers[0]['region'] }} · {{ $flowers[0]['coord'] }}</p><a id="cardLink" href="{{ $flowers[0]['category_url'] }}">Xem danh mục tương ứng →</a></div>
        </article>

        <div class="chips" id="aboutChips" role="tablist" aria-label="Chọn vùng trồng hoa">
            @foreach($flowers as $index => $flower)
                <button type="button" role="tab" data-id="{{ $flower['id'] }}" data-country="{{ $flower['country'] }}" data-flower="{{ $flower['flower'] }}" data-latin="{{ $flower['latin'] }}" data-region="{{ $flower['region'] }}" data-coord="{{ $flower['coord'] }}" data-image="{{ asset($flower['image']) }}" data-url="{{ $flower['category_url'] }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">{{ $flower['country'] }}</button>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/about-map.js') }}?v=2" defer></script>
@endpush
