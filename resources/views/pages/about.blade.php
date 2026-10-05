@extends('layouts.app')

@php
    $categoryFor = fn (string $country) => $flowerCategories->get($country);
    $flowers = [
        ['id' => 'cn', 'country' => 'Trung Quốc', 'flower' => 'Mao lương', 'latin' => 'Ranunculus asiaticus', 'region' => 'Vân Nam', 'coord' => '24.88°N, 102.83°E', 'lat' => 24.88, 'lon' => 102.83, 'image' => 'images/instagram/flowers-2.jpg', 'offset' => [-28, -22]],
        ['id' => 'nl', 'country' => 'Hà Lan', 'flower' => 'Tulip', 'latin' => 'Tulipa gesneriana', 'region' => 'Aalsmeer', 'coord' => '52.26°N, 4.76°E', 'lat' => 52.26, 'lon' => 4.76, 'image' => 'images/products/hoa-tulip.jpg'],
        ['id' => 'ec', 'country' => 'Ecuador', 'flower' => 'Hoa hồng', 'latin' => 'Rosa hybrida', 'region' => 'Cayambe', 'coord' => '0.04°N, 78.14°W', 'lat' => 0.04, 'lon' => -78.14, 'image' => 'images/products/hoa-hong-do-ecuador.jpg'],
        ['id' => 'za', 'country' => 'Nam Phi', 'flower' => 'Protea vua', 'latin' => 'Protea cynaroides', 'region' => 'Western Cape', 'coord' => '33.92°S, 18.42°E', 'lat' => -33.92, 'lon' => 18.42, 'image' => 'images/products/product-2.jpg'],
        ['id' => 'jp', 'country' => 'Nhật Bản', 'flower' => 'Hoa hồng Ohara', 'latin' => 'Rosa hybrida', 'region' => 'Tokyo', 'coord' => '35.68°N, 139.69°E', 'lat' => 35.68, 'lon' => 139.69, 'image' => 'images/products/hoa-hong-phot-ohara.jpg'],
        ['id' => 'my', 'country' => 'Malaysia', 'flower' => 'Cúc mẫu đơn', 'latin' => 'Chrysanthemum morifolium', 'region' => 'Cameron Highlands', 'coord' => '4.47°N, 101.38°E', 'lat' => 4.47, 'lon' => 101.38, 'image' => 'images/products/product-3.jpg'],
        ['id' => 'vn', 'country' => 'Việt Nam', 'flower' => 'Lan hồ điệp', 'latin' => 'Phalaenopsis', 'region' => 'Đà Lạt', 'coord' => '11.94°N, 108.44°E', 'lat' => 11.94, 'lon' => 108.44, 'image' => 'images/products/flowers-6.jpg'],
        ['id' => 'co', 'country' => 'Colombia', 'flower' => 'Hoa hồng', 'latin' => 'Rosa hybrida', 'region' => 'Bogotá', 'coord' => '4.71°N, 74.07°W', 'lat' => 4.71, 'lon' => -74.07, 'image' => 'images/products/roses.jpg', 'offset' => [28, -20]],
        ['id' => 'nz', 'country' => 'New Zealand', 'flower' => 'Mẫu đơn', 'latin' => 'Paeonia lactiflora', 'region' => 'Canterbury', 'coord' => '43.53°S, 172.64°E', 'lat' => -43.53, 'lon' => 172.64, 'image' => 'images/products/hoa-mau-don.jpg'],
    ];
    $project = fn (float $lat, float $lon) => [900 + ($lon * 5), 300 - ($lat * 4)];
    foreach ($flowers as &$flower) {
        [$flower['x'], $flower['y']] = $project($flower['lat'], $flower['lon']);
        [$flower['pinX'], $flower['pinY']] = [$flower['x'] + ($flower['offset'][0] ?? 0), $flower['y'] + ($flower['offset'][1] ?? 0)];
        $flower['category'] = $categoryFor($flower['id']);
        $flower['category_url'] = $flower['category'] ? route('categories.show', $flower['category']->display_slug) : route('categories.index');
    }
    unset($flower);
    [$homeX, $homeY] = $project(21.0285, 105.8542);
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
        <svg class="atlas-map" viewBox="0 -60 1800 670" role="group" aria-label="Bản đồ thế giới với vị trí các vùng trồng hoa">
            <image class="world-land" href="{{ asset('images/flower-atlas-land.svg') }}" x="0" y="-60" width="1800" height="670" aria-hidden="true" />
            <g class="leaders" aria-hidden="true">
                @foreach($flowers as $flower)
                    @if(isset($flower['offset']))
                        <line class="leader" data-id="{{ $flower['id'] }}" x1="{{ $flower['x'] }}" y1="{{ $flower['y'] }}" x2="{{ $flower['pinX'] }}" y2="{{ $flower['pinY'] }}" />
                    @endif
                @endforeach
            </g>
            <g class="home" id="hn" aria-label="Điểm đến Hà Nội">
                <circle class="ring" cx="{{ $homeX }}" cy="{{ $homeY }}" r="22" /><circle class="core" cx="{{ $homeX }}" cy="{{ $homeY }}" r="10" /><text x="{{ $homeX + 24 }}" y="{{ $homeY - 15 }}">Hà Nội</text>
            </g>
            @foreach($flowers as $flower)
                <g class="pin" data-id="{{ $flower['id'] }}" tabindex="0" role="button" aria-pressed="false" aria-label="{{ $flower['country'] }} — {{ $flower['region'] }}, {{ $flower['coord'] }}">
                    <circle class="hit" cx="{{ $flower['pinX'] }}" cy="{{ $flower['pinY'] }}" r="40" /><circle class="dot" cx="{{ $flower['pinX'] }}" cy="{{ $flower['pinY'] }}" r="11" /><text x="{{ $flower['pinX'] }}" y="{{ $flower['pinY'] - 25 }}">{{ $flower['country'] }}</text>
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
<script src="{{ asset('js/about-map.js') }}?v=3" defer></script>
@endpush
