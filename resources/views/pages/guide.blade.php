@extends('layouts.app')

@section('title', 'Hướng dẫn đặt hàng')

@section('skip-main-wrapper', true)

@section('content')
@if(!empty(trim($page?->content ?? '')))
<main class="wrap"><section class="body guide-editable-content"><x-markdown-renderer :content="$page->content" /></section></main>
@else
<main class="wrap">
<section class="hero" aria-labelledby="t"><div><img class="logo" src="{{ asset('images/brand/lnt-logo.png') }}" alt="Lâm Nhiên Thảo"><p class="eyebrow">HỖ TRỢ KHÁCH HÀNG</p><h1 id="t">Hướng dẫn<br>đặt hàng</h1><p class="lead">Năm bước đơn giản để những đoá hoa bay đến không gian của bạn. Chạm vào từng chặng trên lịch trình để xem chi tiết.</p></div>
<div class="visual"><img class="tk" src="{{ asset('images/pages/guide-itinerary.jpg') }}" alt=""><div class="itin"><div class="ih"><span>LỊCH TRÌNH · ITINERARY</span><span>LNT·01</span></div>
<ol class="legs"><span class="plane" aria-hidden="true"></span><li><button type="button" class="leg" data-t="o1"><i aria-hidden="true"></i><span><small>01 · CHECK-IN</small><b>Chọn hoa</b><em>Chọn bó hoa bạn yêu thích</em></span></button></li><li><button type="button" class="leg" data-t="o2"><i aria-hidden="true"></i><span><small>02 · HÀNH LÝ</small><b>Thêm vào giỏ hàng</b><em>Gửi bó hoa vào giỏ của bạn</em></span></button></li><li><button type="button" class="leg" data-t="o3"><i aria-hidden="true"></i><span><small>03 · LÊN MÁY BAY</small><b>Thanh toán</b><em>Tiền mặt hoặc chuyển khoản</em></span></button></li><li><button type="button" class="leg" data-t="o4"><i aria-hidden="true"></i><span><small>04 · KHAI BÁO</small><b>Thông tin nhận hàng</b><em>Người nhận, địa chỉ, thời gian</em></span></button></li><li><button type="button" class="leg" data-t="o5"><i aria-hidden="true"></i><span><small>05 · HẠ CÁNH</small><b>Nhận hoa</b><em>Kiểm tra hoa ngay khi nhận</em></span></button></li></ol>
<div class="ifoot"><div><small>TỪ</small>Vườn hoa</div><div style="text-align:right"><small>ĐẾN</small>Không gian của bạn</div></div></div></div></section>
<div class="toolbar"><p>05 CHẶNG</p><button class="btn-ghost" id="toggleAll" type="button">Mở tất cả</button></div>
<section class="gates" aria-label="Nội dung"><details class="gate" id="o1" open><summary><span class="code">01</span><h2>Chọn hoa</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Chọn hoa trên website; nếu có yêu cầu riêng về màu sắc hay đặc điểm hoa, hãy trao đổi với LNT trước khi đặt.</p><p>Xem các danh mục <strong>Sản phẩm</strong> hoặc <strong>Hộp hoa bí ẩn</strong> để chọn bó hoa phù hợp.</p><ul><li>Hoa tươi là sản phẩm tự nhiên nên màu sắc, kích thước, độ nở và số lượng cành thực tế có thể khác đôi chút so với hình ảnh trên website.</li><li>Với hoa nhập khẩu, nguồn cung có thể thay đổi theo mùa vụ, thời tiết và vận chuyển. Nếu sản phẩm không còn sẵn hoặc có thay đổi đáng kể, LNT sẽ chủ động trao đổi với bạn trước khi thực hiện đơn.</li><li>Nếu có yêu cầu cụ thể về đặc điểm của hoa, vui lòng trao đổi với LNT trước thời điểm đặt hàng.</li></ul></div></details>
<details class="gate" id="o2"><summary><span class="code">02</span><h2>Thêm vào giỏ hàng</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Thêm bó hoa đã chọn vào giỏ và kiểm tra lại trước khi thanh toán.</p><p>Bấm <strong>Thêm vào giỏ hàng</strong> ở trang sản phẩm. Trong giỏ hàng, bạn có thể kiểm tra lại sản phẩm và số lượng trước khi chuyển sang bước thanh toán.</p><p>Giá sản phẩm có thể thay đổi tùy theo mùa vụ và nguồn cung hoa, đặc biệt đối với hoa nhập khẩu.</p></div></details>
<details class="gate" id="o3"><summary><span class="code">03</span><h2>Thanh toán</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Thanh toán bằng tiền mặt hoặc chuyển khoản; đơn được xác nhận chính thức sau khi hoàn tất thanh toán.</p><ul><li>LNT chấp nhận thanh toán bằng <strong>tiền mặt</strong> hoặc <strong>chuyển khoản ngân hàng</strong>.</li><li>Đơn hàng chỉ được xác nhận chính thức sau khi hoàn tất thanh toán hoặc theo thỏa thuận cụ thể giữa hai bên.</li><li>Mọi đơn hàng cần được xác nhận qua <strong>Zalo hoặc điện thoại</strong> trước khi thực hiện.</li></ul></div></details>
<details class="gate" id="o4"><summary><span class="code">04</span><h2>Điền thông tin nhận hàng</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Cung cấp đầy đủ người nhận, địa chỉ và thời gian; giao trong ngày khi đơn được đặt và xác nhận trước 14:00.</p><ul><li>Vui lòng cung cấp <strong>đầy đủ địa chỉ</strong> để LNT kiểm tra và xác nhận khả năng giao nhận. LNT hiện giao tại <strong>TP. Hà Nội và một số khu vực lân cận</strong>.</li><li>Thời gian giao tiêu chuẩn: <strong>Thứ Hai đến Thứ Bảy, 08:00–17:00</strong>. Giao trong ngày áp dụng với sản phẩm có sẵn và đơn được <strong>đặt, xác nhận trước 14:00</strong>.</li><li>Nếu cần giao theo khung giờ cụ thể, giao gấp, hoặc giao vào Chủ Nhật, ngày lễ, vui lòng liên hệ trước để LNT xác nhận.</li><li>Nếu giao tại lễ tân, bảo vệ, bệnh viện, trường học, tòa nhà văn phòng hoặc khu vực có kiểm soát ra vào, vui lòng thông báo trước.</li><li>Thời gian và phí giao hàng được LNT thông báo và xác nhận cùng đơn hàng.</li></ul><p>Xem chi tiết tại <a href="{{ route('policy', 'chinh-sach-giao-hang') }}">Chính sách giao hàng</a>.</p></div></details>
<details class="gate" id="o5"><summary><span class="code">05</span><h2>Nhận hoa</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Kiểm tra hoa ngay khi nhận, quay video lúc mở hàng và phản hồi trong 02 giờ nếu có vấn đề.</p><ul><li>Vui lòng đảm bảo có người nhận tại địa chỉ đã cung cấp vào thời gian đã hẹn.</li><li><strong>Kiểm tra hoa ngay khi nhận.</strong> Nên quay hình ảnh/video trong quá trình mở hàng.</li><li>Tháo nylon và đưa hoa ra khỏi thùng/gói sau khi nhận, bảo quản theo hướng dẫn chăm sóc đi kèm.</li><li>Mọi phản hồi về chất lượng cần được gửi đến LNT <strong>trong 02 giờ</strong> kể từ khi hoàn tất giao hàng. Giữ nguyên hiện trạng hoa cho đến khi trao đổi với CSKH.</li></ul><p>Xem chi tiết tại <a href="{{ route('policy', 'chinh-sach-doi-tra') }}">Chính sách của chúng tôi</a>.</p></div></details></section>
<section class="help" aria-labelledby="help-t"><div><h2 id="help-t">Cần hỗ trợ?</h2><p>Lâm Nhiên Thảo luôn sẵn sàng lắng nghe và đồng hành cùng bạn.</p></div>
@include('partials.contact-actions')</section>
<footer class="foot"><span>© Lâm Nhiên Thảo</span><span>Từ những vùng đất đặc biệt đến những nơi tuyệt đẹp</span></footer>
</main>
@endif
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
.visual{min-width:0;position:relative;display:grid;place-items:center}
.itin{position:relative;z-index:1;width:min(100%,460px);background:var(--paper);border-radius:22px;border:1px solid var(--line);box-shadow:0 30px 60px -30px var(--shadow);padding:1.3rem 1.5rem 1.1rem;transform:rotate(-1.5deg)}
.ih{display:flex;justify-content:space-between;font-size:.76rem;letter-spacing:.22em;color:var(--copper);font-weight:600;border-bottom:1.5px solid var(--line);padding-bottom:.7rem;margin-bottom:.6rem}.ih span:last-child{color:var(--soft);letter-spacing:.1em}
.legs{list-style:none;margin:0;padding:0;position:relative}
.legs::before{content:"";position:absolute;left:13px;top:18px;bottom:18px;border-left:2px dashed var(--copper);opacity:.7}
.plane{position:absolute;left:5px;top:12px;width:18px;height:18px;border-radius:50%;background:var(--copper);box-shadow:0 0 0 4px color-mix(in srgb,var(--copper) 25%,transparent);animation:fly 3.6s .5s cubic-bezier(.5,0,.3,1) forwards}
@keyframes fly{to{top:calc(100% - 30px)}}
.leg{all:unset;box-sizing:border-box;display:grid;grid-template-columns:28px 1fr;gap:.9rem;align-items:center;width:100%;padding:.55rem .4rem;border-radius:12px;cursor:pointer}
.leg:hover,.leg:focus-visible{background:color-mix(in srgb,var(--copper) 9%,transparent)}.leg:focus-visible{outline:2px solid var(--deep)}
.leg i{width:14px;height:14px;border-radius:50%;border:3px solid var(--copper);background:var(--paper);justify-self:center;position:relative;z-index:1}
.leg small{display:block;font-size:.64rem;letter-spacing:.18em;color:var(--soft)}
.leg b{display:block;font-size:1.12rem;color:var(--ink);font-weight:600}
.leg em{display:block;font-family:var(--serif);font-size:.86rem;color:var(--deep)}
.ifoot{display:flex;justify-content:space-between;border-top:1.5px solid var(--line);margin-top:.6rem;padding-top:.7rem;font-family:var(--serif);font-style:italic;font-size:.86rem;color:var(--ink)}
.ifoot small{display:block;font-family:var(--sans);font-style:normal;font-size:.62rem;letter-spacing:.18em;color:var(--soft)}
.tk{position:absolute;right:-10px;top:-40px;width:clamp(120px,14vw,170px);aspect-ratio:1;border-radius:50%;object-fit:cover;box-shadow:0 0 0 6px var(--bg),0 0 0 7.5px var(--copper)}
@media (max-width:900px){.tk{display:none}}
.guide-editable-content{max-width:900px;margin:clamp(2rem,6vw,5rem) auto;padding:clamp(1.25rem,4vw,3rem);border:1px solid var(--line);border-radius:22px;background:var(--paper);box-shadow:0 18px 40px -30px var(--shadow)}
.guide-editable-content .markdown-content>p:first-child{margin:0 0 1rem;color:var(--deep);font-size:.78rem;font-weight:600;letter-spacing:.2em}
.guide-editable-content .markdown-content>p:nth-child(2){margin:0 0 2rem;padding-bottom:1.5rem;border-bottom:1px solid var(--line);font:italic 1.08rem/1.75 var(--serif);color:var(--soft)}
.guide-editable-content h2{margin:1.7rem 0 .65rem;padding:0 0 .65rem;border-bottom:1px dashed var(--line);color:var(--deep);font-size:clamp(1.05rem,2vw,1.3rem);letter-spacing:.04em}
.guide-editable-content p,.guide-editable-content li{max-width:70ch;color:var(--soft);font:1rem/1.8 var(--serif)}
.guide-editable-content ul,.guide-editable-content ol{padding-left:1.25rem}
.guide-editable-content a{color:var(--deep);text-underline-offset:3px}
.guide-editable-content strong{color:var(--ink);font-weight:600}
</style>
@endpush

@push('scripts')
<script>
(function(){const b=document.getElementById('toggleAll');if(!b)return;const g=[...document.querySelectorAll('.gate')];
function upd(){const all=g.every(d=>d.open);b.textContent=all?'Thu gọn tất cả':'Mở tất cả';b.setAttribute('aria-expanded',all)}
b.addEventListener('click',()=>{const all=g.every(d=>d.open);g.forEach(d=>d.open=!all);upd()});g.forEach(d=>d.addEventListener('toggle',upd));upd();
if(location.hash){const t=document.querySelector(location.hash);if(t&&t.tagName==='DETAILS')t.open=true}})();
</script>
<script>document.querySelectorAll('.leg').forEach(b=>b.addEventListener('click',()=>{const g=document.getElementById(b.dataset.t);g.open=true;g.scrollIntoView({block:'start'});g.querySelector('summary').focus({preventScroll:true})}))</script>
@endpush
