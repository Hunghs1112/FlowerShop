<section class="home-origin-section" aria-labelledby="origin-title">
    <div class="container">
        <div class="home-origin-header">
            <span class="home-eyebrow">MỖI BÔNG HOA MỘT HÀNH TRÌNH</span>
            <h2 id="origin-title">Chín vùng đất, một điểm đến</h2>
            <p>Từ những nông trại xa xôi đến căn phòng của bạn tại Hà Nội.</p>
        </div>
        <div class="home-origin-grid">
            <div class="home-origin-map" aria-hidden="true">
                <span class="home-origin-orbit home-origin-orbit--one"></span>
                <span class="home-origin-orbit home-origin-orbit--two"></span>
                <span class="home-origin-pin home-origin-pin--ecuador">UIO</span>
                <span class="home-origin-pin home-origin-pin--colombia">BOG</span>
                <span class="home-origin-pin home-origin-pin--vietnam">HAN</span>
            </div>
            <div class="home-origin-list">
                @foreach($categories->take(9) as $index => $category)
                    <a href="{{ route('products.index', ['categories' => [$category->id]]) }}" class="home-origin-item">
                        <span class="home-origin-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span>{{ $category->display_name }}</span>
                        <span aria-hidden="true">↗</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
