@extends('layouts.app')

@section('title', 'Liên hệ')

@section('skip-main-wrapper', true)

@section('content')
@php
    $contactPhone = $siteInfo['phone'] ?: '0869 308 993';
    $contactPhoneHref = preg_replace('/\D/', '', $contactPhone);
    $contactEmail = $siteInfo['email'] ?: 'support@lamnhienthao.com';
    $contactZalo = $siteInfo['zalo_url'] ?: 'https://zalo.me/' . $contactPhoneHref;
    $contactAddress = $siteInfo['address'] ?: 'Hà Nội';
    $businessHours = $siteInfo['business_hours'] ?: 'Thứ Hai – Thứ Bảy, 08:00–17:00';
@endphp
<main class="wrap">
<section class="hero" aria-labelledby="t"><div><img class="logo" src="{{ asset('images/brand/lnt-logo.png') }}" alt="Lâm Nhiên Thảo"><p class="eyebrow">KẾT NỐI</p><h1 id="t">Liên hệ</h1>
<p class="lead">Chúng tôi luôn sẵn lòng lắng nghe và đồng hành cùng bạn. Chọn một quầy bên cạnh, hoặc để lại lời nhắn, LNT sẽ liên hệ lại.</p></div>
<div class="visual"><img class="bloom" src="{{ asset('images/pages/contact-bloom.jpg') }}" alt=""><div class="desk"><div class="dh"><i aria-hidden="true">i</i><div><b>QUẦY THÔNG TIN</b><small>INFORMATION DESK</small></div></div>
<a class="row" href="tel:{{ $contactPhoneHref }}"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="#3A2C24" stroke-width="2"><rect x="7" y="2.5" width="10" height="19" rx="2.5"/><path d="M10.5 18.5h3"/></svg></span><span><b>Gọi điện</b><span class="t">{{ $contactPhone }} · tư vấn trực tiếp cùng shop</span></span><span class="ar" aria-hidden="true">→</span></a>
<a class="row" href="{{ $contactZalo }}" target="_blank" rel="noopener"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="#3A2C24" stroke-width="2"><path d="M4 5h16v11H9l-5 4z" stroke-linejoin="round"/></svg></span><span><b>Nhắn tin Zalo</b><span class="t">Zalo {{ $contactPhone }}</span></span><span class="ar" aria-hidden="true">→</span></a>
<a class="row" href="mailto:{{ $contactEmail }}"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="#3A2C24" stroke-width="2"><rect x="3" y="5.5" width="18" height="13" rx="2"/><path d="M3.5 6.5l8.5 6.5 8.5-6.5"/></svg></span><span><b>Email</b><span class="t">{{ $contactEmail }}</span></span><span class="ar" aria-hidden="true">→</span></a>
<a class="row" href="#diem-den"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="#3A2C24" stroke-width="2"><path d="M12 21s7-6.1 7-11.5A7 7 0 0 0 5 9.5C5 14.9 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg></span><span><b>Ghé xưởng hoa</b><span class="t">Hẹn trước qua Zalo để được đón tiếp</span></span><span class="ar" aria-hidden="true">→</span></a></div></div></section>
<section class="grid2" aria-label="Gửi lời nhắn và thông tin">
<form class="msg" id="form" action="{{ route('contact.store') }}" method="post" novalidate>@csrf<div class="mh"><span>THẺ GỬI LỜI NHẮN</span><span>LNT · HAN</span></div>
<div class="mb" id="fbody">
<div class="two"><label>Họ và tên *<input id="f_name" name="name" autocomplete="name" required></label><label>Số điện thoại / Zalo *<input id="f_phone" name="phone" type="tel" autocomplete="tel" required></label></div>
<label>Email (không bắt buộc)<input id="f_email" name="email" type="email" autocomplete="email"></label>
<div><label style="margin-bottom:.4rem">Bạn cần hỗ trợ về</label><div class="chips" id="topics" role="group" aria-label="Chủ đề"><button type="button" class="chip" aria-pressed="true">Đặt hoa</button><button type="button" class="chip" aria-pressed="false">Hộp hoa bí ẩn</button><button type="button" class="chip" aria-pressed="false">Giao hàng</button><button type="button" class="chip" aria-pressed="false">Phản hồi đơn hàng</button><button type="button" class="chip" aria-pressed="false">Hợp tác B2B</button><button type="button" class="chip" aria-pressed="false">Khác</button></div></div>
<label>Lời nhắn *<textarea id="f_msg" name="message" required placeholder="Bạn muốn LNT hỗ trợ điều gì?"></textarea></label>
<p class="err" id="err" aria-live="polite"></p>
<div class="send"><small>Thông tin chỉ dùng để liên hệ lại với bạn · <a href="{{ route('policy.baomat') }}">Chính sách bảo mật</a></small><button class="btn" type="submit">Gửi lời nhắn</button></div></div>
<div class="ok" id="ok" role="status"><div class="seal">LNT</div><h3>LỜI NHẮN ĐÃ CẤT CÁNH</h3><p id="okText">Lâm Nhiên Thảo sẽ liên hệ lại với bạn qua Zalo hoặc điện thoại.</p></div></form>
<div class="side">
<div class="dest" id="diem-den"><h2>ĐIỂM ĐẾN</h2><p><b>{{ $siteInfo['site_name'] ?: 'Lâm Nhiên Thảo' }}</b></p><p>Địa chỉ xưởng hoa: <span class="ph">{{ $contactAddress }}</span></p><p>Vui lòng hẹn trước qua Zalo <a href="{{ $contactZalo }}" target="_blank" rel="noopener">{{ $contactPhone }}</a> trước khi ghé.</p><p>Giao hàng: {{ $businessHours }}.</p></div>
<div class="gates2"><h2>CỔNG THÔNG TIN</h2><div class="gl">
<a href="{{ route('guide') }}"><span>A1</span>Hướng dẫn đặt hàng<span>→</span></a>
<a href="{{ route('policy.delivery') }}"><span>A2</span>Chính sách giao hàng<span>→</span></a>
<a href="{{ route('policy', 'chinh-sach-doi-tra') }}"><span>A3</span>Phản hồi &amp; đổi trả<span>→</span></a>
<a href="{{ route('policy.terms') }}"><span>A4</span>Điều khoản dịch vụ<span>→</span></a>
<a href="{{ route('policy.baomat') }}"><span>A5</span>Chính sách bảo mật<span>→</span></a></div></div>
</div></section>
<footer class="foot"><span>© Lâm Nhiên Thảo</span><span>Từ những vùng đất đặc biệt đến những nơi tuyệt đẹp</span></footer>
</main>
@endsection

