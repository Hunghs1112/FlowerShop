@extends('layouts.app')

@section('title', $contactPage->title ?? 'Liên hệ')

@section('content')
<x-page-hero 
    :title="$contactPage->title ?? 'Liên hệ'"
    description="Chúng tôi luôn sẵn sàng lắng nghe bạn"
    :breadcrumbs="[
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Liên hệ']
    ]"
    :image="$pageBanner['custom'] ?? $siteBanners['contact'] ?? null"
    height="400px"
/>

<div class="container page-wrapper">
    <div class="contact-layout">
        <!-- Contact Information -->
        <div class="contact-info-wrapper">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Thông tin liên hệ</h2>
                </div>
                <div class="card-body">
                    @if($contactPage?->content)
                        <x-markdown-renderer :content="$contactPage->content" class="contact-intro markdown-content" />
                    @else
                        <p class="contact-intro">
                            Hãy liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi nào. Chúng tôi luôn sẵn sàng hỗ trợ bạn.
                        </p>
                    @endif

                    <div class="contact-methods">
                        @if($siteInfo['phone'] ?? null)
                            <div class="contact-method">
                                <div class="contact-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3>Điện thoại</h3>
                                    <p>{{ $siteInfo['phone'] }}</p>
                                </div>
                            </div>
                        @endif

                        @if($siteInfo['email'] ?? null)
                            <div class="contact-method">
                                <div class="contact-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l7.89 5.26a2 2 0 002.22 0L21 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3>Email</h3>
                                    <p>{{ $siteInfo['email'] }}</p>
                                </div>
                            </div>
                        @endif

                        @if($siteInfo['address'] ?? null)
                            <div class="contact-method">
                                <div class="contact-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1116 0z"/>
                                        <circle cx="12" cy="10" r="2.5"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3>Địa chỉ</h3>
                                    <p>{{ $siteInfo['address'] }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($siteInfo['zalo_qr'])
                        <div class="zalo-section">
                            <h3>Liên hệ qua Zalo</h3>
                            <div class="zalo-qr">
                                <img src="{{ asset('storage/' . $siteInfo['zalo_qr']) }}" alt="Mã QR Zalo">
                                <p>Quét mã để liên hệ nhanh</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
