{{-- Partners Section --}}
<section class="partners-section">
    <div class="partners-container">
        {{-- Header --}}
        <div class="partners-header">
            <h2 class="partners-heading">Những nhà vườn<br>chúng tôi tin tưởng</h2>
            <p class="partners-subheading">Đồng hành cùng những nhà vườn và đối tác uy tín để mang đến những mùa hoa đẹp nhất.</p>
        </div>
        
        {{-- Logo Showcase --}}
        <div class="partners-logos">
            @foreach(['Vườn Hoa Tươi', 'Vườn Sinh Thái', 'Công Ty Hoa Nở', 'Nguồn Hoa', 'Thung Lũng Xanh'] as $partner)
            <div class="partner-logo-item">
                <div class="partner-logo-text">{{ $partner }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
