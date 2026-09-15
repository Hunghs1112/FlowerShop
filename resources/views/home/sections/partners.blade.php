{{-- Partners Section --}}
<section class="partners-section">
    <div class="partners-container">
        {{-- Header --}}
        <div class="partners-header">
            <h2 class="partners-heading">Đối tác của chúng tôi</h2>
            <p class="partners-subheading">Hân hạnh được hợp tác với các thương hiệu uy tín</p>
        </div>
        
        {{-- Logo Showcase --}}
        <div class="partners-logos">
            @foreach(['Florist Pro', 'BloomBox', 'FlowerWorld', 'PetalMall', 'Fresh Blooms'] as $partner)
            <div class="partner-logo-item">
                <div class="partner-logo-text">{{ $partner }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
