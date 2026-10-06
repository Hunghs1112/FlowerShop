<section class="home-flight-section" aria-labelledby="flight-board-title">
    <div class="container home-flight-layout">
        <div class="home-section-intro">
            <span class="home-eyebrow">TỪ NHỮNG VÙNG ĐẤT ĐẶC BIỆT</span>
            <h2 id="flight-board-title">Chuyến hoa hôm nay</h2>
            <p>Những mùa hoa mới đang trên đường về với Lâm Nhiên Thảo.</p>
            <a class="home-text-link" href="{{ route('products.index') }}">Xem toàn bộ bộ sưu tập <span aria-hidden="true">→</span></a>
        </div>
        <div class="lnt-chuyen-hoa" data-title="CHUYẾN HOA HÔM NAY" data-dest="HAN" data-theme="dark">
            @foreach(($newArrivalProducts ?? $bestsellingProducts)->take(4) as $index => $product)
                <p>{{ ['UIO', 'BOG', 'AMS', 'DLI'][$index] ?? 'DLI' }} | {{ $product->display_name }} · Hoa nhập khẩu | {{ $index < 2 ? 'Đã hạ cánh' : 'Đang bay' }} | {{ route('products.show', $product->display_slug) }}</p>
            @endforeach
        </div>
    </div>
</section>
