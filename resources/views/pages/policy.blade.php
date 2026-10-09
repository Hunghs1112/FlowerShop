@extends('layouts.app')

@section('title', $page?->title ?: 'Chính sách bảo mật')

@section('skip-main-wrapper', true)

@section('content')
<main class="wrap">
<section class="hero" aria-labelledby="t"><div><img class="logo" src="{{ asset('images/brand/lnt-logo.png') }}" alt="Lâm Nhiên Thảo"><p class="eyebrow">QUYỀN RIÊNG TƯ</p><h1 id="t">{{ $page?->title ?: 'Chính sách bảo mật' }}</h1><p class="lead">{{ $page?->policy_intro ?: 'Lâm Nhiên Thảo trân trọng sự tin tưởng của quý khách và cam kết bảo vệ quyền riêng tư, thông tin cá nhân của quý khách trong suốt quá trình sử dụng website và dịch vụ.' }}</p><p class="updated">Cập nhật lần cuối: {{ $page?->policy_updated_at_display ?: 'Tháng 9, 2026' }}</p></div>
<div class="visual"><div><div class="pass"><div class="pm"><div class="ph">FLOWER PASS · BẢO MẬT</div><div class="pf"><button type="button" class="fld" aria-label="HỌ VÀ TÊN: Để xác nhận và xử lý đơn hàng"><small>HỌ VÀ TÊN</small><span class="bar">Để xác nhận và xử lý đơn hàng</span></button><button type="button" class="fld" aria-label="SỐ ĐIỆN THOẠI · EMAIL: Để tư vấn, chăm sóc và hỗ trợ bạn"><small>SỐ ĐIỆN THOẠI · EMAIL</small><span class="bar">Để tư vấn, chăm sóc và hỗ trợ bạn</span></button><button type="button" class="fld" aria-label="ĐỊA CHỈ GIAO HÀNG: Để giao hoa đúng địa chỉ, đúng hẹn"><small>ĐỊA CHỈ GIAO HÀNG</small><span class="bar">Để giao hoa đúng địa chỉ, đúng hẹn</span></button><button type="button" class="fld" aria-label="ID ZALO: Khi bạn liên hệ qua Zalo"><small>ID ZALO</small><span class="bar">Khi bạn liên hệ qua Zalo</span></button><button type="button" class="fld wide" aria-label="NỘI DUNG TRAO ĐỔI: Để cải thiện sản phẩm và dịch vụ"><small>NỘI DUNG TRAO ĐỔI</small><span class="bar">Để cải thiện sản phẩm và dịch vụ</span></button></div></div>
<div class="ps"><svg width="54" height="64" viewBox="0 0 54 64" aria-hidden="true"><path d="M13 28V19a14 14 0 0 1 28 0v9" fill="none" stroke="currentColor" stroke-width="6"/><rect x="4" y="27" width="46" height="35" rx="7" fill="currentColor"/><circle cx="27" cy="42" r="5" fill="var(--paper)"/><rect x="25" y="44" width="4" height="10" fill="var(--paper)"/></svg><b>ĐƯỢC BẢO VỆ</b></div></div>
<p class="hint2">Rê chuột hoặc chạm vào từng ô để xem thông tin được dùng vào việc gì</p></div></div></section>
@if(filled($page?->policy_content_override))
<section class="body policy-editable-content" aria-label="Policy content"><x-markdown-renderer :content="$page->policy_content_override" /></section>
@else
<div class="toolbar"><p>08 CÁC MỤC</p><button class="btn-ghost" id="toggleAll" type="button">Mở tất cả</button></div>
<section class="gates" aria-label="Nội dung"><details class="gate" id="b1" open><summary><span class="code">01</span><h2>Phạm vi áp dụng</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Áp dụng cho thông tin thu thập qua website, các kênh liên hệ trực tuyến (bao gồm Zalo) và quá trình đặt hàng.</p><p>Chính sách này áp dụng đối với toàn bộ thông tin cá nhân mà Lâm Nhiên Thảo thu thập thông qua website, các kênh liên hệ trực tuyến (bao gồm Zalo) và quá trình đặt hàng, giao dịch với khách hàng.</p></div></details>
<details class="gate" id="b2"><summary><span class="code">02</span><h2>Thông tin chúng tôi thu thập</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Họ tên, số điện thoại, email, địa chỉ giao hàng, ID Zalo và nội dung trao đổi.</p><p>Trong quá trình quý khách sử dụng dịch vụ, chúng tôi có thể thu thập các loại thông tin sau:</p><ul><li>Họ và tên</li><li>Số điện thoại và địa chỉ email</li><li>Địa chỉ giao hàng</li><li>ID Zalo (trong trường hợp quý khách liên hệ qua kênh này)</li><li>Nội dung trao đổi, tư vấn và yêu cầu đặt hàng</li></ul></div></details>
<details class="gate" id="b3"><summary><span class="code">03</span><h2>Mục đích sử dụng thông tin</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Chỉ dùng để xử lý đơn, hỗ trợ bạn, giao hoa đúng hẹn và cải thiện dịch vụ.</p><p>Thông tin cá nhân được thu thập nhằm phục vụ các mục đích sau:</p><ul><li>Xác nhận, xử lý và thực hiện đơn hàng theo đúng yêu cầu của quý khách</li><li>Liên hệ tư vấn, chăm sóc và hỗ trợ khách hàng trước, trong và sau khi mua hàng</li><li>Đảm bảo giao hoa đúng địa chỉ, đúng thời gian theo thỏa thuận</li><li>Ghi nhận phản hồi nhằm cải thiện chất lượng sản phẩm và dịch vụ</li></ul><p>Chúng tôi cam kết chỉ sử dụng thông tin cá nhân trong phạm vi các mục đích nêu trên, trừ trường hợp có quy định khác của pháp luật hoặc được quý khách đồng ý.</p></div></details>
<details class="gate" id="b4"><summary><span class="code">04</span><h2>Chia sẻ thông tin với bên thứ ba</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Không bán, cho thuê hay trao đổi thông tin; chỉ chia sẻ với đối tác vận chuyển khi cần để giao hàng.</p><p>Lâm Nhiên Thảo cam kết không bán, cho thuê hoặc trao đổi thông tin cá nhân của quý khách với bất kỳ bên thứ ba nào vì mục đích thương mại. Thông tin cá nhân chỉ được chia sẻ với đối tác vận chuyển trong phạm vi cần thiết để thực hiện việc giao hàng, và các đối tác này có trách nhiệm bảo mật thông tin theo thỏa thuận với chúng tôi.</p></div></details>
<details class="gate" id="b5"><summary><span class="code">05</span><h2>Biện pháp bảo mật dữ liệu</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Áp dụng các biện pháp kỹ thuật và quản lý phù hợp để bảo vệ thông tin của bạn.</p><p>Chúng tôi áp dụng các biện pháp kỹ thuật và quản lý phù hợp nhằm bảo vệ thông tin cá nhân của quý khách khỏi các hành vi truy cập trái phép, sử dụng sai mục đích, thay đổi hoặc tiết lộ không được cho phép.</p></div></details>
<details class="gate" id="b6"><summary><span class="code">06</span><h2>Quyền của khách hàng</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Bạn có quyền xem, chỉnh sửa hoặc yêu cầu xóa thông tin cá nhân của mình.</p><p>Quý khách có quyền:</p><ul><li>Yêu cầu truy cập và xem lại thông tin cá nhân mà chúng tôi đang lưu trữ</li><li>Yêu cầu chỉnh sửa, cập nhật thông tin chưa chính xác</li><li>Yêu cầu xóa thông tin cá nhân khỏi hệ thống của chúng tôi</li></ul><p>Mọi yêu cầu liên quan đến các quyền nêu trên xin vui lòng gửi đến chúng tôi qua thông tin liên hệ tại <a href="#b8">Mục 8</a>.</p></div></details>
<details class="gate" id="b7"><summary><span class="code">07</span><h2>Thay đổi chính sách</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Chính sách có thể được cập nhật; phiên bản mới được đăng kèm thời điểm cập nhật.</p><p>Lâm Nhiên Thảo có thể điều chỉnh hoặc cập nhật Chính sách Bảo mật này để phù hợp với sự thay đổi trong hoạt động kinh doanh, hệ thống website hoặc các quy định pháp luật có liên quan.</p><p>Phiên bản cập nhật sẽ được đăng tải trên website cùng với thời điểm cập nhật. Việc tiếp tục sử dụng website sau khi chính sách được cập nhật được hiểu là khách hàng đã tiếp cận phiên bản chính sách mới.</p></div></details>
<details class="gate" id="b8"><summary><span class="code">08</span><h2>Thông tin liên hệ</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p>Nếu quý khách có bất kỳ thắc mắc nào liên quan đến chính sách bảo mật này, vui lòng dùng thông tin liên hệ mới nhất bên dưới.</p></div></details></section>
<section class="help" aria-labelledby="help-t"><div><h2 id="help-t">Cần hỗ trợ?</h2><p>Lâm Nhiên Thảo luôn sẵn sàng lắng nghe và đồng hành cùng bạn.</p></div>
@include('partials.contact-actions')</section>
<footer class="foot"><span>© Lâm Nhiên Thảo</span><span>Từ những vùng đất đặc biệt đến những nơi tuyệt đẹp</span></footer>
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
function upd(){const all=g.every(d=>d.open);b.textContent=all?'Thu gọn tất cả':'Mở tất cả';b.setAttribute('aria-expanded',all)}
b.addEventListener('click',()=>{const all=g.every(d=>d.open);g.forEach(d=>d.open=!all);upd()});g.forEach(d=>d.addEventListener('toggle',upd));upd();
if(location.hash){const t=document.querySelector(location.hash);if(t&&t.tagName==='DETAILS')t.open=true}})();
</script>
<script>document.querySelectorAll('.fld').forEach(f=>f.addEventListener('click',()=>f.classList.toggle('on')))</script>
@endpush
