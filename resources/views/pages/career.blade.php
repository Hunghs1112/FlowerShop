@extends('layouts.app')

@section('title', $page->display_title)
@section('body-class', 'career-theme')
@section('skip-main-wrapper', true)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/careers.css') }}?v={{ filemtime(public_path('css/careers.css')) }}">
@endpush

@section('content')
<main class="career-page">
<section class="cover-sec"><div class="wrap cover-grid">
    <figure class="cover">
        <img id="cvImg" alt="">
        <div class="cv-top"><b id="cvMast"></b><span id="cvIssue"></span></div>
        <div class="cv-lines" id="cvLines"></div>
        <div class="cv-barcode" aria-hidden="true"><i></i><span id="cvNo"></span></div>
    </figure>
    <aside class="toc">
        <p class="eyebrow" id="tocKicker">TRONG SỐ NÀY</p>
        <h1 id="tocTitle"></h1>
        <p class="lead" id="tocLead"></p>
        <ol class="toc-list" id="toc"></ol>
        <a class="btn" href="#dang-ky">Đăng ký ứng tuyển</a>
    </aside>
</div></section>

<section class="letter"><div class="wrap narrow">
    <p class="eyebrow center-e">THƯ TOÀ SOẠN</p>
    <div class="letter-body" id="letter"></div>
    <p class="sign" id="sign"></p>
</div></section>

<div id="features"></div>

<section class="sec soft"><div class="wrap">
    <p class="eyebrow">LỊCH PHÁT HÀNH</p>
    <h2>Quy trình ứng tuyển</h2>
    <ol class="sched" id="steps"></ol>
</div></section>

<section class="sec" id="dang-ky"><div class="wrap sub-grid">
    <div>
        <p class="eyebrow">PHIẾU ĐĂNG KÝ</p>
        <h2 class="big">Góp mặt trong<br><em>số tiếp theo</em></h2>
        <p class="muted" id="subLead"></p>
        <ul class="contact" id="contact"></ul>
    </div>
    <form class="coupon" id="sform" novalidate>
        <span class="scissors" aria-hidden="true">✂</span>
        <div class="cp-head"><b id="cpMast"></b><span>PHIẾU ĐĂNG KÝ ỨNG TUYỂN</span></div>
        <label class="fld"><span>Vị trí *</span><select id="sPos" required></select></label>
        <div class="two"><label class="fld"><span>Họ và tên *</span><input id="sName" autocomplete="name" required></label>
        <label class="fld"><span>Năm sinh</span><input id="sYear" inputmode="numeric" maxlength="4"></label></div>
        <div class="two"><label class="fld"><span>Số điện thoại / Zalo *</span><input id="sPhone" type="tel" autocomplete="tel" required></label>
        <label class="fld"><span>Email *</span><input id="sEmail" type="email" autocomplete="email" required></label></div>
        <label class="fld"><span>Link CV / portfolio</span><input id="sCv" type="url" placeholder="https://"></label>
        <label class="fld"><span>Đôi dòng về bạn</span><textarea id="sNote" rows="3"></textarea></label>
        <p class="err" id="serr" role="alert" hidden></p>
        <div class="cp-foot"><p class="hint" id="shint"></p><button class="btn" type="submit">Gửi phiếu →</button></div>
        <div class="cp-done" id="done" hidden><small>ĐÃ NHẬN PHIẾU</small><b>Cảm ơn bạn</b><p id="doneTxt"></p><button type="button" class="btn ghost" id="again">Gửi phiếu khác</button></div>
    </form>
</div></section>
</main>
@endsection

@push('scripts')
<script>window.CAREER_CONFIG = @json([...$config, 'endpoint' => localized_route('career.store'), 'csrfToken' => csrf_token()]);</script>
<script src="{{ asset('js/careers.js') }}?v={{ filemtime(public_path('js/careers.js')) }}"></script>
@endpush
