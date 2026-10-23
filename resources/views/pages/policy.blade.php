@extends('layouts.app')

@section('title', app()->isLocale('en') ? ($page?->title_en ?: __('legal.privacy.title')) : ($page?->title ?: __('legal.privacy.title')))

@section('skip-main-wrapper', true)

@section('content')
<main class="wrap">
<section class="hero" aria-labelledby="t"><div><img class="logo" src="{{ asset('images/brand/lnt-logo.png') }}" alt="Lâm Nhiên Thảo"><p class="eyebrow">{{ __('legal.privacy.eyebrow') }}</p><h1 id="t">{{ app()->isLocale('en') ? ($page?->title_en ?: __('legal.privacy.title')) : ($page?->title ?: __('legal.privacy.title')) }}</h1><p class="lead">{{ app()->isLocale('en') ? __('legal.privacy.intro') : ($page?->policy_intro ?: __('legal.privacy.intro')) }}</p><p class="updated">{{ __('legal.privacy.updated') }}: {{ app()->isLocale('en') ? __('legal.privacy.default_date') : ($page?->policy_updated_at_display ?: __('legal.privacy.default_date')) }}</p></div>
<div class="visual"><div><div class="pass"><div class="pm"><div class="ph">FLOWER PASS · {{ __('legal.privacy.pass_label') }}</div><div class="pf">@foreach(__('legal.privacy.fields') as $field)<button type="button" class="fld{{ $loop->last ? ' wide' : '' }}" aria-label="{{ $field['label'] }}: {{ $field['purpose'] }}"><small>{{ $field['label'] }}</small><span class="bar">{{ $field['purpose'] }}</span></button>@endforeach</div></div>
<div class="ps"><svg width="54" height="64" viewBox="0 0 54 64" aria-hidden="true"><path d="M13 28V19a14 14 0 0 1 28 0v9" fill="none" stroke="currentColor" stroke-width="6"/><rect x="4" y="27" width="46" height="35" rx="7" fill="currentColor"/><circle cx="27" cy="42" r="5" fill="var(--paper)"/><rect x="25" y="44" width="4" height="10" fill="var(--paper)"/></svg><b>{{ __('legal.privacy.protected') }}</b></div></div>
<p class="hint2">{{ __('legal.privacy.hint') }}</p></div></div></section>
@if(!app()->isLocale('en') && filled($page?->policy_content_override))
<section class="body policy-editable-content" aria-label="Policy content"><x-markdown-renderer :content="$page->policy_content_override" /></section>
@else
<div class="toolbar"><p>{{ __('legal.privacy.section_count') }}</p><button class="btn-ghost" id="toggleAll" type="button">{{ __('legal.open_all') }}</button></div>
<section class="gates" aria-label="{{ __('legal.contents') }}">
@foreach(__('legal.privacy.sections') as $index => $section)
<details class="gate" id="b{{ $index + 1 }}" @if($index === 0) open @endif><summary><span class="code">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span><h2>{{ $section['title'] }}</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body">@if(isset($section['tldr']))<p class="tldr">{{ $section['tldr'] }}</p>@endif @foreach($section['paragraphs'] ?? [] as $paragraph)<p>{{ $paragraph }}</p>@endforeach @if(isset($section['items']))<ul>@foreach($section['items'] as $item)<li>{{ $item }}</li>@endforeach</ul>@endif @if(isset($section['after']))<p>{{ $section['after'] }}</p>@endif @if($index === 5)<p>{{ __('legal.privacy.rights_contact') }} <a href="#b8">{{ __('legal.privacy.section_8') }}</a>.</p>@endif</div></details>
@endforeach
</section>
<section class="help" aria-labelledby="help-t"><div><h2 id="help-t">{{ __('legal.help') }}</h2><p>{{ __('legal.help_text') }}</p></div>
@include('partials.contact-actions')</section>
<footer class="foot"><span>© Lâm Nhiên Thảo</span><span>{{ __('legal.footer') }}</span></footer>
@endif
</main>
@endsection

@push('styles')
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;600&family=Lora:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
<style>

