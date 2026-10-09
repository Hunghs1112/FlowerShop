@extends('layouts.app')

@section('title', $page?->title ?: 'Điều khoản dịch vụ')

@section('skip-main-wrapper', true)

@section('content')
<main class="wrap">
<section class="hero" aria-labelledby="t"><div><img class="logo" src="{{ asset('images/brand/lnt-logo.png') }}" alt="Lâm Nhiên Thảo"><p class="eyebrow">THÔNG TIN</p><h1 id="t">{{ $page?->title ?: 'Điều khoản dịch vụ' }}</h1><p class="lead">{{ $page?->policy_intro ?: 'Chào mừng bạn đến với website của Lâm Nhiên Thảo. Vui lòng đọc kỹ các điều khoản dịch vụ dưới đây khi sử dụng các dịch vụ do LNT cung cấp.' }}</p></div>
<div class="visual"><div class="visa" role="img" aria-label="Thẻ visa minh hoạ: Flower Entry, hoa tươi nhập khẩu"><header><b>VISA · FLOWER ENTRY</b><span>LNT</span></header>
<div class="vg"><img src="{{ asset('images/pages/policy-terms-bouquet.jpg') }}" alt=""><div class="vf"><div><small>LOẠI</small><em>Hoa tươi nhập khẩu</em></div><div><small>XUẤT XỨ</small><em>Những vườn hoa xa xôi</em></div><div><small>ĐIỂM ĐẾN</small><em>Không gian của bạn</em></div><div><small>HIỆU LỰC</small><em>Cho mỗi đơn hàng</em></div></div></div>
<div class="mrz">V&lt;VNMLAM&lt;NHIEN&lt;THAO&lt;&lt;FLOWERS&lt;&lt;&lt;&lt;&lt;&lt;&lt;&lt;&lt;&lt;<br>LNT&lt;&lt;HAN&lt;&lt;TERMS&lt;&lt;OF&lt;&lt;SERVICE&lt;&lt;&lt;&lt;&lt;&lt;&lt;</div>
<div class="vst">ĐÃ DUYỆT<br>APPROVED</div></div></div></section>
@if(filled($page?->policy_content_override))
<section class="body policy-editable-content" aria-label="Policy content"><x-markdown-renderer :content="$page->policy_content_override" /></section>
@else
<div class="toolbar"><p>07 CÁC MỤC</p><button class="btn-ghost" id="toggleAll" type="button">Mở tất cả</button></div>
<section class="gates" aria-label="Nội dung"><details class="gate" id="d1" open><summary><span class="code">01</span><h2>Chấp thuận điều khoản</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Tiếp tục sử dụng website hoặc dịch vụ nghĩa là bạn đồng ý với các điều khoản hiện hành.</p><p>Khi tiếp tục sử dụng website hoặc dịch vụ, khách hàng xác nhận rằng mình đồng ý tuân thủ các điều khoản hiện hành.</p></div></details>
<details class="gate" id="d2"><summary><span class="code">02</span><h2>Sản phẩm và dịch vụ</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Hoa thực tế có thể khác đôi chút so với hình ảnh; nếu có thay đổi đáng kể, LNT sẽ trao đổi với bạn trước.</p><p>LNT nỗ lực cung cấp hình ảnh, thông tin và mô tả sản phẩm một cách chính xác, đầy đủ và cập nhật nhất.</p><p>Tuy nhiên, hoa tươi là sản phẩm tự nhiên nên có sự khác biệt nhất định giữa từng mùa hoa, lô hàng và thời điểm thu hoạch. Màu sắc, kích thước, độ nở, hình dáng, số lượng cành và trạng thái thực tế của hoa có thể thay đổi đôi chút so với hình ảnh hiển thị trên website.</p><p>Đối với các sản phẩm hoa nhập khẩu, tình trạng nguồn cung, mùa vụ, thời tiết, vận chuyển và các yếu tố khách quan khác có thể ảnh hưởng đến khả năng cung cấp hoặc thời điểm giao hàng.</p><p>Trong trường hợp một sản phẩm không còn sẵn hoặc có thay đổi đáng kể về chất lượng, LNT sẽ chủ động trao đổi với khách hàng để thống nhất phương án phù hợp trước khi thực hiện đơn hàng.</p></div></details>
<details class="gate" id="d3"><summary><span class="code">03</span><h2>Đặt hàng và thanh toán</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Đơn hàng được xác nhận qua Zalo hoặc điện thoại; thanh toán bằng tiền mặt hoặc chuyển khoản.</p><ul><li>Mọi đơn hàng cần được xác nhận qua Zalo hoặc điện thoại trước khi thực hiện.</li><li>Chúng tôi chấp nhận hình thức thanh toán bằng tiền mặt hoặc chuyển khoản ngân hàng.</li><li>Đơn hàng chỉ được xác nhận chính thức sau khi hoàn tất thanh toán hoặc theo thỏa thuận cụ thể giữa hai bên.</li><li>Giá sản phẩm có thể thay đổi tùy theo mùa vụ và nguồn cung hoa, đặc biệt đối với hoa nhập khẩu.</li></ul></div></details>
<details class="gate" id="d4"><summary><span class="code">04</span><h2>Giao hàng</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Thời gian và phí giao hàng được thỏa thuận cụ thể khi đặt hàng.</p><ul><li>Thời gian và phí giao hàng sẽ được thỏa thuận cụ thể tại thời điểm đặt hàng.</li><li>Chúng tôi không chịu trách nhiệm đối với các trường hợp chậm trễ giao hàng do thiên tai, tình trạng giao thông hoặc các sự kiện bất khả kháng nằm ngoài tầm kiểm soát của chúng tôi.</li><li>Quý khách vui lòng đảm bảo có mặt tại địa điểm nhận hàng vào thời gian đã hẹn, hoặc thông báo trước thông tin người nhận thay.</li></ul><p>Xem chi tiết tại <a href="{{ route('policy', 'chinh-sach-giao-hang') }}">Chính sách giao hàng</a>.</p></div></details>
<details class="gate" id="d5"><summary><span class="code">05</span><h2>Đổi, trả, hoàn tiền và xử lý khiếu nại</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Không đổi trả vì thay đổi nhu cầu sau khi đã nhận hàng; nếu vấn đề thuộc trách nhiệm của LNT, chúng tôi sẽ kiểm tra và đưa ra phương án phù hợp.</p><p>Hoa tươi là sản phẩm có thời gian sử dụng ngắn và chất lượng có thể thay đổi theo điều kiện bảo quản. Vì vậy, LNT không áp dụng đổi trả sản phẩm chỉ vì thay đổi nhu cầu hoặc ý kiến của khách hàng sau khi đơn hàng đã được giao và tiếp nhận.</p><p>Trong trường hợp sản phẩm được giao không đúng với nội dung đã xác nhận hoặc phát sinh vấn đề thuộc trách nhiệm của Lâm Nhiên Thảo, khách hàng vui lòng liên hệ sớm để chúng tôi kiểm tra và đưa ra phương án xử lý phù hợp.</p><p>Tùy từng trường hợp, phương án hỗ trợ có thể bao gồm đổi sản phẩm, bổ sung sản phẩm, hoàn lại một phần hoặc toàn bộ giá trị tương ứng, hoặc một phương án khác được hai bên thống nhất.</p><p>Việc xử lý đổi trả và hoàn tiền được thực hiện theo <a href="{{ route('policy', 'chinh-sach-doi-tra') }}">Chính sách Đổi trả &amp; Hoàn tiền</a> được công bố trên website.</p></div></details>
<details class="gate" id="d6"><summary><span class="code">06</span><h2>Thay đổi điều khoản</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Điều khoản có thể được cập nhật khi cần; phiên bản mới được đăng kèm thời điểm cập nhật.</p><p>LNT có thể sửa đổi hoặc cập nhật Điều khoản Dịch vụ khi cần thiết nhằm phù hợp với hoạt động kinh doanh, dịch vụ cung cấp hoặc các quy định pháp luật hiện hành.</p><p>Phiên bản cập nhật sẽ được đăng tải trên website cùng với thời điểm cập nhật.</p></div></details>
<details class="gate" id="d7"><summary><span class="code">07</span><h2>Thông tin liên hệ</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p>Nếu có bất kỳ thắc mắc nào liên quan đến Điều khoản Dịch vụ, vui lòng dùng thông tin liên hệ mới nhất bên dưới.</p></div></details></section>
<section class="help" aria-labelledby="help-t"><div><h2 id="help-t">Cần hỗ trợ?</h2><p>Lâm Nhiên Thảo luôn sẵn sàng lắng nghe và đồng hành cùng bạn.</p></div>
@include('partials.contact-actions')</section>
<footer class="foot"><span>© Lâm Nhiên Thảo</span><span>Từ những vùng đất đặc biệt đến những nơi tuyệt đẹp</span></footer>
@endif
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
.visual{min-width:0;display:grid;place-items:center}
.visa{position:relative;width:min(100%,560px);background:var(--paper);border-radius:20px;box-shadow:0 30px 60px -30px var(--shadow);border:1px solid var(--line);padding:1.3rem 1.5rem 1.2rem;transform:rotate(-2deg);overflow:hidden;
background-image:repeating-radial-gradient(circle at 80% 60%,transparent 0 14px,color-mix(in srgb,var(--copper) 14%,transparent) 14px 15px)}
.visa header{display:flex;justify-content:space-between;align-items:baseline;border-bottom:1.5px solid var(--line);padding-bottom:.7rem;margin-bottom:1rem}
.visa header b{color:var(--copper);letter-spacing:.24em;font-size:.95rem}.visa header span{color:var(--copper);font-weight:600}
.vg{display:grid;grid-template-columns:150px 1fr;gap:1.1rem}
.vg img{width:150px;height:183px;object-fit:cover;border:1.5px solid var(--line);border-radius:6px;display:block}
.vf{display:grid;gap:.55rem}.vf small{display:block;font-size:.62rem;letter-spacing:.18em;color:var(--soft)}
.vf em{font-family:var(--serif);font-style:normal;color:var(--ink);font-size:1.05rem}
.mrz{font-family:ui-monospace,"SF Mono",Menlo,Consolas,monospace;font-size:clamp(.62rem,1.15vw,.78rem);color:var(--soft);letter-spacing:.06em;margin-top:1rem;line-height:1.5;white-space:nowrap;overflow:hidden}
.vst{position:absolute;right:22px;bottom:64px;width:130px;height:130px;border-radius:50%;border:3px solid color-mix(in srgb,var(--deep) 70%,transparent);display:grid;place-items:center;text-align:center;color:color-mix(in srgb,var(--deep) 80%,transparent);
transform:rotate(-14deg);font-weight:600;letter-spacing:.12em;font-size:.8rem;line-height:1.4;animation:stampin .5s 1s both cubic-bezier(.2,1.6,.4,1)}
.vst::before{content:"";position:absolute;inset:7px;border:1.5px solid currentColor;border-radius:50%}
@keyframes stampin{from{opacity:0;transform:rotate(-14deg) scale(1.6)}to{opacity:1;transform:rotate(-14deg) scale(1)}}
@media (max-width:520px){.vg{grid-template-columns:100px 1fr}.vg img{width:100px;height:122px}.vst{width:90px;height:90px;font-size:.58rem;bottom:18px;right:14px}}
</style>
@endpush

@push('scripts')
<script>
(function(){const b=document.getElementById('toggleAll');if(!b)return;const g=[...document.querySelectorAll('.gate')];
function upd(){const all=g.every(d=>d.open);b.textContent=all?'Thu gọn tất cả':'Mở tất cả';b.setAttribute('aria-expanded',all)}
b.addEventListener('click',()=>{const all=g.every(d=>d.open);g.forEach(d=>d.open=!all);upd()});g.forEach(d=>d.addEventListener('toggle',upd));upd();
if(location.hash){const t=document.querySelector(location.hash);if(t&&t.tagName==='DETAILS')t.open=true}})();
</script>
@endpush
