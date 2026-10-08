@php
    $contactPhone = $siteSettings['phone'] ?: '0869 308 993';
    $contactPhoneHref = preg_replace('/\D/', '', $contactPhone);
    $contactEmail = $siteSettings['email'] ?: 'support@lamnhienthao.com';
    $contactZalo = $siteSettings['zalo_url'] ?: 'https://zalo.me/' . $contactPhoneHref;
@endphp
<div class="acts"><a class="primary" href="{{ $contactZalo }}" rel="noopener" target="_blank">Zalo · {{ $contactPhone }}</a><a href="tel:{{ $contactPhoneHref }}">Gọi {{ $contactPhone }}</a><a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a><a href="{{ route('contact') }}">Trang liên hệ →</a></div>
