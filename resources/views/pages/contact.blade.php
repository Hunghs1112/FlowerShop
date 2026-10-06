@extends('layouts.app')

@section('title', $contactPage->title ?? 'Liên hệ')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}?v=2">
@endpush

@section('content')
<main class="contact-reference">
    <section class="contact-reference__hero" aria-labelledby="contact-title">
        <div><p class="contact-reference__eyebrow">KẾT NỐI</p><h1 id="contact-title">Liên hệ</h1><p class="contact-reference__lead">Chúng tôi luôn sẵn lòng lắng nghe và đồng hành cùng bạn. Chọn một quầy bên cạnh, hoặc để lại lời nhắn, LNT sẽ liên hệ lại.</p></div>
        <div class="contact-reference__desk" aria-label="Quầy thông tin liên hệ">
            <div class="contact-reference__desk-head"><span>i</span><div><b>QUẦY THÔNG TIN</b><small>INFORMATION DESK</small></div></div>
            <a href="tel:{{ preg_replace('/\D/', '', $siteInfo['phone'] ?? '0869308993') }}" class="contact-reference__row"><span>◉</span><b>Gọi điện<small>{{ $siteInfo['phone'] ?? '0869 308 993' }} · tư vấn trực tiếp cùng shop</small></b><strong>→</strong></a>
            <a href="{{ $siteSettings['zalo_url'] ?? 'https://zalo.me/0869308993' }}" target="_blank" rel="noopener" class="contact-reference__row"><span>◌</span><b>Nhắn tin Zalo<small>{{ $siteInfo['phone'] ?? 'Zalo 0869 308 993' }}</small></b><strong>→</strong></a>
            <a href="mailto:{{ $siteInfo['email'] ?? 'support@lamnhienthao.com' }}" class="contact-reference__row"><span>✉</span><b>Email<small>{{ $siteInfo['email'] ?? 'support@lamnhienthao.com' }}</small></b><strong>→</strong></a>
            <a href="#contact-destination" class="contact-reference__row"><span>⌖</span><b>Ghé xưởng hoa<small>Hẹn trước qua Zalo để được đón tiếp</small></b><strong>→</strong></a>
        </div>
    </section>

    <section class="contact-reference__grid" aria-label="Gửi lời nhắn và thông tin">
        <form class="contact-reference__message" method="POST" action="{{ route('contact.store') }}">
            @csrf
            <div class="contact-reference__card-head"><span>THẺ GỬI LỜI NHẮN</span><span>LNT · HAN</span></div>
            <div class="contact-reference__card-body">
                @if(session('success'))<p class="contact-reference__success">{{ session('success') }}</p>@endif
                <div class="contact-reference__two"><label>Họ và tên *<input name="name" value="{{ old('name') }}" autocomplete="name" required></label><label>Số điện thoại / Zalo *<input name="phone" value="{{ old('phone') }}" type="tel" autocomplete="tel" required></label></div>
                <label>Email (không bắt buộc)<input name="email" value="{{ old('email') }}" type="email" autocomplete="email"></label>
                <label>Nội dung lời nhắn *<textarea name="message" required placeholder="Bạn muốn LNT hỗ trợ điều gì?">{{ old('message') }}</textarea></label>
                @error('name')<small class="contact-reference__error">{{ $message }}</small>@enderror @error('phone')<small class="contact-reference__error">{{ $message }}</small>@enderror @error('email')<small class="contact-reference__error">{{ $message }}</small>@enderror @error('message')<small class="contact-reference__error">{{ $message }}</small>@enderror
                <div class="contact-reference__send"><small>Thông tin chỉ dùng để liên hệ lại với bạn · <a href="{{ route('policy', 'chinh-sach-bao-mat') }}">Chính sách bảo mật</a></small><button class="btn btn-primary" type="submit">Gửi lời nhắn</button></div>
            </div>
        </form>

        <aside class="contact-reference__side">
            <div class="contact-reference__destination" id="contact-destination"><h2>ĐIỂM ĐẾN</h2><p><b>Lâm Nhiên Thảo</b> · Hà Nội</p><p>Địa chỉ xưởng hoa: {{ $siteInfo['address'] ?? 'Liên hệ để nhận địa chỉ' }}</p><p>Vui lòng hẹn trước qua Zalo <a href="https://zalo.me/0869308993" target="_blank" rel="noopener">0869 308 993</a> trước khi ghé.</p><p>Giao hàng: Thứ Hai – Thứ Bảy, 08:00–17:00.</p><span>21.03°N · 105.85°E</span></div>
            <div class="contact-reference__gates"><h2>CỔNG THÔNG TIN</h2><a href="{{ route('policy', 'huong-dan-dat-hang') }}"><span>A1</span>Hướng dẫn đặt hàng<span>→</span></a><a href="{{ route('policy', 'chinh-sach-giao-hang') }}"><span>A2</span>Chính sách giao hàng<span>→</span></a><a href="{{ route('policy', 'chinh-sach-doi-tra') }}"><span>A3</span>Phản hồi &amp; đổi trả<span>→</span></a><a href="{{ route('policy', 'dieu-khoan-dich-vu') }}"><span>A4</span>Điều khoản dịch vụ<span>→</span></a><a href="{{ route('policy', 'chinh-sach-bao-mat') }}"><span>A5</span>Chính sách bảo mật<span>→</span></a></div>
        </aside>
    </section>
</main>
@endsection
