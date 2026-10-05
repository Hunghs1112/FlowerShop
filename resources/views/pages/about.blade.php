@extends('layouts.app')

@php
    $flowers = [
        ['id' => 'cn', 'country' => 'Trung Quốc', 'flower' => 'Mao lương', 'latin' => 'Ranunculus asiaticus', 'region' => 'Vân Nam', 'coord' => '24.88°N, 102.83°E', 'lat' => 24.88, 'lon' => 102.83, 'label' => [840, 148, 'end']],
        ['id' => 'nl', 'country' => 'Hà Lan', 'flower' => 'Tulip', 'latin' => 'Tulipa gesneriana', 'region' => 'Aalsmeer', 'coord' => '52.26°N, 4.76°E', 'lat' => 52.26, 'lon' => 4.76, 'label' => [597, 43, 'middle']],
        ['id' => 'ec', 'country' => 'Ecuador', 'flower' => 'Hoa hồng', 'latin' => 'Rosa hybrida', 'region' => 'Cayambe', 'coord' => '0.04°N, 78.14°W', 'lat' => 0.04, 'lon' => -78.14, 'label' => [286, 314, 'end']],
        ['id' => 'za', 'country' => 'Nam Phi', 'flower' => 'Protea vua', 'latin' => 'Protea cynaroides', 'region' => 'Western Cape', 'coord' => '33.92°S, 18.42°E', 'lat' => -33.92, 'lon' => 18.42, 'label' => [702, 453, 'start']],
        ['id' => 'jp', 'country' => 'Nhật Bản', 'flower' => 'Hoa hồng Ohara', 'latin' => 'Rosa hybrida', 'region' => 'Tokyo', 'coord' => '35.68°N, 139.69°E', 'lat' => 35.68, 'lon' => 139.69, 'label' => [1054, 123, 'start']],
        ['id' => 'my', 'country' => 'Malaysia', 'flower' => 'Cúc mẫu đơn', 'latin' => 'Chrysanthemum morifolium', 'region' => 'Cameron Highlands', 'coord' => '4.47°N, 101.38°E', 'lat' => 4.47, 'lon' => 101.38, 'label' => [842, 314, 'end']],
        ['id' => 'vn', 'country' => 'Việt Nam', 'flower' => 'Lan hồ điệp', 'latin' => 'Phalaenopsis', 'region' => 'Đà Lạt', 'coord' => '11.94°N, 108.44°E', 'lat' => 11.94, 'lon' => 108.44, 'label' => [986, 275, 'start']],
        ['id' => 'co', 'country' => 'Colombia', 'flower' => 'Hoa hồng', 'latin' => 'Rosa hybrida', 'region' => 'Bogotá', 'coord' => '4.71°N, 74.07°W', 'lat' => 4.71, 'lon' => -74.07, 'label' => [310, 220, 'end']],
        ['id' => 'nz', 'country' => 'New Zealand', 'flower' => 'Mẫu đơn', 'latin' => 'Paeonia lactiflora', 'region' => 'Canterbury', 'coord' => '43.53°S, 172.64°E', 'lat' => -43.53, 'lon' => 172.64, 'label' => [1020, 499, 'middle']],
    ];
    foreach ($flowers as &$flower) {
        [$flower['x'], $flower['y']] = \App\Support\FlowerAtlas::project($flower['lat'], $flower['lon']);
        $flower['connection'] = \App\Support\FlowerAtlas::connection($flower['lat'], $flower['lon']);
        $flower['category'] = $flowerCategories->get($flower['id']);
        $flower['category_url'] = $flower['category'] ? route('categories.show', $flower['category']->display_slug) : route('categories.index');
        $flower['image_url'] = $flower['category']?->image ? $flower['category']->image_url : null;
    }
    unset($flower);
    [$homeX, $homeY] = \App\Support\FlowerAtlas::project(21.0285, 105.8542);
@endphp

@section('title', 'Về chúng tôi · Lâm Nhiên Thảo')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/about-atlas.css') }}?v=1">
@endpush

