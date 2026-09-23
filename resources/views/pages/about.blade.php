@extends('layouts.app')

@section('title', 'Về chúng tôi')

@section('content')
<x-page-hero
    title="Về chúng tôi"
    description="Câu chuyện về chúng tôi và sứ mệnh mang vẻ đẹp hoa tươi đến mọi nhà"
    :breadcrumbs="[
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Về chúng tôi']
    ]"
    :image="$pageBanner['custom'] ?? $siteBanners['about'] ?? null"
    height="400px"
/>

<div class="container page-wrapper">
    <div class="about-layout">

        {{-- Nếu có trang "gioi-thieu" trong DB thì dùng nội dung đó --}}
        @if(!empty($introPage))
            <x-markdown-renderer :content="$introPage->content" class="page-body-content" />
        @else
            {{-- Fallback: nội dung tĩnh --}}
            <div class="content-section">
                <h2>Chào mừng đến với {{ $siteInfo['site_name'] ?? $siteSettings['site_name'] ?? config('app.name') }}</h2>
                <p>{{ $siteInfo['about'] ?? $siteSettings['site_description'] ?? 'Chúng tôi đam mê mang đến vẻ đẹp của hoa tươi và hoa nhập khẩu đến mọi dịp đặc biệt.' }}</p>
            </div>

            <div class="content-section">
                <h2>Sứ mệnh của chúng tôi</h2>
                <p>Cung cấp hoa cao cấp và dịch vụ xuất sắc để biến mỗi khoảnh khắc trở nên đặc biệt.</p>
            </div>

            <div class="content-section">
                <h2>Tại sao chọn chúng tôi</h2>
                <ul>
                    <li><strong>Chất lượng cao cấp:</strong> Chúng tôi chỉ lựa chọn những bông hoa tươi nhất từ nhà cung cấp uy tín</li>
                    <li><strong>Đa dạng lựa chọn:</strong> Khám phá bộ sưu tập phong phú cho mọi dịp</li>
                    <li><strong>Chăm sóc chuyên nghiệp:</strong> Đội ngũ của chúng tôi đảm bảo mỗi thiết kế đều hoàn hảo</li>
                    <li><strong>Dịch vụ tận tâm:</strong> Chúng tôi làm việc cùng bạn để tìm ra những bông hoa hoàn hảo</li>
                </ul>
            </div>
        @endif

        {{-- Luôn hiển thị các thẻ điểm mạnh --}}
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h3>Chất lượng đảm bảo</h3>
                <p>Hoa tươi nhập khẩu và nội địa được kiểm soát chặt chẽ từ khâu chọn hàng đến giao tận tay.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                    </svg>
                </div>
                <h3>Florist chuyên nghiệp</h3>
                <p>Đội ngũ được đào tạo bài bản, am hiểu ngôn ngữ hoa và xu hướng thiết kế hiện đại.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3>Giao hàng trong ngày</h3>
                <p>Giao hoa tận nơi toàn TP.HCM, đảm bảo hoa tươi và đẹp khi đến tay người nhận.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3>Tư vấn tận tâm</h3>
                <p>Hỗ trợ chọn hoa phù hợp cho từng dịp, phong cách và ngân sách — hoàn toàn miễn phí.</p>
            </div>
        </div>

        {{-- Thông tin liên hệ --}}
        <div class="content-section contact-section">
            <h2>Liên hệ với chúng tôi</h2>
            <div class="contact-info">
                @if($siteInfo['phone'] ?? null)
                    <div class="contact-item">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <div>
                            <div class="contact-label">Điện thoại / Zalo</div>
                            <a href="tel:{{ $siteInfo['phone'] }}" class="contact-value">{{ $siteInfo['phone'] }}</a>
                        </div>
                    </div>
                @endif

                @if($siteInfo['email'] ?? null)
                    <div class="contact-item">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <div class="contact-label">Email</div>
                            <a href="mailto:{{ $siteInfo['email'] }}" class="contact-value">{{ $siteInfo['email'] }}</a>
                        </div>
                    </div>
                @endif

                @if($siteInfo['address'] ?? null)
                    <div class="contact-item">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div>
                            <div class="contact-label">Địa chỉ</div>
                            <span class="contact-value">{{ $siteInfo['address'] }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <div class="contact-cta-wrapper">
                <a href="{{ route('contact') }}" class="btn btn-primary">Gửi tin nhắn cho chúng tôi</a>
            </div>
        </div>

    </div>
</div>
@endsection
