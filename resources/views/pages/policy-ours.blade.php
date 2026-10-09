@extends('layouts.app')

@section('title', $page?->title ?: 'Chính sách của chúng tôi')

@section('skip-main-wrapper', true)

@section('content')
<main class="wrap">
<section class="hero" aria-labelledby="t"><div><img class="logo" src="{{ asset('images/brand/lnt-logo.png') }}" alt="Lâm Nhiên Thảo"><p class="eyebrow">CAM KẾT</p><h1 id="t">{{ $page?->title ?: 'Chính sách của chúng tôi' }}</h1><p class="lead">{{ $page?->policy_intro ?: 'Tại Lâm Nhiên Thảo, sự hài lòng và quyền lợi của khách hàng luôn là ưu tiên hàng đầu. Vui lòng đọc kỹ các chính sách dưới đây để hiểu rõ quyền lợi và trách nhiệm trong quá trình sử dụng dịch vụ.' }}</p></div>
<div class="visual"><img class="bloom" src="{{ asset('images/pages/policy-ours-bloom.jpg') }}" alt=""><div class="board"><div class="bh"><span>KHỞI HÀNH · DEPARTURES</span><time id="clock">--:--</time></div>
<div class="cols" aria-hidden="true"><span>CHUYẾN</span><span>ĐIỂM ĐẾN</span><span>TRẠNG THÁI</span></div><div id="rows"></div><p class="bn">Chạm vào một chuyến để xem chi tiết</p></div></div></section>
@if(filled($page?->policy_content_override))
<section class="body policy-editable-content" aria-label="Policy content"><x-markdown-renderer :content="$page->policy_content_override" /></section>
@else
<div class="toolbar"><p>06 CÁC MỤC</p><button class="btn-ghost" id="toggleAll" type="button">Mở tất cả</button></div>
<section class="gates" aria-label="Nội dung"><details class="gate" id="s1" open><summary><span class="code">01</span><h2>Về sản phẩm hoa tươi</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Hoa tươi là sản phẩm tự nhiên, vì vậy cần được kiểm tra ngay khi nhận và bảo quản đúng cách.</p><p>Mỗi cành hoa đều có đặc tính và độ bền riêng. Là sản phẩm tự nhiên, hoa tươi có vòng đời ngắn và trạng thái của hoa có thể thay đổi theo quá trình vận chuyển, nhiệt độ và cách chăm sóc sau khi giao nhận.</p><p>Vì vậy, việc kiểm tra ngay khi nhận hàng và duy trì điều kiện bảo quản phù hợp là yếu tố quan trọng để đảm bảo chất lượng hoa. Chính sách khiếu nại của LNT được xây dựng dựa trên những đặc tính riêng này.</p></div></details>
<details class="gate" id="s2"><summary><span class="code">02</span><h2>Khi nào LNT tiếp nhận phản hồi?</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Phản hồi về chất lượng cần được gửi trong 02 giờ đầu tiên kể từ khi hoàn tất giao hàng.</p><p>Mọi phản hồi liên quan đến chất lượng đơn hàng cần được gửi đến LNT <strong>trong 02 giờ đầu tiên kể từ khi hoàn tất giao hàng</strong>. Khoảng thời gian này là cơ sở để LNT đánh giá chính xác tình trạng hoa tại thời điểm bàn giao.</p><p>Với các đơn hàng vận chuyển đến tỉnh/thành khác bằng xe khách hoặc máy bay, khách hàng vui lòng nhận hàng ngay sau khi nhận được thông báo từ đơn vị vận chuyển. LNT không thể đảm bảo chất lượng đối với hoa bị lưu giữ trong thời gian dài tại bến xe, sân bay hoặc điểm trung chuyển.</p></div></details>
<details class="gate" id="s3"><summary><span class="code">03</span><h2>Thông tin cần có khi phản hồi</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Quay ảnh/video khi mở hàng, giữ nguyên hiện trạng hoa, phản hồi đúng hạn và bảo quản đúng cách.</p><p>Để việc kiểm tra được thực hiện minh bạch và chính xác, khách hàng vui lòng lưu ý:</p><div class="cards"><div class="card"><h3>Ghi nhận tình trạng ngay khi mở kiện hàng</h3><p>Hình ảnh hoặc video cần được thực hiện trong quá trình mở hàng và thể hiện rõ phần hoa có dấu hiệu lỗi hoặc hư hỏng.</p></div><div class="card"><h3>Giữ nguyên trạng sản phẩm</h3><p>Hoa cần được giữ nguyên như lúc nhận. Những sản phẩm đã được cắt ngắn, tuốt lá, cắt tỉa hoặc có tác động làm thay đổi hiện trạng sẽ không được tiếp nhận khiếu nại.</p></div><div class="card"><h3>Đúng thời hạn phản hồi</h3><p>Sau 02 giờ kể từ thời điểm nhận hàng, nếu không phát sinh phản hồi, đơn hàng được xác nhận là đã hoàn tất giao nhận.</p></div><div class="card"><h3>Đảm bảo điều kiện bảo quản</h3><p>Hoa cần được tháo nylon và đưa ra khỏi thùng/gói sau khi nhận. Các trường hợp ủ hoa trong thùng hoặc gói quá lâu, hoặc bảo quản không đúng cách, sẽ không thuộc phạm vi khiếu nại.</p></div></div></div></details>
<details class="gate" id="s4"><summary><span class="code">04</span><h2>Cách thức LNT xử lý</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">LNT kiểm tra thông tin, hình ảnh/video bạn cung cấp và xác nhận tình trạng trước khi đưa ra hướng xử lý.</p><p>Khi nhận được phản hồi, LNT sẽ kiểm tra thông tin cùng hình ảnh/video do khách hàng cung cấp và xác nhận tình trạng trước khi đưa ra hướng xử lý.</p><p>Trong trường hợp cần loại bỏ phần hoa bị ảnh hưởng, khách hàng chỉ thực hiện <strong>sau khi đã nhận được xác nhận từ CSKH</strong>.</p><p>Quá trình xử lý cần được ghi hình liên tục, đảm bảo có thể xác định rõ tình trạng và số lượng hoa bị hỏng.</p></div></details>
<details class="gate" id="s5"><summary><span class="code">05</span><h2>Nguyên tắc đánh giá</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Mỗi trường hợp được xem xét dựa trên tình trạng thực tế của hoa, thời điểm giao nhận và điều kiện bảo quản.</p><p>LNT xem xét từng trường hợp dựa trên tình trạng thực tế của hoa, thời điểm giao nhận và điều kiện bảo quản sau đó.</p><ul><li>Không tự ý cắt bỏ hoặc xử lý phần hoa bị ảnh hưởng trước khi trao đổi với CSKH.</li><li>Một mức độ dập, gãy nhẹ hoặc hao hụt nhất định có thể xảy ra trong quá trình vận chuyển và được xem là đặc tính trong giới hạn cho phép của hoa tươi.</li><li>Với hoa nhập khẩu, từng giống hoa có yêu cầu riêng về nhiệt độ và điều kiện bảo quản, bao gồm tulip, peony, mao lương, đậu thơm… Những trường hợp chất lượng hoa thay đổi do bảo quản sai nhiệt độ hoặc không đúng hướng dẫn sẽ không thuộc phạm vi trách nhiệm của LNT.</li><li>Hoa tươi luôn có sự biến thiên tự nhiên giữa từng mùa vụ và từng lô hàng. Màu sắc, thân, cành, lá và kích thước có thể có những khác biệt nhất định do thời tiết và điều kiện sinh trưởng. Nếu có yêu cầu cụ thể về đặc điểm của hoa, khách hàng vui lòng trao đổi trước thời điểm đặt hàng.</li></ul></div></details>
<details class="gate" id="s6"><summary><span class="code">06</span><h2>Liên hệ hỗ trợ</h2><span class="chev" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 14 14"><path d="M2 5l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span></summary><div class="body"><p class="tldr">Gặp vấn đề với đơn hàng? Liên hệ ngay với chúng tôi.</p><p>Thông tin điện thoại, Zalo và email mới nhất được hiển thị bên dưới.</p><p>Mọi vấn đề phát sinh sẽ được chúng tôi tiếp nhận và xử lý trên tinh thần minh bạch, hợp lý và thiện chí.</p></div></details></section>
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
.visual{position:relative;min-width:0}
.board{background:var(--board);border-radius:22px;padding:clamp(1rem,2.2vw,1.5rem);box-shadow:0 30px 60px -30px var(--shadow);position:relative;z-index:1}
.board::before{content:"";position:absolute;inset:8px;border:1.5px solid rgba(226,174,132,.25);border-radius:16px;pointer-events:none}
.bh{display:flex;justify-content:space-between;color:var(--tile-acc);font-weight:600;letter-spacing:.2em;font-size:.82rem;margin:.2rem .3rem .8rem}
.bh time{color:#BFA493;letter-spacing:.12em}
.cols,.row{display:grid;grid-template-columns:6fr 10fr 11fr;gap:clamp(.5rem,1.2vw,1rem)}
.cols{color:#B08C70;font-size:.66rem;letter-spacing:.16em;margin:0 .3rem .45rem}
.row{width:100%;background:none;border:0;padding:.3rem;border-radius:10px;cursor:pointer;font:inherit;text-align:left}
.row:hover,.row:focus-visible{background:rgba(226,174,132,.08);outline:none}.row:focus-visible{box-shadow:0 0 0 2px var(--tile-acc)}
.cells{display:flex;gap:3px}
.f{position:relative;flex:1 1 0;min-width:0;aspect-ratio:.66;background:var(--tile);border-radius:4px;display:grid;place-items:center;font-weight:600;font-size:clamp(.72rem,1.2vw,1.05rem);color:var(--tile-ink);overflow:hidden}
.f::after{content:"";position:absolute;left:0;right:0;top:50%;height:1.5px;background:#0A0705}
.st .f{color:var(--tile-acc)}
.f.flip{animation:flap .09s linear}@keyframes flap{50%{transform:scaleY(.15)}}
.bn{color:#B08C70;font-size:.74rem;margin:.8rem .3rem 0}
.bloom{position:absolute;right:-24px;top:-66px;width:clamp(120px,14vw,170px);aspect-ratio:1;border-radius:50%;object-fit:cover;box-shadow:0 0 0 6px var(--bg),0 0 0 7.5px var(--copper);z-index:0}
@media (max-width:900px){.bloom{display:none}}
@media (max-width:620px){.cols,.row{grid-template-columns:10fr 11fr}.cols span:first-child,.row>.cells:first-child{display:none}.cells{gap:2px}.f{font-size:.62rem;border-radius:3px}}
</style>
@endpush

@push('scripts')
<script>
(function(){const b=document.getElementById('toggleAll');if(!b)return;const g=[...document.querySelectorAll('.gate')];
function upd(){const all=g.every(d=>d.open);b.textContent=all?'Thu gọn tất cả':'Mở tất cả';b.setAttribute('aria-expanded',all)}
b.addEventListener('click',()=>{const all=g.every(d=>d.open);g.forEach(d=>d.open=!all);upd()});g.forEach(d=>d.addEventListener('toggle',upd));upd();
if(location.hash){const t=document.querySelector(location.hash);if(t&&t.tagName==='DETAILS')t.open=true}})();
</script>
<script>const ROWS=[["s1", "LNT 01", "SẢN PHẨM", "HOA TƯƠI"], ["s2", "LNT 02", "PHẢN HỒI", "TRONG 2 GIỜ"], ["s3", "LNT 03", "MINH CHỨNG", "ẢNH, VIDEO"], ["s4", "LNT 04", "XỬ LÝ", "MINH BẠCH"], ["s5", "LNT 05", "ĐÁNH GIÁ", "THỰC TẾ"], ["s6", "LNT 06", "LIÊN HỆ", "HỖ TRỢ"]];
const COLS=[6,10,11],CH='ABCDEGHIKLMNOPQRSTUVXYĐƯƠÔÂÊ0123456789',rows=document.getElementById('rows'),red=matchMedia('(prefers-reduced-motion: reduce)').matches;
function cells(t,n,c){const w=document.createElement('div');w.className='cells '+(c||'');t=t.padEnd(n,' ');for(let i=0;i<n;i++){const s=document.createElement('span');s.className='f';s.dataset.c=t[i];s.textContent=red?t[i]:'';w.appendChild(s)}return w}
ROWS.forEach(([id,c,d,s])=>{const b=document.createElement('button');b.type='button';b.className='row';b.setAttribute('aria-label',c+' '+d+': '+s.toLowerCase());
b.append(cells(c,6),cells(d,10),cells(s,11,'st'));b.onclick=()=>{const g=document.getElementById(id);g.open=true;g.scrollIntoView({block:'start'});g.querySelector('summary').focus({preventScroll:true})};rows.appendChild(b)});
if(!red)document.querySelectorAll('.f').forEach((s,i)=>{const t=s.dataset.c;let n=6+Math.floor(Math.random()*10)+Math.floor(i%27/3);setTimeout(function k(){if(n--<=0||t===' '){s.textContent=t;return}s.textContent=CH[Math.floor(Math.random()*CH.length)];s.classList.remove('flip');void s.offsetWidth;s.classList.add('flip');setTimeout(k,70)},250+(i%27)*25)});
const ck=document.getElementById('clock');function tk(){ck.textContent=new Date().toLocaleTimeString('vi-VN',{hour:'2-digit',minute:'2-digit'})}tk();setInterval(tk,30000);</script>
@endpush