:root{--bg:#F5EBE6;--paper:#FCF8F5;--ink:#5E4636;--soft:#8C6E5C;--copper:#C78E66;--deep:#A8714E;--line:#E6D3C6;--board:#3A2C24;--tile:#241B16;--tile-ink:#F4E8DC;--tile-acc:#E2AE84;--shadow:rgba(120,80,55,.18);
--sans:"Josefin Sans","Avenir Next","Century Gothic",system-ui,sans-serif;--serif:"Lora",Georgia,"Times New Roman",serif;
box-sizing:border-box;padding-top:env(safe-area-inset-top,0px);padding-bottom:env(safe-area-inset-bottom,0px)}
@media (prefers-color-scheme:dark){:root:not([data-theme="light"]){--bg:#211915;--paper:#2C231F;--ink:#EEDFD4;--soft:#BFA493;--copper:#D9A47E;--deep:#E2B28E;--line:#433630;--shadow:rgba(0,0,0,.45);--board:#16100D;--tile:#0E0A08}}
:root[data-theme="dark"]{--bg:#211915;--paper:#2C231F;--ink:#EEDFD4;--soft:#BFA493;--copper:#D9A47E;--deep:#E2B28E;--line:#433630;--shadow:rgba(0,0,0,.45);--board:#16100D;--tile:#0E0A08}
html{scroll-padding-top:calc(env(safe-area-inset-top,0px) + 16px);scroll-behavior:smooth}
*,*::before,*::after{box-sizing:inherit}
body{margin:0;background:var(--bg);color:var(--ink);font-family:var(--sans);-webkit-font-smoothing:antialiased}
.wrap{max-width:1180px;margin:0 auto;padding:0 clamp(1.25rem,4vw,3rem)}
.hero{display:grid;grid-template-columns:minmax(0,4fr) minmax(0,6fr);gap:clamp(2rem,4vw,4rem);align-items:center;padding:clamp(2.5rem,6vw,5rem) 0 clamp(2rem,4vw,3rem)}
.hero>div{min-width:0}
.logo{width:88px;height:auto;display:block;margin-bottom:1.8rem}
.eyebrow{font-size:.8rem;letter-spacing:.28em;color:var(--deep);display:flex;align-items:center;gap:.9rem;margin:0 0 .9rem}
.eyebrow::after{content:"";width:64px;height:1.5px;background:currentColor}
h1{margin:0;font-weight:600;text-transform:uppercase;color:var(--copper);font-size:clamp(2rem,3.8vw,3.2rem);line-height:1.06;letter-spacing:.01em}
.lead{font-family:var(--serif);font-style:italic;color:var(--deep);font-size:clamp(1.02rem,1.35vw,1.2rem);line-height:1.65;margin:1.2rem 0 0;max-width:32em}
.updated{margin:1.1rem 0 0;font-size:.8rem;letter-spacing:.08em;color:var(--soft)}
.toolbar{display:flex;justify-content:space-between;align-items:center;gap:1rem;margin:.5rem 0 1rem;flex-wrap:wrap}
.toolbar p{margin:0;font-size:.78rem;letter-spacing:.18em;color:var(--soft)}
.btn-ghost{font:inherit;font-size:.85rem;color:var(--deep);background:transparent;border:1.5px solid var(--line);border-radius:999px;padding:.5rem 1rem;cursor:pointer}
.btn-ghost:hover{border-color:var(--copper)}.btn-ghost:focus-visible{outline:2px solid var(--deep);outline-offset:2px}
.gates{display:grid;gap:1rem;padding-bottom:2rem}
.gate{background:var(--paper);border-radius:20px;box-shadow:0 18px 40px -30px var(--shadow);border:1px solid var(--line);overflow:hidden}
.gate summary{list-style:none;display:grid;grid-template-columns:auto 1fr auto;gap:1.1rem;align-items:center;padding:1.2rem clamp(1.1rem,3vw,1.8rem);cursor:pointer}
.gate summary::-webkit-details-marker{display:none}
.gate summary:focus-visible{outline:2px solid var(--deep);outline-offset:-4px;border-radius:20px}
.code{font-weight:600;font-size:.78rem;letter-spacing:.14em;color:var(--paper);background:var(--copper);border-radius:999px;padding:.45rem .75rem .35rem;font-variant-numeric:tabular-nums;min-width:3.1rem;text-align:center}
.gate h2{margin:0;font-size:clamp(1.08rem,1.9vw,1.35rem);font-weight:600;color:var(--ink)}
.chev{width:34px;height:34px;border-radius:50%;border:1.5px solid var(--line);display:grid;place-items:center;transition:transform .3s,border-color .2s;color:var(--copper)}
.gate[open] .chev{transform:rotate(180deg);border-color:var(--copper)}
.body{margin:0 clamp(1.1rem,3vw,1.8rem);padding:0 0 1.5rem;border-top:1.5px dashed var(--line)}
.tldr{font-family:var(--serif);font-style:italic;color:var(--deep);font-size:1.04rem;margin:1.1rem 0 .7rem;padding-left:.9rem;border-left:2px solid var(--copper)}
.body p,.body li{font-family:var(--serif);color:var(--soft);line-height:1.78;font-size:1rem;max-width:70ch}
.body strong{color:var(--ink);font-weight:500}
.body h3{font-family:var(--sans);font-size:.98rem;font-weight:600;color:var(--ink);margin:1.3rem 0 .2rem;letter-spacing:.01em}
.body ul,.body ol{padding-left:1.2rem;margin:.4rem 0}
.body a{color:var(--deep);text-underline-offset:3px}
.cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:.8rem;margin:1rem 0 .4rem}
.card{border:1px solid var(--line);border-radius:14px;padding:.9rem 1rem;background:color-mix(in srgb,var(--bg) 50%,var(--paper))}
.card h3{margin:0 0 .3rem}.card p{margin:0;font-size:.95rem}
.help{display:grid;grid-template-columns:1fr auto;gap:1.5rem;align-items:center;background:var(--board);color:var(--tile-ink);border-radius:22px;padding:clamp(1.3rem,3vw,2rem);margin:1rem 0 2.5rem}
.help h2{margin:0 0 .3rem;font-size:1.3rem;font-weight:600;color:var(--tile-acc);letter-spacing:.02em}
.help p{margin:0;font-family:var(--serif);font-style:italic;color:#CDB5A2}
.help .acts{display:flex;gap:.7rem;flex-wrap:wrap}
.help a{display:inline-flex;align-items:center;gap:.5rem;text-decoration:none;font-size:.95rem;border-radius:999px;padding:.7rem 1.1rem;border:1.5px solid rgba(226,174,132,.5);color:var(--tile-ink)}
.help a.primary{background:var(--tile-acc);border-color:var(--tile-acc);color:#2A1F19;font-weight:600}
.help a:focus-visible{outline:2px solid var(--tile-acc);outline-offset:3px}
.foot{border-top:1px solid var(--line);padding:1.4rem 0 2.2rem;color:var(--soft);font-size:.85rem;display:flex;justify-content:space-between;gap:1rem;flex-wrap:wrap}
@media (max-width:900px){.hero{grid-template-columns:1fr}.help{grid-template-columns:1fr}}
@media (prefers-reduced-motion:reduce){html{scroll-behavior:auto}*{animation:none!important;transition:none!important}}
.visual{min-width:0;display:grid;place-items:center}
.pass{display:grid;grid-template-columns:1fr 150px;width:min(100%,600px);background:var(--paper);border-radius:22px;box-shadow:0 30px 60px -30px var(--shadow);border:1px solid var(--line);overflow:hidden;transform:rotate(-2deg)}
.pm{padding:0 1.4rem 1.2rem}.ps{border-left:2px dashed var(--line);display:grid;place-items:center;align-content:center;gap:.6rem;padding:1rem;text-align:center}
.ph{background:var(--board);color:var(--tile-acc);letter-spacing:.2em;font-weight:600;font-size:.82rem;padding:1rem 1.4rem;margin:0 -1.4rem 1rem}
.pf{display:grid;grid-template-columns:1fr 1fr;gap:.8rem 1rem}
.fld{all:unset;cursor:pointer;display:block;border-radius:8px}
.fld:focus-visible{outline:2px solid var(--deep);outline-offset:3px}
.fld small{display:block;font-size:.62rem;letter-spacing:.18em;color:var(--soft);margin-bottom:.3rem}
.bar{display:block;position:relative;min-height:2.3rem;border-radius:6px;overflow:hidden;font-family:var(--serif);font-style:italic;font-size:.88rem;line-height:1.3;color:var(--deep);padding:.35rem .5rem}
.bar::after{content:"";position:absolute;inset:0;background:#3E2F27;transition:transform .45s cubic-bezier(.6,.1,.2,1);transform-origin:right}
.fld:hover .bar::after,.fld:focus-visible .bar::after,.fld.on .bar::after{transform:scaleX(0)}
.wide{grid-column:1/-1}
.ps svg{color:var(--copper)}.ps b{color:var(--copper);letter-spacing:.14em;font-size:.78rem}
.hint2{margin:.9rem 0 0;font-size:.78rem;color:var(--soft);text-align:center}
@media (max-width:560px){.pass{grid-template-columns:1fr}.ps{border-left:0;border-top:2px dashed var(--line);grid-auto-flow:column}.pf{grid-template-columns:1fr}}
</style>
@endpush

@push('scripts')
<script>
(function(){const b=document.getElementById('toggleAll');if(!b)return;const g=[...document.querySelectorAll('.gate')];
function upd(){const all=g.every(d=>d.open);b.textContent=all?@json(__('legal.close_all')):@json(__('legal.open_all'));b.setAttribute('aria-expanded',all)}
b.addEventListener('click',()=>{const all=g.every(d=>d.open);g.forEach(d=>d.open=!all);upd()});g.forEach(d=>d.addEventListener('toggle',upd));upd();
if(location.hash){const t=document.querySelector(location.hash);if(t&&t.tagName==='DETAILS')t.open=true}})();
</script>
<script>document.querySelectorAll('.fld').forEach(f=>f.addEventListener('click',()=>f.classList.toggle('on')))</script>
@endpush
