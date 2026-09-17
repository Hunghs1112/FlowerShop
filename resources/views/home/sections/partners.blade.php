{{-- Partners Section --}}
<section class="partners-section">
    <div class="container">
        {{-- Header --}}
        <div class="partners-section-header">
            <span class="partners-section-label">Đối tác tin cậy</span>
            <h2 class="partners-section-title">Hợp Tác Cùng Phát Triển</h2>
        </div>
        
        {{-- Logo Showcase --}}
        <div class="partners-grid">
            @foreach(['Florist Pro', 'BloomBox', 'FlowerWorld', 'PetalMall', 'Fresh Blooms', 'GreenLeaf'] as $partner)
            <div class="partner-item">
                <span class="partner-name">{{ $partner }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>
