{{-- Partners Section --}}
<section class="partners-section">
    <div class="partners-container">
        {{-- Header --}}
        <div class="partners-header">
            <h2 class="partners-heading">{{ __('messages.home.partners_title') }}</h2>
            <p class="partners-subheading">{{ __('messages.home.partners_subtitle') }}</p>
        </div>
        
        {{-- Logo Showcase --}}
        <div class="partners-logos">
            @foreach([__('messages.partners.partner1'), __('messages.partners.partner2'), __('messages.partners.partner3'), __('messages.partners.partner4'), __('messages.partners.partner5')] as $partner)
            <div class="partner-logo-item">
                <div class="partner-logo-text">{{ $partner }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
