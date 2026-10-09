@extends('layouts.app')

@section('title', $page?->title ?: 'Chính sách giao hàng')

@section('skip-main-wrapper', true)

@section('content')
<main class="wrap">
<section class="hero" aria-labelledby="t"><div><img class="logo" src="{{ asset('images/brand/lnt-logo.png') }}" alt="Lâm Nhiên Thảo"><p class="eyebrow">DỊCH VỤ</p><h1 id="t">{{ $page?->title ?: 'Chính sách giao hàng' }}</h1><p class="lead">{{ $page?->policy_intro ?: 'LNT cung cấp dịch vụ giao hoa tận nơi, với phương thức vận chuyển được lựa chọn phù hợp theo từng đơn hàng và khu vực nhận hàng.' }}</p></div>
<div class="visual"><img class="bb" src="{{ asset('images/pages/policy-delivery-bouquet.jpg') }}" alt=""><div class="trk" role="img" aria-label="Thẻ theo dõi đơn hoa minh hoạ quy trình giao hàng 5 bước"><div class="th"><span>THEO DÕI ĐƠN HOA</span><span>LNT·01</span></div>
<div class="tt">Đang trên đường đến bạn</div><div class="route"><div><b>VƯỜN</b><small>Xưởng hoa LNT</small></div><div class="r"><b>BẠN</b><small>Không gian của bạn</small></div></div>
<div class="prog"><i></i></div><ol class="steps"><li data-i="0">Xác nhận đơn</li><li data-i="1">Chuẩn bị hoa</li><li data-i="2">Bàn giao vận chuyển</li><li data-i="3">Liên hệ trước khi đến</li><li data-i="4">Giao thành công</li></ol>
<div class="facts"><span>Thứ Hai – Thứ Bảy · 08:00–17:00</span><span>Giao trong ngày: xác nhận trước 14:00</span><span>Hà Nội &amp; khu vực lân cận</span></div></div></div></section>
@if(filled($page?->policy_content_override))
<section class="body policy-editable-content" aria-label="Policy content"><x-markdown-renderer :content="$page->policy_content_override" /></section>
@else
<div class="toolbar"><p>08 CÁC MỤC</p><button class="btn-ghost" id="toggleAll" type="button">Mở tất cả</button></div>
<section class="gates" aria-label="Nội dung"><details class="gate" id="g1" open><summary><span class="code">01</span><h2>Khu vực giao hàng</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Hà Nội và một số khu vực lân cận.</p><p>LNT hiện hỗ trợ giao hàng tại <strong>TP. Hà Nội và một số khu vực lân cận</strong>.</p><p>Phạm vi giao hàng có thể thay đổi tùy theo địa chỉ, thời điểm và điều kiện vận chuyển. Vui lòng cung cấp đầy đủ địa chỉ khi đặt hàng để LNT kiểm tra và xác nhận khả năng giao nhận.</p></div></details>
<details class="gate" id="g2"><summary><span class="code">02</span><h2>Thời gian giao hàng</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Thứ Hai đến Thứ Bảy, 08:00–17:00. Giao trong ngày khi đơn được đặt và xác nhận trước 14:00.</p><h3>Giao hàng tiêu chuẩn</h3><p>LNT nhận giao hàng từ <strong>Thứ Hai đến Thứ Bảy, 08:00–17:00</strong>.</p><p>Thời gian giao cụ thể được xác nhận dựa trên thời điểm đặt hàng, tình trạng sản phẩm và khu vực nhận hàng.</p><h3>Giao hàng trong ngày</h3><p>Dịch vụ giao trong ngày áp dụng đối với <strong>các sản phẩm đang có sẵn</strong> và đơn hàng được LNT xác nhận trong ngày.</p><ul><li>Đơn hàng cần được <strong>đặt và xác nhận trước 14:00</strong> để được xem xét giao trong ngày.</li><li>Đơn đặt sau 14:00 có thể được chuyển sang ngày tiếp theo, tùy tình trạng sản phẩm và khả năng giao hàng.</li><li>Thời gian giao thực tế phụ thuộc vào <strong>thời điểm xác nhận đơn, thời gian chuẩn bị hoa, khoảng cách giao hàng và tình trạng vận chuyển</strong>.</li><li>Yêu cầu giao trong ngày <strong>không đồng nghĩa với giao ngay hoặc giao trong một khung giờ cố định</strong>, trừ khi LNT đã xác nhận cụ thể.</li><li>Đối với các đơn cần giao gấp, khách hàng vui lòng liên hệ trực tiếp qua <strong>Zalo hoặc điện thoại</strong> để LNT kiểm tra khả năng đáp ứng trước khi đặt hàng.</li><li>Một số sản phẩm <strong>đặt trước, hoa theo mùa, hoa nhập khẩu hoặc sản phẩm cần chuẩn bị riêng</strong> có thể không áp dụng dịch vụ giao trong ngày.</li></ul><h3>Giao theo khung giờ yêu cầu</h3><p>LNT có thể hỗ trợ giao theo khung giờ cụ thể tùy từng đơn hàng. Yêu cầu này cần được xác nhận trước và <strong>có thể phát sinh phụ phí</strong>.</p><h3>Chủ Nhật và ngày lễ</h3><p>LNT có thể hỗ trợ giao hàng vào Chủ Nhật hoặc ngày lễ tùy lịch vận hành và khả năng đáp ứng tại từng thời điểm. Vui lòng liên hệ trước để được xác nhận.</p><p>Thời gian giao dự kiến có thể thay đổi do <strong>tình hình giao thông, thời tiết hoặc các yếu tố khách quan khác</strong>.</p></div></details>
<details class="gate" id="g3"><summary><span class="code">03</span><h2>Phí giao hàng</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Phí được tính theo khoảng cách, khu vực, thời điểm và hình thức vận chuyển, và được báo trước khi giao.</p><p>Phí giao hàng được xác định dựa trên <strong>khoảng cách, khu vực giao nhận, thời điểm và hình thức vận chuyển</strong>.</p><p>Chi phí giao hàng cụ thể sẽ được LNT thông báo và xác nhận cùng đơn hàng trước khi giao.</p><p>Trong một số chương trình hoặc đơn hàng đạt giá trị nhất định, LNT có thể áp dụng chính sách hỗ trợ phí giao hàng theo từng thời điểm.</p></div></details>
<details class="gate" id="g4"><summary><span class="code">04</span><h2>Quy trình giao hàng</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Năm bước từ khi xác nhận đơn đến khi giao thành công.</p><p>Sau khi đơn hàng được xác nhận:</p><ol><li>LNT xác nhận thông tin sản phẩm, địa chỉ và thời gian giao hàng.</li><li>Đơn hàng được chuẩn bị và bàn giao cho đơn vị hoặc nhân viên giao hàng phù hợp.</li><li>Người giao hàng có thể liên hệ trước khi đến địa chỉ nhận.</li><li>Khách hàng vui lòng đảm bảo có người nhận tại địa chỉ đã cung cấp.</li><li>Sau khi giao thành công, đơn hàng được xem là hoàn tất.</li></ol><p>Đối với các đơn hàng có yêu cầu giao tại <strong>lễ tân, bảo vệ, quầy tiếp nhận hoặc khu vực trung gian</strong>, khách hàng vui lòng thông báo trước để LNT ghi nhận khi điều phối giao hàng.</p></div></details>
<details class="gate" id="g5"><summary><span class="code">05</span><h2>Tiếp nhận và kiểm tra hoa</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Kiểm tra hoa khi nhận và báo cho LNT sớm nhất nếu có bất thường.</p><p>Hoa là sản phẩm tươi và có tính chất đặc thù. LNT kiểm tra tình trạng sản phẩm trước khi giao và đóng gói phù hợp với từng loại hoa.</p><p>Khi nhận hàng, khách hàng vui lòng kiểm tra tình trạng hoa và thông báo cho LNT trong thời gian sớm nhất nếu phát hiện bất thường. Xem thêm <a href="/trang/chinh-sach-doi-tra#s2">thời hạn tiếp nhận phản hồi</a>.</p><p>Hướng dẫn chăm sóc sẽ được cung cấp tùy theo loại hoa và hình thức sản phẩm.</p></div></details>
<details class="gate" id="g6"><summary><span class="code">06</span><h2>Yêu cầu đặc biệt</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Với địa điểm có quy định ra vào riêng, vui lòng báo trước đầy đủ thông tin.</p><p>Đối với các địa điểm như <strong>bệnh viện, trường học, tòa nhà văn phòng, khu dân cư có kiểm soát ra vào</strong> hoặc các địa điểm có quy định riêng về giao nhận, khách hàng vui lòng cung cấp đầy đủ thông tin cần thiết.</p><p>Các yêu cầu về thời gian, người nhận, điểm giao hoặc quy trình ra vào cần được thông báo trước để LNT kiểm tra khả năng đáp ứng.</p></div></details>
<details class="gate" id="g7"><summary><span class="code">07</span><h2>Giao hàng không thành công</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">LNT sẽ liên hệ để thống nhất cách xử lý; giao lại có thể phát sinh phí.</p><p>Đơn hàng có thể phát sinh giao hàng không thành công trong trường hợp:</p><ul><li>Không liên lạc được với người nhận.</li><li>Địa chỉ hoặc thông tin giao hàng không chính xác.</li><li>Người nhận từ chối nhận hoặc không có mặt tại địa chỉ đã đăng ký.</li><li>Địa điểm nhận không thể tiếp cận tại thời điểm giao.</li></ul><p>Trong trường hợp này, LNT sẽ liên hệ với khách hàng để thống nhất phương án xử lý.</p><p>Nếu cần giao lại, <strong>phí giao hàng phát sinh có thể được áp dụng</strong> tùy nguyên nhân và điều kiện của đơn hàng.</p><p>Đối với hoa tươi, thời gian và điều kiện bảo quản có thể ảnh hưởng trực tiếp đến chất lượng sản phẩm. Vì vậy, LNT không đảm bảo giữ nguyên tình trạng ban đầu của hoa trong thời gian chờ xử lý giao lại.</p></div></details>
<details class="gate" id="g8"><summary><span class="code">08</span><h2>Liên hệ</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p>Để kiểm tra phạm vi giao hàng, chi phí hoặc yêu cầu giao nhận đặc biệt, vui lòng xem thông tin cập nhật tại trang liên hệ.</p></div></details></section>
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
.visual{min-width:0;position:relative;display:grid;place-items:center}
.trk{position:relative;z-index:1;width:min(100%,600px);background:var(--paper);border-radius:24px;box-shadow:0 30px 60px -30px var(--shadow);border:1px solid var(--line);padding:1.4rem 1.6rem 1.3rem}
.th{display:flex;justify-content:space-between;font-size:.74rem;letter-spacing:.2em;color:var(--copper);font-weight:600}.th span:last-child{color:var(--soft)}
.tt{font-family:var(--serif);font-size:1.45rem;color:var(--ink);margin:.4rem 0 1.3rem}
.route{display:flex;justify-content:space-between;align-items:end;margin-bottom:1.2rem}
.route b{font-size:2rem;color:var(--copper);font-weight:600;line-height:1}.route small{display:block;font-family:var(--serif);font-style:italic;color:var(--deep);font-size:.85rem;margin-top:.3rem}
.route .r{text-align:right}
.prog{position:relative;height:6px;border-radius:6px;background:var(--line);margin:0 12px}
.prog i{position:absolute;inset:0 auto 0 0;width:0;background:var(--copper);border-radius:6px;animation:fill 3.2s .4s cubic-bezier(.5,0,.2,1) forwards}
@keyframes fill{to{width:100%}}
.steps{display:grid;grid-template-columns:repeat(5,1fr);margin-top:-15px;position:relative}
.steps li{list-style:none;text-align:center;font-size:.72rem;color:var(--soft);line-height:1.3}
.steps li::before{content:"";display:block;width:22px;height:22px;margin:0 auto .55rem;border-radius:50%;background:var(--paper);border:3px solid var(--copper);transition:background .3s}
.steps li.done::before{background:var(--copper)}
.facts{display:flex;flex-wrap:wrap;gap:.5rem;margin-top:1.2rem;border-top:1.5px dashed var(--line);padding-top:1rem}
.facts span{font-size:.8rem;color:var(--deep);border:1.5px solid var(--line);border-radius:999px;padding:.38rem .75rem}
.bb{position:absolute;right:-20px;top:-50px;width:clamp(110px,13vw,160px);aspect-ratio:1;border-radius:50%;object-fit:cover;box-shadow:0 0 0 6px var(--bg),0 0 0 7.5px var(--copper)}
.steps ol{display:contents}
@media (max-width:900px){.bb{display:none}}
@media (max-width:520px){.steps li{font-size:.62rem}}
</style>
@endpush

@push('scripts')
<script>
(function(){const b=document.getElementById('toggleAll');if(!b)return;const g=[...document.querySelectorAll('.gate')];
function upd(){const all=g.every(d=>d.open);b.textContent=all?'Thu gọn tất cả':'Mở tất cả';b.setAttribute('aria-expanded',all)}
b.addEventListener('click',()=>{const all=g.every(d=>d.open);g.forEach(d=>d.open=!all);upd()});g.forEach(d=>d.addEventListener('toggle',upd));upd();
if(location.hash){const t=document.querySelector(location.hash);if(t&&t.tagName==='DETAILS')t.open=true}})();
</script>
<script>(function(){const li=[...document.querySelectorAll('.steps li')];const r=matchMedia('(prefers-reduced-motion: reduce)').matches;
li.forEach((l,i)=>{if(r){l.classList.add('done');return}setTimeout(()=>l.classList.add('done'),400+i*780)})})();</script>
@endpush
