@extends('pages.policy')

@php
    $isEnglish = app()->isLocale('en');
    $title = $isEnglish ? ($page?->title_en ?: __('pages.enterprise.title')) : ($page?->title ?: __('pages.enterprise.title'));
    $intro = $isEnglish ? __('pages.enterprise.intro') : ($page?->policy_intro ?: __('pages.enterprise.intro'));
    $updated = $isEnglish ? __('pages.enterprise.updated') : ($page?->policy_updated_at_display ?: __('pages.enterprise.updated'));
    $override = $isEnglish ? $page?->policy_content_override_en : $page?->policy_content_override;
    $sections = __('pages.enterprise.sections');
@endphp

@section('title', $title)

@section('content')
<main class="wrap">
    <section class="hero">
        <div>
            <img class="logo" src="{{ asset('images/brand/policy-enterprise-logo.png') }}" alt="Lâm Nhiên Thảo">
            <p class="eyebrow">{{ __('pages.enterprise.eyebrow') }}</p>
            <h1 id="t">{!! nl2br(e($title)) !!}</h1>
            <p class="lead">{{ $intro }}</p>
            <p class="updated">{{ $updated }}</p>
        </div>
        <div class="visual">
            <img class="bb" src="{{ asset('images/pages/policy-enterprise-bloom.jpg') }}" alt="" aria-hidden="true">
            <div class="trk" role="img" aria-label="{{ __('pages.enterprise.track_aria') }}">
                <div class="th"><span>{{ __('pages.enterprise.track_title') }}</span><span>LNT·B2B</span></div>
                <div class="tt">{{ __('pages.enterprise.track_status') }}</div>
                <div class="route"><div><b>{{ __('pages.enterprise.origin') }}</b><small>{{ __('pages.enterprise.origin_name') }}</small></div><div class="r"><b>{{ __('pages.enterprise.destination') }}</b><small>{{ __('pages.enterprise.destination_name') }}</small></div></div>
                <div class="prog"><i></i></div>
                <ol class="steps">
                    @foreach(__('pages.enterprise.steps') as $index => $step)
                        <li data-i="{{ $index }}">{{ $step }}</li>
                    @endforeach
                </ol>
                <div class="facts">
                    @foreach(__('pages.enterprise.facts') as $fact)
                        <span>{{ $fact }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @if(filled($override))
        <section class="body policy-editable-content" aria-label="{{ __('pages.enterprise.content_label') }}"><x-markdown-renderer :content="$override" /></section>
    @else
        <div class="toolbar"><p>{{ __('pages.enterprise.sections_label') }}</p><button class="btn-ghost" id="toggleAll" type="button">{{ __('pages.enterprise.toggle_open') }}</button></div>
        <section class="gates" aria-label="{{ __('pages.enterprise.content_label') }}">
            @foreach($sections as $index => $section)
                <details class="gate" id="b{{ $index + 1 }}" @if($index === 0) open @endif>
                    <summary><span class="code">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span><h2>{{ $section['title'] }}</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary>
                    <div class="body">
                        @if(isset($section['summary']))<p class="tldr">{{ $section['summary'] }}</p>@endif
                        {!! str_replace([':delivery_url', ':b2b_url'], [localized_route('policy.delivery'), localized_route('b2c')], $section['body']) !!}
                    </div>
                </details>
            @endforeach
        </section>
    @endif

    <section class="help" aria-labelledby="help-t"><div><h2 id="help-t">{{ __('pages.enterprise.help') }}</h2><p>{{ __('pages.enterprise.help_text') }}</p></div>@include('partials.contact-actions')</section>
    <footer class="foot"><span>© Lâm Nhiên Thảo</span><span>{{ __('pages.enterprise.footer') }}</span></footer>
</main>
@endsection

@push('styles')
<style>
.visual{min-width:0;position:relative;display:grid;place-items:center}.trk{position:relative;z-index:1;width:min(100%,600px);background:var(--paper);border-radius:24px;box-shadow:0 30px 60px -30px var(--shadow);border:1px solid var(--line);padding:1.4rem 1.6rem 1.3rem}.th{display:flex;justify-content:space-between;font-size:.74rem;letter-spacing:.2em;color:var(--copper);font-weight:600}.th span:last-child{color:var(--soft)}.tt{font-family:var(--serif);font-size:1.45rem;color:var(--ink);margin:.4rem 0 1.3rem}.route{display:flex;justify-content:space-between;align-items:end;margin-bottom:1.2rem}.route b{font-size:2rem;color:var(--copper);font-weight:600;line-height:1}.route small{display:block;font-family:var(--serif);font-style:italic;color:var(--deep);font-size:.85rem;margin-top:.3rem}.route .r{text-align:right}.prog{position:relative;height:6px;border-radius:6px;background:var(--line);margin:0 12px}.prog i{position:absolute;inset:0 auto 0 0;width:0;background:var(--copper);border-radius:6px;animation:fill 3.2s .4s cubic-bezier(.5,0,.2,1) forwards}@keyframes fill{to{width:100%}}.steps{display:grid;grid-template-columns:repeat(5,1fr);margin-top:-15px;position:relative}.steps li{list-style:none;text-align:center;font-size:.72rem;color:var(--soft);line-height:1.3}.steps li::before{content:"";display:block;width:22px;height:22px;margin:0 auto .55rem;border-radius:50%;background:var(--paper);border:3px solid var(--copper);transition:background .3s}.steps li.done::before{background:var(--copper)}.facts{display:flex;flex-wrap:wrap;gap:.5rem;margin-top:1.2rem;border-top:1.5px dashed var(--line);padding-top:1rem}.facts span{font-size:.8rem;color:var(--deep);border:1.5px solid var(--line);border-radius:999px;padding:.38rem .75rem}.bb{position:absolute;right:-20px;top:-50px;width:clamp(110px,13vw,160px);aspect-ratio:1;border-radius:50%;object-fit:cover;box-shadow:0 0 0 6px var(--bg),0 0 0 7.5px var(--copper)}.steps ol{display:contents}.policy-editable-content{background:var(--paper);border:1px solid var(--line);border-radius:20px;padding-top:1rem;margin-bottom:2rem}.policy-editable-content .body{border-top:0}.policy-editable-content p:first-child{margin-top:.2rem}@media (max-width:900px){.bb{display:none}}@media (max-width:520px){.steps li{font-size:.62rem}}
</style>
@endpush

@push('scripts')
<script>
(function(){const b=document.getElementById('toggleAll');if(!b)return;const g=[...document.querySelectorAll('.gate')];const open='{{ __('pages.enterprise.toggle_close') }}',close='{{ __('pages.enterprise.toggle_open') }}';function upd(){const all=g.length&&g.every(d=>d.open);b.textContent=all?open:close;b.setAttribute('aria-expanded',all)}b.addEventListener('click',()=>{const all=g.every(d=>d.open);g.forEach(d=>d.open=!all);upd()});g.forEach(d=>d.addEventListener('toggle',upd));upd();if(location.hash){const t=document.querySelector(location.hash);if(t&&t.tagName==='DETAILS')t.open=true}})();
</script>
<script>(function(){const li=[...document.querySelectorAll('.steps li')];const reduce=matchMedia('(prefers-reduced-motion: reduce)').matches;li.forEach((item,index)=>{if(reduce){item.classList.add('done');return}setTimeout(()=>item.classList.add('done'),400+index*780)})})();</script>
@endpush
