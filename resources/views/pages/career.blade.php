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
        <p class="eyebrow" id="tocKicker">{{ __('pages.career_toc_kicker') }}</p>
        <h1 id="tocTitle"></h1>
        <p class="lead" id="tocLead"></p>
        <ol class="toc-list" id="toc"></ol>
        <a class="btn" href="#dang-ky">{{ __('pages.career_apply') }}</a>
    </aside>
</div></section>

<section class="letter"><div class="wrap narrow">
    <p class="eyebrow center-e">{{ __('pages.career_letter') }}</p>
    <div class="letter-body" id="letter"></div>
    <p class="sign" id="sign"></p>
</div></section>

<div id="features"></div>

<section class="sec soft"><div class="wrap">
    <p class="eyebrow">{{ __('pages.career_schedule') }}</p>
    <h2>{{ __('pages.career_process') }}</h2>
    <ol class="sched" id="steps"></ol>
</div></section>

<section class="sec" id="dang-ky"><div class="wrap sub-grid">
    <div>
        <p class="eyebrow">{{ __('pages.career_form') }}</p>
        <h2 class="big">{{ explode('|', __('pages.career_next_issue'))[0] }}<br><em>{{ explode('|', __('pages.career_next_issue'))[1] }}</em></h2>
        <p class="muted" id="subLead"></p>
        <ul class="contact" id="contact"></ul>
    </div>
    <form class="coupon" id="sform" novalidate>
        <span class="scissors" aria-hidden="true">✂</span>
        <div class="cp-head"><b id="cpMast"></b><span>{{ __('pages.career_form') }}</span></div>
        <label class="fld"><span>{{ __('pages.career_position') }}</span><select id="sPos" required></select></label>
        <div class="two"><label class="fld"><span>{{ __('pages.career_name') }}</span><input id="sName" autocomplete="name" required></label>
        <label class="fld"><span>{{ __('pages.career_birth_year') }}</span><input id="sYear" inputmode="numeric" maxlength="4"></label></div>
        <div class="two"><label class="fld"><span>{{ __('pages.career_phone') }}</span><input id="sPhone" type="tel" autocomplete="tel" required></label>
        <label class="fld"><span>{{ __('pages.career_email') }}</span><input id="sEmail" type="email" autocomplete="email" required></label></div>
        <label class="fld"><span>{{ __('pages.career_portfolio') }}</span><input id="sCv" type="url" placeholder="https://"></label>
        <label class="fld"><span>{{ __('pages.career_about_you') }}</span><textarea id="sNote" rows="3"></textarea></label>
        <p class="err" id="serr" role="alert" hidden></p>
        <div class="cp-foot"><p class="hint" id="shint"></p><button class="btn" type="submit">{{ __('pages.career_send') }}</button></div>
        <div class="cp-done" id="done" hidden><small>{{ __('pages.career_received') }}</small><b>{{ __('pages.career_thank_you') }}</b><p id="doneTxt"></p><button type="button" class="btn ghost" id="again">{{ __('pages.career_send_another') }}</button></div>
    </form>
</div></section>
</main>
@endsection

@push('scripts')
@php($careerConfig = [...$config, 'endpoint' => localized_route('career.store'), 'csrfToken' => csrf_token(), 'strings' => __('pages.career_js')])
<script>window.CAREER_CONFIG = @json($careerConfig);</script>
<script src="{{ asset('js/careers.js') }}?v={{ filemtime(public_path('js/careers.js')) }}"></script>
@endpush