@push('styles')
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
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

.visual{min-width:0;position:relative;display:grid;place-items:center}
.desk{position:relative;z-index:1;width:min(100%,560px);background:var(--board);color:var(--tile-ink);border-radius:24px;padding:1.3rem 1.3rem 1rem;box-shadow:0 30px 60px -30px var(--shadow)}
.desk::before{content:"";position:absolute;inset:8px;border:1.5px solid rgba(226,174,132,.25);border-radius:18px;pointer-events:none}
.dh{display:flex;align-items:center;gap:.9rem;margin:.2rem .3rem 1rem}
.dh i{width:46px;height:46px;border-radius:50%;background:var(--tile-acc);color:#3A2C24;display:grid;place-items:center;font-family:var(--serif);font-style:normal;font-size:1.6rem;font-weight:500}
.dh b{display:block;letter-spacing:.2em;font-size:.95rem;color:var(--tile-acc)}.dh small{display:block;letter-spacing:.18em;font-size:.66rem;color:#BFA493;margin-top:.2rem}
.row{position:relative;display:grid;grid-template-columns:52px 1fr auto;gap:1rem;align-items:center;padding:.85rem .6rem;border-top:1.5px solid rgba(226,174,132,.16);text-decoration:none;color:inherit;border-radius:12px}
.row:hover,.row:focus-visible{background:rgba(226,174,132,.08);outline:none}.row:focus-visible{box-shadow:0 0 0 2px var(--tile-acc)}
.ic{width:52px;height:52px;border-radius:12px;background:var(--tile-acc);display:grid;place-items:center}
.ic svg{width:26px;height:26px}
.row b{display:block;font-size:1.12rem;color:#F4E8DC}.row span.t{display:block;font-family:var(--serif);font-style:italic;font-size:.9rem;color:#CDB5A2;margin-top:.1rem}
.row .ar{color:var(--tile-acc);font-size:1.4rem;transition:transform .2s}.row:hover .ar{transform:translateX(4px)}
.bloom{position:absolute;right:-24px;top:-58px;width:clamp(120px,14vw,170px);aspect-ratio:1;border-radius:50%;object-fit:cover;box-shadow:0 0 0 6px var(--bg),0 0 0 7.5px var(--copper);z-index:0}
@media (max-width:900px){.bloom{display:none}}
/* message card */
.grid2{display:grid;grid-template-columns:minmax(0,7fr) minmax(0,5fr);gap:clamp(1.2rem,3vw,2.2rem);align-items:start;margin:.5rem 0 2rem}
.msg{background:var(--paper);border:1px solid var(--line);border-radius:24px;overflow:hidden;box-shadow:0 20px 50px -34px var(--shadow)}
.mh{background:var(--copper);color:#fff;display:flex;justify-content:space-between;align-items:center;padding:1rem 1.4rem;letter-spacing:.2em;font-weight:600;font-size:.82rem}
.mh span:last-child{letter-spacing:.1em;opacity:.85}
.mb{padding:1.3rem 1.4rem 1.4rem;display:grid;gap:.9rem}
.mb label{display:grid;gap:.35rem;font-size:.82rem;color:var(--soft)}
.mb input,.mb textarea{font:inherit;font-size:1rem;color:var(--ink);background:var(--bg);border:1.5px solid var(--line);border-radius:12px;padding:.75rem .9rem;outline:none}
.mb textarea{min-height:120px;resize:vertical;font-family:var(--serif)}
.mb input:focus,.mb textarea:focus{border-color:var(--copper);box-shadow:0 0 0 3px color-mix(in srgb,var(--copper) 22%,transparent)}
.two{display:grid;grid-template-columns:1fr 1fr;gap:.9rem}
.chips{display:flex;flex-wrap:wrap;gap:.45rem}
.chip{font:inherit;font-size:.86rem;border:1.5px solid var(--line);background:var(--bg);color:var(--ink);border-radius:999px;padding:.45rem .8rem;cursor:pointer}
.chip[aria-pressed="true"]{border-color:var(--copper);background:color-mix(in srgb,var(--copper) 16%,var(--paper));color:var(--deep);font-weight:600}
.chip:focus-visible{outline:2px solid var(--deep);outline-offset:2px}
.send{display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;border-top:1.5px dashed var(--line);padding-top:1rem}
.send small{color:var(--soft);font-size:.8rem}.send a{color:var(--deep)}
.btn{font:inherit;font-size:.95rem;border-radius:999px;padding:.75rem 1.3rem;cursor:pointer;border:0;background:var(--copper);color:#fff;font-weight:600}
.btn:focus-visible{outline:2px solid var(--deep);outline-offset:2px}
.err{color:#B04A3A;font-size:.85rem;min-height:1.1em;margin:0}
.ok{display:none;text-align:center;padding:2rem 1.4rem}.ok.on{display:block}
.ok .seal{width:84px;height:84px;margin:0 auto 1rem;border-radius:50%;display:grid;place-items:center;background:radial-gradient(circle at 35% 30%,#C98A66,#9A5A40 70%);color:#F6E3D3;font-weight:600}
.ok h3{margin:0 0 .4rem;color:var(--copper);letter-spacing:.06em}.ok p{font-family:var(--serif);font-style:italic;color:var(--deep);margin:0}
.side{display:grid;gap:1rem}
.dest{background:var(--paper);border:1px solid var(--line);border-radius:24px;padding:1.3rem 1.4rem}
.dest h2,.gates2 h2{margin:0 0 .6rem;font-size:.8rem;letter-spacing:.24em;color:var(--copper)}
.dest p{margin:.35rem 0;font-family:var(--serif);color:var(--soft);line-height:1.6}.dest b{font-family:var(--sans);color:var(--ink);font-weight:600}
.dest a{color:var(--deep)}
.coord{display:inline-block;margin-top:.5rem;font-size:.82rem;letter-spacing:.1em;color:var(--deep);border:1.5px solid var(--line);border-radius:999px;padding:.35rem .75rem}
.ph{background:color-mix(in srgb,var(--copper) 16%,transparent);color:var(--deep);border-radius:4px;padding:0 .3em;font-family:var(--sans);font-size:.92em}
.gates2{background:var(--paper);border:1px solid var(--line);border-radius:24px;padding:1.3rem 1.4rem}
.gl{display:grid;gap:.45rem}
.gl a{display:grid;grid-template-columns:auto 1fr auto;gap:.8rem;align-items:center;text-decoration:none;color:var(--ink);padding:.6rem .7rem;border-radius:12px;border:1.5px solid var(--line)}
.gl a:hover,.gl a:focus-visible{border-color:var(--copper);outline:none}
.gl a span:first-child{font-size:.72rem;letter-spacing:.14em;color:#fff;background:var(--copper);border-radius:6px;padding:.3rem .45rem;font-weight:600}
.gl a span:last-child{color:var(--copper)}
@media (max-width:900px){.grid2{grid-template-columns:1fr}}
@media (max-width:520px){.two{grid-template-columns:1fr}.row{grid-template-columns:44px 1fr auto}.ic{width:44px;height:44px}}

</style>
@endpush

@push('scripts')
<script>
document.querySelectorAll('#topics .chip').forEach(c=>c.addEventListener('click',()=>{document.querySelectorAll('#topics .chip').forEach(x=>x.setAttribute('aria-pressed',x===c))}));
document.getElementById('form').addEventListener('submit',async e=>{e.preventDefault();const v=id=>document.getElementById(id).value.trim(),err=document.getElementById('err');
  const d={name:v('f_name'),phone:v('f_phone'),email:v('f_email'),topic:document.querySelector('#topics .chip[aria-pressed="true"]').textContent,message:v('f_msg')};
  if(!d.name||!d.phone||!d.message){err.textContent='Vui lòng điền họ tên, số điện thoại và lời nhắn.';return}
  if(!/^[0-9+\s.]{9,15}$/.test(d.phone)){err.textContent='Số điện thoại chưa đúng.';return}
  if(d.email&&!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(d.email)){err.textContent='Email chưa đúng định dạng.';return}
  err.textContent='';
  try{const form=e.currentTarget,body=new FormData(form);body.set('message',`Chủ đề: ${d.topic}\n\n${d.message}`);
    const r=await fetch(form.action,{method:'POST',body,headers:{'Accept':'application/json','X-CSRF-TOKEN':form.querySelector('input[name="_token"]').value}});if(!r.ok)throw 0}
  catch(x){err.textContent='Chưa gửi được, bạn vui lòng nhắn Zalo cho LNT nhé.';return}
  document.getElementById('fbody').style.display='none';document.getElementById('ok').classList.add('on')});
</script>
@endpush