@section('content')
<section class="about" id="aboutAtlas" aria-labelledby="aboutTitle">
    <div class="atlas-intro">
        <div class="atlas-copy">
            <a class="about-mark" href="{{ route('home') }}" aria-label="Lâm Nhiên Thảo - trang chủ">LNT<small>Lâm Nhiên Thảo</small></a>
            <h1 id="aboutTitle">Chín vùng đất,<br><em>một điểm đến</em></h1>
            <p class="lead">Lâm Nhiên Thảo tuyển chọn hoa từ những vùng trồng nổi tiếng và đưa về gần bạn. Khám phá từng vùng đất, loài hoa và bộ sưu tập tương ứng trên bản đồ.</p>
        </div>
        <div class="atlas-summary">
            <div class="stats" aria-label="Thông tin cửa hàng">
                <div><b>{{ $categories->count() }}</b><span>Danh mục</span></div>
                <div><b>{{ $categories->sum('products_count') }}</b><span>Sản phẩm</span></div>
            </div>
            <section class="passport" aria-labelledby="passportTitle">
                <h2 id="passportTitle">Hộ chiếu hoa</h2>
                <p>Mỗi vùng đất mở ra một bộ sưu tập.</p>
                <div class="pp-grid">
                    @foreach($flowers as $index => $flower)
                        <a class="stamp" href="{{ $flower['category_url'] }}" aria-label="Xem danh mục hoa từ {{ $flower['country'] }}">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</a>
                    @endforeach
                </div>
            </section>
        </div>
    </div>

    <div class="atlas-shell">
        <div class="atlas-toolbar">
            <div class="atlas-toolbar-copy"><h2>Bản đồ nguồn hoa</h2><p>Chọn một vùng trồng để khám phá.</p></div>
            <div class="atlas-controls" aria-label="Điều khiển bản đồ">
                <button type="button" data-zoom="out" aria-label="Thu nhỏ bản đồ">−</button>
                <output id="atlasZoom" aria-label="Mức phóng đại">100%</output>
                <button type="button" data-zoom="in" aria-label="Phóng to bản đồ">+</button>
                <button type="button" data-zoom="reset" class="atlas-reset">Toàn cảnh</button>
            </div>
        </div>
        <div class="atlas-viewport" id="atlasViewport" tabindex="0" aria-label="Bản đồ tương tác, cuộn để xem các vùng">
            <svg class="atlas-map" id="atlasMap" viewBox="0 0 1200 560" role="group" aria-labelledby="atlasMapTitle atlasMapDescription">
                <title id="atlasMapTitle">Chín vùng trồng hoa trên thế giới</title>
                <desc id="atlasMapDescription">Bản đồ thể hiện vị trí Vân Nam, Aalsmeer, Cayambe, Western Cape, Tokyo, Cameron Highlands, Đà Lạt, Bogotá và Canterbury. Điểm đến của hoa là Hà Nội.</desc>
                @include('partials.flower-atlas-geography')
                <g class="atlas-oceans" aria-hidden="true">
                    <text x="165" y="335">THÁI BÌNH DƯƠNG</text>
                    <text x="480" y="348" transform="rotate(-70 480 348)">ĐẠI TÂY DƯƠNG</text>
                    <text x="795" y="390">ẤN ĐỘ DƯƠNG</text>
                    <text x="1080" y="340">THÁI BÌNH DƯƠNG</text>
                </g>
                <g class="atlas-routes" aria-hidden="true">
                    @foreach($flowers as $index => $flower)
                        <path data-id="{{ $flower['id'] }}" class="atlas-route{{ $index === 0 ? ' is-selected' : '' }}" d="{{ $flower['connection'] }}" />
                    @endforeach
                </g>
                <g class="atlas-destination" aria-hidden="true">
                    <circle cx="{{ $homeX }}" cy="{{ $homeY }}" r="9" class="atlas-home-halo" />
                    <circle cx="{{ $homeX }}" cy="{{ $homeY }}" r="4" class="atlas-home-dot" />
                    <path d="M{{ $homeX + 9 }},{{ $homeY }} L975,205" />
                    <text x="982" y="209">Hà Nội<tspan x="982" dy="15">ĐIỂM ĐẾN</tspan></text>
                </g>
                @foreach($flowers as $index => $flower)
                    @php [$labelX, $labelY, $anchor] = $flower['label']; @endphp
                    <g class="atlas-pin{{ $index === 0 ? ' is-selected' : '' }}" data-id="{{ $flower['id'] }}" data-x="{{ $flower['x'] }}" data-y="{{ $flower['y'] }}" tabindex="0" role="button" aria-pressed="{{ $index === 0 ? 'true' : 'false' }}" aria-label="{{ $flower['country'] }}, {{ $flower['region'] }}, {{ $flower['coord'] }}" aria-controls="aboutCard">
                        <title>{{ $flower['region'] }}: {{ $flower['coord'] }}</title>
                        <path class="atlas-label-line" d="M{{ $flower['x'] }},{{ $flower['y'] }} L{{ $labelX }},{{ $labelY + 6 }}" />
                        <circle class="atlas-pin-hit" cx="{{ $flower['x'] }}" cy="{{ $flower['y'] }}" r="10" />
                        <circle class="atlas-pin-halo" cx="{{ $flower['x'] }}" cy="{{ $flower['y'] }}" r="9" />
                        <circle class="atlas-pin-dot" cx="{{ $flower['x'] }}" cy="{{ $flower['y'] }}" r="3.8" />
                        <text class="atlas-pin-label" x="{{ $labelX }}" y="{{ $labelY }}" text-anchor="{{ $anchor }}">{{ $flower['country'] }}<tspan x="{{ $labelX }}" dy="17">{{ $flower['region'] }}</tspan></text>
                    </g>
                @endforeach
            </svg>
        </div>
        <div class="atlas-map-footer">
            <span class="atlas-legend"><i></i> Vùng trồng hoa <i class="atlas-legend-home"></i> Hà Nội</span>
            <a href="https://www.naturalearthdata.com/" target="_blank" rel="noopener noreferrer">Bản đồ: Natural Earth</a>
        </div>
        <div class="atlas-tabs" id="aboutChips" role="tablist" aria-label="Chọn vùng trồng hoa">
            @foreach($flowers as $index => $flower)
                <button id="atlas-tab-{{ $flower['id'] }}" type="button" role="tab" data-id="{{ $flower['id'] }}" data-country="{{ $flower['country'] }}" data-flower="{{ $flower['flower'] }}" data-latin="{{ $flower['latin'] }}" data-region="{{ $flower['region'] }}" data-coord="{{ $flower['coord'] }}" data-image="{{ $flower['image_url'] }}" data-url="{{ $flower['category_url'] }}" aria-controls="aboutCard" aria-selected="{{ $index === 0 ? 'true' : 'false' }}" tabindex="{{ $index === 0 ? '0' : '-1' }}"><span>{{ $flower['country'] }}</span><small>{{ $flower['region'] }}</small></button>
            @endforeach
        </div>
        <article class="atlas-details{{ $flowers[0]['image_url'] ? ' has-image' : '' }}" id="aboutCard" role="tabpanel" aria-labelledby="atlas-tab-cn" aria-live="polite">
            <img id="cardImage" @if($flowers[0]['image_url']) src="{{ $flowers[0]['image_url'] }}" @else hidden @endif alt="Bộ sưu tập hoa từ {{ $flowers[0]['country'] }}" width="100" height="100">
            <div class="atlas-flower"><p id="cardCountry">{{ $flowers[0]['country'] }}</p><h3 id="cardFlower">{{ $flowers[0]['flower'] }}</h3><p class="atlas-latin" id="cardLatin">{{ $flowers[0]['latin'] }}</p></div>
            <div class="atlas-location"><span>Vùng trồng</span><p id="cardRegion">{{ $flowers[0]['region'] }}</p><small id="cardCoordinate">{{ $flowers[0]['coord'] }}</small></div>
            <a class="atlas-category" id="cardLink" href="{{ $flowers[0]['category_url'] }}">Khám phá hoa <span aria-hidden="true">↗</span></a>
        </article>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/about-map.js') }}?v=4" defer></script>
@endpush
