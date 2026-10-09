@extends('layouts.app')

@section('title', 'Hộp hoa bí ẩn · Lâm Nhiên Thảo')

@section('skip-main-wrapper', true)

@section('content')
<main class="wrap">
<header class="top"><div><img class="logo" src="{{ asset('images/brand/lnt-logo.png') }}" alt="Lâm Nhiên Thảo"><p class="eyebrow">MYSTERY BOX</p><h1>Hộp hoa bí ẩn</h1>
<p class="lead">Tám món đồ đang ẩn mình trong căn phòng bí mật. Mỗi món giữ một điều bạn muốn gửi gắm cho hộp hoa: tông màu, loài hoa, phong cách, sở thích… Tìm đủ, rồi dùng chiếc chìa khoá cuối cùng để khoá căn phòng lại.</p></div>
<div class="tools"><button class="btn" id="hint" type="button">💡 Gợi ý</button><button class="btn" id="reveal" type="button">Hiện tất cả món đồ</button></div></header>
<div class="stage" id="stage"><svg class="scene" id="scene" viewBox="0 0 1200 680" role="group" aria-label="Căn phòng bí mật. Tìm 6 món đồ ẩn.">
<defs>
 <linearGradient id="wall" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#F3E7DD"/><stop offset="1" stop-color="#EBDACC"/></linearGradient>
 <linearGradient id="glass" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#E8EFE3"/><stop offset="1" stop-color="#CFDCC6"/></linearGradient>
 <linearGradient id="lampc" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="rgba(255,228,184,.7)"/><stop offset="1" stop-color="rgba(255,228,184,0)"/></linearGradient>
 <linearGradient id="floor" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#C9A07E"/><stop offset="1" stop-color="#B78C6A"/></linearGradient>
</defs>
<!-- wall & wainscot -->
<rect width="1200" height="520" fill="url(#wall)"/>
<rect y="410" width="1200" height="110" fill="#E5D2C2"/><g stroke="#D8C2B0" stroke-width="2">
 <line x1="0" y1="410" x2="1200" y2="410"/><path d="M40 425h140v80H40zM220 425h140v80H220zM400 425h140v80H400zM580 425h140v80H580zM760 425h140v80H760zM940 425h140v80H940z" fill="none"/></g>
<!-- floor -->
<rect y="520" width="1200" height="160" fill="url(#floor)"/><g stroke="#A97E5E" stroke-width="1.5" opacity=".6"><line x1="0" y1="560" x2="1200" y2="560"/><line x1="0" y1="605" x2="1200" y2="605"/><line x1="0" y1="650" x2="1200" y2="650"/>
 <line x1="180" y1="520" x2="180" y2="560"/><line x1="520" y1="520" x2="520" y2="560"/><line x1="900" y1="520" x2="900" y2="560"/><line x1="320" y1="560" x2="320" y2="605"/><line x1="760" y1="560" x2="760" y2="605"/><line x1="90" y1="605" x2="90" y2="650"/><line x1="610" y1="605" x2="610" y2="650"/><line x1="1050" y1="605" x2="1050" y2="650"/></g>
<!-- window -->
<path d="M140 360V180a120 120 0 0 1 240 0v180z" fill="#D9C4B2"/>
<path d="M156 352V182a104 104 0 0 1 208 0v170z" fill="url(#glass)"/>
<g fill="#9DAE84" opacity=".9"><circle cx="190" cy="300" r="46"/><circle cx="250" cy="320" r="38"/><circle cx="320" cy="290" r="50"/><circle cx="215" cy="250" r="30"/></g>
<g fill="#E6B8B0"><circle cx="205" cy="270" r="7"/><circle cx="300" cy="262" r="6"/><circle cx="330" cy="300" r="7"/></g>
<path d="M260 82v270M156 240h208" stroke="#D9C4B2" stroke-width="8"/>
<rect x="126" y="352" width="268" height="16" rx="4" fill="#CDB49F"/>
<!-- plant pot on sill -->
<path d="M170 352l6-30h40l6 30z" fill="#C78E66"/><g fill="#7E8A52"><ellipse cx="186" cy="312" rx="10" ry="18" transform="rotate(-25 186 312)"/><ellipse cx="206" cy="308" rx="10" ry="20" transform="rotate(20 206 308)"/></g>
<!-- coat hook & hat -->
<rect x="40" y="190" width="70" height="10" rx="4" fill="#B28A6C"/><circle cx="58" cy="206" r="5" fill="#9C7458"/><circle cx="92" cy="206" r="5" fill="#9C7458"/>
<path d="M52 210c-14 4-20 22-2 26 14 3 34 2 46-4 12-8 0-22-12-22z" fill="#A86E4E"/><path d="M58 220c4-14 26-14 30 0" fill="#BD8662"/>
<!-- wall clock -->
<circle cx="620" cy="130" r="48" fill="#FCF6EF" stroke="#B28A6C" stroke-width="7"/><g stroke="#8C6E5C" stroke-width="3" stroke-linecap="round"><line x1="620" y1="130" x2="620" y2="100"/><line x1="620" y1="130" x2="642" y2="140"/></g>
<g fill="#B28A6C"><circle cx="620" cy="90" r="3"/><circle cx="660" cy="130" r="3"/><circle cx="620" cy="170" r="3"/><circle cx="580" cy="130" r="3"/></g>
<!-- picture frames -->
<rect x="450" y="200" width="100" height="120" rx="4" fill="#B28A6C"/><rect x="460" y="210" width="80" height="100" fill="#E9D9C6"/>
<g fill="#C79A8F"><circle cx="490" cy="250" r="16"/><circle cx="512" cy="262" r="12"/></g><path d="M498 270v30" stroke="#7E8A52" stroke-width="3"/>
<rect x="690" y="220" width="86" height="70" rx="4" fill="#B28A6C"/><rect x="698" y="228" width="70" height="54" fill="#DCE3D2"/><path d="M698 282l22-26 18 18 12-12 18 20z" fill="#9DAE84"/>
<!-- hanging plant -->
<line x1="850" y1="0" x2="850" y2="110" stroke="#9C7458" stroke-width="2"/><path d="M826 110h48l-6 30h-36z" fill="#D3B48F"/>
<g fill="#7E8A52"><ellipse cx="830" cy="150" rx="7" ry="20"/><ellipse cx="846" cy="158" rx="6" ry="26"/><ellipse cx="866" cy="150" rx="7" ry="22"/><ellipse cx="880" cy="140" rx="6" ry="16"/></g>
<!-- bookshelf -->
<rect x="900" y="70" width="240" height="440" rx="6" fill="#A97E5E"/><rect x="914" y="84" width="212" height="412" fill="#8E6649"/>
<g fill="#A97E5E"><rect x="914" y="180" width="212" height="10"/><rect x="914" y="290" width="212" height="10"/><rect x="914" y="400" width="212" height="10"/></g>
<g><rect x="922" y="112" width="18" height="68" fill="#C79A8F"/><rect x="942" y="104" width="14" height="76" fill="#E6D3C6"/><rect x="958" y="120" width="20" height="60" fill="#9AA07A"/><rect x="980" y="108" width="16" height="72" fill="#C98E6A"/>
<rect x="1040" y="140" width="34" height="40" rx="6" fill="#DCE3D2" opacity=".9"/><rect x="1080" y="128" width="30" height="52" rx="4" fill="#D3B48F"/></g>
<g><rect x="920" y="222" width="60" height="68" fill="#E7D5C7"/><circle cx="950" cy="250" r="14" fill="#C79A8F"/><rect x="990" y="226" width="16" height="64" fill="#A86E4E"/><rect x="1008" y="236" width="18" height="54" fill="#E6D3C6"/>
<path d="M1050 290l10-40h40l10 40z" fill="#B9A487"/><g fill="#7E8A52"><circle cx="1068" cy="244" r="9"/><circle cx="1086" cy="238" r="11"/></g></g>
<g><rect x="924" y="330" width="14" height="70" fill="#9AA07A"/><rect x="940" y="338" width="20" height="62" fill="#C98E6A"/><rect x="962" y="328" width="16" height="72" fill="#E6D3C6"/>
<rect x="1000" y="350" width="50" height="50" rx="8" fill="#C79A8F"/><rect x="1060" y="340" width="56" height="60" rx="4" fill="#E7D5C7"/><circle cx="1088" cy="370" r="12" fill="#C98E6A"/></g>
<g><rect x="924" y="440" width="70" height="56" fill="#B98C7C"/><rect x="1000" y="452" width="40" height="44" fill="#E6D3C6"/><rect x="1046" y="436" width="18" height="60" fill="#9AA07A"/><rect x="1068" y="444" width="16" height="52" fill="#C98E6A"/></g>
<!-- rug -->
<ellipse cx="620" cy="604" rx="340" ry="56" fill="#B5776A"/><ellipse cx="620" cy="604" rx="300" ry="44" fill="none" stroke="#E7C6B6" stroke-width="3" stroke-dasharray="10 8"/>
<!-- armchair -->
<rect x="96" y="388" width="248" height="70" rx="30" fill="#9AA07A"/><rect x="80" y="430" width="60" height="110" rx="24" fill="#8A9068"/><rect x="300" y="430" width="60" height="110" rx="24" fill="#8A9068"/>
<rect x="120" y="440" width="200" height="70" rx="20" fill="#A7AD86"/><rect x="120" y="500" width="220" height="40" rx="10" fill="#8A9068"/><g stroke="#6E7450" stroke-width="5"><line x1="110" y1="540" x2="110" y2="566"/><line x1="330" y1="540" x2="330" y2="566"/></g>
<rect x="196" y="420" width="62" height="44" rx="12" fill="#E7C6B6" transform="rotate(-8 227 442)"/>
<!-- desk -->
<rect x="430" y="398" width="360" height="18" rx="4" fill="#A97E5E"/><g fill="#8E6649"><rect x="446" y="416" width="14" height="140"/><rect x="760" y="416" width="14" height="140"/></g>
<rect x="600" y="416" width="160" height="50" fill="#9C7458"/><circle cx="680" cy="441" r="5" fill="#E2C8A8"/>
<!-- vase of flowers on desk -->
<path d="M690 398c-14-6-14-46 4-56h22c18 10 18 50 4 56z" fill="#DCE3D2" opacity=".95"/>
<g stroke="#7E8A52" stroke-width="3"><path d="M705 344l-14-50M705 344l4-60M705 344l20-46"/></g>
<g fill="#D7A3A0"><circle cx="690" cy="290" r="16"/><circle cx="709" cy="280" r="18"/><circle cx="726" cy="296" r="15"/></g><g fill="#F3E2D2"><circle cx="690" cy="290" r="6"/><circle cx="709" cy="280" r="7"/><circle cx="726" cy="296" r="5"/></g>
<!-- books on desk -->
<rect x="610" y="378" width="60" height="10" fill="#C98E6A"/><rect x="614" y="368" width="54" height="10" fill="#E6D3C6"/><rect x="606" y="388" width="66" height="10" fill="#9AA07A"/>
<!-- lamp light -->
<path d="M462 312h60l70 86H392z" fill="url(#lampc)"/>


<!-- decor (not interactive) -->
<g><path d="M516 398c0-20 10-28 26-28s26 8 26 28z" fill="#8F5B47"/><circle cx="542" cy="388" r="9" fill="#E9D3BD"/><path d="M512 368c6-10 54-10 60 0l-4 6c-14-6-38-6-52 0z" fill="#7A4A38"/></g>
<g><rect x="808" y="276" width="44" height="50" rx="4" fill="#FCF6EF" stroke="#D9C3AF"/><rect x="808" y="276" width="44" height="13" rx="3" fill="#C78E66"/><g fill="#C9B3A0"><rect x="814" y="295" width="7" height="6"/><rect x="826" y="295" width="7" height="6"/><rect x="838" y="295" width="7" height="6"/><rect x="814" y="306" width="7" height="6"/><rect x="826" y="306" width="7" height="6"/><rect x="838" y="306" width="7" height="6"/></g></g>
<!-- 1 palette: on desk between lamp and books -->
<g class="hid" data-f="color" tabindex="0" role="button" aria-label="Món đồ ẩn">
 <circle class="hit" cx="580" cy="390" r="30"/>
 <g class="obj"><path d="M560 396c-6-10 4-20 22-20 16 0 24 8 22 14-2 5-8 3-10 7s4 7-4 9c-10 2-26 0-30-10z" fill="#EFE3D3" stroke="#CDB59E"/><g><circle cx="572" cy="386" r="3.4" fill="#D7A3A0"/><circle cx="582" cy="382" r="3.4" fill="#C98E6A"/><circle cx="592" cy="385" r="3.4" fill="#9AA07A"/><circle cx="569" cy="394" r="3.4" fill="#B98CB4"/></g></g>
 <circle class="hint-ring" cx="580" cy="390" r="14"/></g>
<!-- lamp after palette -->
<path d="M470 398h44l-8-10h-28z" fill="#8E6649"/><rect x="488" y="300" width="8" height="90" fill="#8E6649"/><path d="M456 312l14-56h44l14 56z" fill="#EAD7BE"/>
<!-- 2 botanical book: on top of bookshelf -->
<g class="hid" data-f="flower" tabindex="0" role="button" aria-label="Món đồ ẩn">
 <circle class="hit" cx="972" cy="58" r="32"/>
 <g class="obj"><rect x="944" y="54" width="58" height="14" rx="2" fill="#7E8A52"/><rect x="948" y="44" width="52" height="12" rx="2" fill="#E6D3C6"/><circle cx="974" cy="50" r="4" fill="#D7A3A0"/><path d="M974 54v4" stroke="#7E8A52" stroke-width="1.5"/></g>
 <circle class="hint-ring" cx="972" cy="58" r="14"/></g>
<!-- 3 style: small oval frame left wall -->
<g class="hid" data-f="style" tabindex="0" role="button" aria-label="Món đồ ẩn">
 <circle class="hit" cx="80" cy="300" r="34"/>
 <g class="obj"><ellipse cx="80" cy="300" rx="22" ry="28" fill="#B28A6C"/><ellipse cx="80" cy="300" rx="16" ry="22" fill="#F1E2D4"/><circle cx="76" cy="296" r="5" fill="#C79A8F"/><circle cx="85" cy="300" r="4" fill="#D7A3A0"/><path d="M80 304v12" stroke="#7E8A52" stroke-width="2"/><line x1="80" y1="260" x2="80" y2="272" stroke="#9C7458" stroke-width="1.5"/></g>
 <circle class="hint-ring" cx="80" cy="300" r="14"/></g>
<!-- 4 interest: vinyl record behind desk leg -->
<g class="hid" data-f="interest" tabindex="0" role="button" aria-label="Món đồ ẩn">
 <circle class="hit" cx="796" cy="516" r="32"/>
 <g class="obj"><circle cx="796" cy="516" r="22" fill="#2E2420"/><circle cx="796" cy="516" r="15" fill="none" stroke="#4A3A32" stroke-width="1.5"/><circle cx="796" cy="516" r="7" fill="#C78E66"/><circle cx="796" cy="516" r="1.6" fill="#2E2420"/></g>
 <circle class="hint-ring" cx="796" cy="516" r="14"/></g>
<rect x="760" y="416" width="14" height="140" fill="#8E6649"/>
<!-- 5 budget: piggy bank under armchair -->
<g class="hid" data-f="budget" tabindex="0" role="button" aria-label="Món đồ ẩn">
 <circle class="hit" cx="226" cy="556" r="30"/>
 <g class="obj"><ellipse cx="226" cy="556" rx="20" ry="13" fill="#E3AFA8"/><circle cx="244" cy="553" r="6" fill="#E3AFA8"/><circle cx="247" cy="553" r="1.4" fill="#8F5B47"/><path d="M214 545l4-6 4 6z" fill="#D59A92"/><rect x="222" y="543" width="9" height="2.4" rx="1" fill="#8F5B47"/><g fill="#D59A92"><rect x="212" y="565" width="5" height="6"/><rect x="234" y="565" width="5" height="6"/></g></g>
 <circle class="hint-ring" cx="226" cy="556" r="14"/></g>
<!-- 6 surprise: small gift on window sill behind plant leaves -->
<g class="hid" data-f="surprise" tabindex="0" role="button" aria-label="Món đồ ẩn">
 <circle class="hit" cx="350" cy="336" r="30"/>
 <g class="obj"><rect x="334" y="328" width="32" height="24" rx="2" fill="#C79A8F"/><rect x="331" y="322" width="38" height="9" rx="2" fill="#B98C7C"/><rect x="347" y="322" width="6" height="30" fill="#F3E2D2"/><path d="M350 322c-8-10-18-7-15-2 2 4 10 3 15 2zM350 322c8-10 18-7 15-2-2 4-10 3-15 2z" fill="#F3E2D2"/></g>
 <circle class="hint-ring" cx="350" cy="336" r="14"/></g>
<g fill="#7E8A52"><ellipse cx="372" cy="318" rx="8" ry="20" transform="rotate(25 372 318)"/></g>
<!-- 7 note: notebook + pen on armchair -->
<g class="hid" data-f="note" tabindex="0" role="button" aria-label="Món đồ ẩn">
 <circle class="hit" cx="282" cy="486" r="32"/>
 <g class="obj" transform="rotate(10 282 485)"><rect x="262" y="468" width="38" height="32" rx="3" fill="#A86E4E"/><rect x="266" y="470" width="32" height="28" rx="2" fill="#FBF4EC"/><g stroke="#C9B3A0" stroke-width="1.4"><line x1="270" y1="478" x2="294" y2="478"/><line x1="270" y1="484" x2="294" y2="484"/><line x1="270" y1="490" x2="288" y2="490"/></g>
 <line x1="296" y1="468" x2="316" y2="450" stroke="#7A4A38" stroke-width="4" stroke-linecap="round"/></g>
 <circle class="hint-ring" cx="282" cy="486" r="14"/></g>
<!-- 8 confirm: key under rug -->
<g class="hid" data-f="confirm" tabindex="0" role="button" aria-label="Món đồ ẩn">
 <circle class="hit" cx="905" cy="620" r="34"/>
 <g class="obj" transform="rotate(-18 905 620)"><circle cx="890" cy="620" r="9" fill="none" stroke="#D9A85E" stroke-width="5"/><rect x="898" y="617" width="30" height="6" rx="2" fill="#D9A85E"/><rect x="918" y="622" width="5" height="8" fill="#D9A85E"/><rect x="926" y="622" width="4" height="6" fill="#D9A85E"/></g>
 <circle class="hint-ring" cx="905" cy="620" r="14"/></g>
<path d="M922 612c20 6 30 14 36 20" stroke="#B5776A" stroke-width="10" fill="none" opacity=".95"/>
<!-- final box -->
<g id="mbox" opacity="0" transform="translate(600 560)">
 <rect x="-60" y="-70" width="120" height="80" rx="6" fill="#C98E6A"/><rect x="-68" y="-90" width="136" height="24" rx="6" fill="#B87A56"/>
 <rect x="-7" y="-90" width="14" height="100" fill="#F3E2D2"/><path d="M0-90c-18-22-40-16-34-4 4 8 22 6 34 4zM0-90c18-22 40-16 34-4-4 8-22 6-34 4z" fill="#F3E2D2"/>
 <circle cx="0" cy="-30" r="15" fill="#9A5A40"/><text x="0" y="-26" text-anchor="middle" font-size="10" font-weight="600" fill="#F6E3D3" font-family="Josefin Sans,sans-serif">LNT</text></g>
</svg></div>
<div class="list" id="list" aria-label="Các món đồ cần tìm"></div>
<div class="status"><p id="ptext"></p><span class="note">Thông tin nhận hàng chỉ dùng để xử lý đơn · <a href="{{ route('policy.baomat') }}">Chính sách bảo mật</a></span>
<button class="btn primary" id="send" type="button" disabled>Niêm phong &amp; gửi hộp hoa</button></div>
</main>
@endsection

@push('styles')
<style>

:root{--bg:#F5EBE6;--paper:#FCF8F5;--ink:#5E4636;--soft:#8C6E5C;--copper:#C78E66;--deep:#A8714E;--line:#E6D3C6;--dark:#2B201B;--shadow:rgba(120,80,55,.2);
--sans:"Josefin Sans","Avenir Next","Century Gothic",system-ui,sans-serif;--serif:"Lora",Georgia,"Times New Roman",serif;
box-sizing:border-box;padding-top:env(safe-area-inset-top,0px);padding-bottom:env(safe-area-inset-bottom,0px)}
@media (prefers-color-scheme:dark){:root:not([data-theme="light"]){--bg:#211915;--paper:#2C231F;--ink:#EEDFD4;--soft:#BFA493;--copper:#D9A47E;--deep:#E2B28E;--line:#433630;--shadow:rgba(0,0,0,.45)}}
:root[data-theme="dark"]{--bg:#211915;--paper:#2C231F;--ink:#EEDFD4;--soft:#BFA493;--copper:#D9A47E;--deep:#E2B28E;--line:#433630;--shadow:rgba(0,0,0,.45)}
*,*::before,*::after{box-sizing:inherit}
body{margin:0;background:var(--bg);color:var(--ink);font-family:var(--sans);-webkit-font-smoothing:antialiased}
.wrap{max-width:1200px;margin:0 auto;padding:0 clamp(1rem,4vw,3rem)}
header.top{display:flex;justify-content:space-between;align-items:flex-end;gap:1.5rem;flex-wrap:wrap;padding:clamp(2rem,5vw,3.6rem) 0 1.2rem}
.logo{width:80px;display:block;margin-bottom:1.2rem}
.eyebrow{font-size:.8rem;letter-spacing:.28em;color:var(--deep);display:flex;align-items:center;gap:.9rem;margin:0 0 .7rem}
.eyebrow::after{content:"";width:64px;height:1.5px;background:currentColor}
h1{margin:0;font-weight:600;text-transform:uppercase;color:var(--copper);font-size:clamp(1.9rem,3.8vw,3rem);line-height:1.05}
.lead{font-family:var(--serif);font-style:italic;color:var(--deep);font-size:clamp(1rem,1.3vw,1.12rem);line-height:1.65;margin:.9rem 0 0;max-width:36em}
.tools{display:flex;gap:.6rem;flex-wrap:wrap}
.btn{font:inherit;font-size:.92rem;border-radius:999px;padding:.65rem 1.1rem;cursor:pointer;border:1.5px solid var(--line);background:var(--paper);color:var(--deep)}
.btn.primary{background:var(--copper);border-color:var(--copper);color:#fff;font-weight:600}
.btn:focus-visible{outline:2px solid var(--deep);outline-offset:2px}.btn:disabled{opacity:.45;cursor:not-allowed}
.stage{position:relative;border-radius:26px;overflow:hidden;box-shadow:0 40px 80px -40px var(--shadow);background:#EADBCF}
svg.scene{display:block;width:100%;height:auto}
.hid{cursor:pointer;outline:none}
.hid .hit{fill:transparent}
.hid:focus-visible .hit{stroke:#C78E66;stroke-width:3;stroke-dasharray:6 5}
.hid.found .obj{filter:drop-shadow(0 0 6px rgba(255,214,160,.95))}
.hint-ring{fill:none;stroke:#FFF3E3;stroke-width:4;opacity:0;pointer-events:none}
.hint-ring.on{animation:ring 1.4s ease-out 2}
@keyframes ring{0%{opacity:.95;r:14}100%{opacity:0;r:60}}
.spark{pointer-events:none}
.miss{position:absolute;pointer-events:none;font-family:var(--serif);font-style:italic;color:#fff;font-size:.9rem;text-shadow:0 1px 4px rgba(0,0,0,.4);animation:miss .9s ease-out forwards}
@keyframes miss{to{transform:translateY(-24px);opacity:0}}
/* list bar */
.list{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:.6rem;margin:1rem 0 .4rem}
.slot{all:unset;cursor:pointer;display:grid;justify-items:center;gap:.35rem;background:var(--paper);border:1.5px dashed var(--line);border-radius:16px;padding:.7rem .4rem .6rem;text-align:center}
.slot:focus-visible{outline:2px solid var(--deep);outline-offset:2px}
.slot svg{width:42px;height:42px;opacity:.35;filter:grayscale(1)}
.slot b{font-size:.74rem;letter-spacing:.06em;color:var(--soft);font-weight:600}
.slot small{font-family:var(--serif);font-style:italic;font-size:.78rem;color:var(--deep);min-height:1.1em}
.slot.found{border-style:solid;border-color:var(--copper)}.slot.found svg{opacity:1;filter:none}
.slot.done{background:color-mix(in srgb,var(--copper) 12%,var(--paper))}
.slot.done b{color:var(--ink)}
.status{display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin:.8rem 0 2.4rem}
.status p{margin:0;font-family:var(--serif);font-style:italic;color:var(--deep)}
.status .note{font-family:var(--sans);font-style:normal;font-size:.84rem;color:var(--soft)}.status a{color:var(--deep)}
/* panel */
.backdrop{position:absolute;inset:0;z-index:15;background:rgba(20,14,10,.35);backdrop-filter:blur(2px)}
.panel{position:absolute;z-index:20;left:50%;top:50%;width:min(420px,calc(100% - 2rem));transform:translate(-50%,-50%);background:var(--paper);color:var(--ink);border-radius:22px;padding:1.3rem 1.4rem 1.2rem;box-shadow:0 40px 80px -30px rgba(0,0,0,.55);border:1px solid var(--line)}
.panel .k{font-size:.72rem;letter-spacing:.2em;color:var(--copper);margin:0 0 .2rem}
.panel label{display:block;font-weight:600;font-size:1.15rem;margin:0 0 .25rem}
.panel .help{font-family:var(--serif);font-style:italic;color:var(--soft);font-size:.92rem;margin:0 0 .8rem}
.panel input,.panel textarea{width:100%;font:inherit;font-size:1rem;color:var(--ink);background:var(--bg);border:1.5px solid var(--line);border-radius:12px;padding:.8rem .9rem;outline:none}
.panel textarea{min-height:96px;resize:vertical;font-family:var(--serif)}
.panel input:focus,.panel textarea:focus{border-color:var(--copper);box-shadow:0 0 0 3px color-mix(in srgb,var(--copper) 22%,transparent)}
.panel .err{color:#B04A3A;font-size:.85rem;min-height:1.1em;margin:.4rem 0 0}
.panel .row{display:flex;gap:.6rem;justify-content:flex-end;margin-top:.7rem}
/* quick form */
.quick{background:var(--paper);border:1px solid var(--line);border-radius:22px;padding:clamp(1.2rem,3vw,2rem);margin:0 0 1rem}
.quick h2{margin:0 0 1rem;font-size:1.1rem;color:var(--copper);letter-spacing:.1em}
.qgrid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.qgrid label{display:grid;gap:.35rem;font-size:.85rem;color:var(--soft)}
.qgrid input,.qgrid textarea{font:inherit;font-size:1rem;color:var(--ink);background:var(--bg);border:1.5px solid var(--line);border-radius:12px;padding:.75rem .9rem}
.qgrid .full{grid-column:1/-1}
.done-card{position:absolute;inset:0;z-index:30;display:grid;place-items:center;text-align:center;padding:2rem;background:rgba(43,32,27,.86);color:#F4E8DC}
.done-card h3{margin:.8rem 0 .4rem;font-size:clamp(1.4rem,3vw,2rem);color:#E2AE84;text-transform:uppercase;letter-spacing:.04em}
.done-card p{font-family:var(--serif);font-style:italic;max-width:30em;margin:0 auto;color:#D9C3AF}
.wax{width:96px;height:96px;border-radius:50%;margin:0 auto;display:grid;place-items:center;background:radial-gradient(circle at 35% 30%,#C98A66,#9A5A40 70%);color:#F6E3D3;font-weight:600;letter-spacing:.08em;box-shadow:0 10px 24px -10px rgba(0,0,0,.6);animation:pop .6s cubic-bezier(.3,1.6,.5,1)}
@keyframes pop{from{transform:scale(1.8);opacity:0}}
[hidden]{display:none!important}
@media (max-width:760px){.list{grid-template-columns:repeat(3,minmax(0,1fr))}.qgrid{grid-template-columns:1fr}
.panel{position:fixed;left:0;right:0;top:auto;bottom:0;transform:none;width:auto;border-radius:22px 22px 0 0;padding-bottom:calc(1.2rem + env(safe-area-inset-bottom,0px))}.backdrop{position:fixed}}
@media (prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important}}

.list{grid-template-columns:repeat(4,minmax(0,1fr))}
.req{color:var(--copper)}
.chips{display:flex;flex-wrap:wrap;gap:.5rem;margin:.2rem 0 .3rem}
.chip{font:inherit;font-size:.9rem;display:inline-flex;align-items:center;gap:.45rem;border:1.5px solid var(--line);background:var(--bg);color:var(--ink);border-radius:999px;padding:.5rem .85rem;cursor:pointer}
.chip[aria-pressed="true"]{border-color:var(--copper);background:color-mix(in srgb,var(--copper) 16%,var(--paper));color:var(--deep);font-weight:600}
.chip:focus-visible{outline:2px solid var(--deep);outline-offset:2px}
.sw{width:16px;height:16px;border-radius:50%;border:1px solid rgba(0,0,0,.12)}
.chip small{display:block;font-family:var(--serif);font-style:italic;font-weight:400;color:var(--soft);font-size:.78rem}
.chip.big{border-radius:14px;flex-direction:column;align-items:flex-start;gap:.1rem;padding:.6rem .85rem}
.panel{max-height:calc(100% - 2rem);overflow:auto;width:min(480px,calc(100% - 2rem))}
.panel .fgrid{display:grid;gap:.6rem}.panel .fgrid label{font-size:.82rem;font-weight:400;color:var(--soft);display:grid;gap:.3rem;margin:0}
.panel .extra{margin-top:.7rem}
.sum{background:var(--bg);border-radius:14px;padding:.8rem 1rem;margin:.2rem 0 .9rem;font-size:.88rem;color:var(--soft);display:grid;gap:.25rem}
.sum b{color:var(--ink);font-weight:600}
.panel .check{display:flex!important;gap:.5rem;align-items:flex-start;font-size:.88rem;font-weight:400;color:var(--soft);margin-top:.7rem}
.check input{width:auto;margin-top:.2rem;accent-color:var(--copper)}
.check a{color:var(--deep)}
@media (max-width:760px){.list{grid-template-columns:repeat(2,minmax(0,1fr))}.panel{max-height:85vh}}

</style>
@endpush

@push('scripts')
<script>
@php
  $mysteryColors = collect($mysteryContent['colors'])->values();
  $mysteryBudgets = collect($mysteryContent['budgets'])->values();
@endphp
const CONFIG={
 colors:@json($mysteryColors->map(fn ($color, $index) => [$color, ['#F6EFE4','#D9C3AF','#F2C4C4','#9AA07A','#9E2B33','#C9B3DA','linear-gradient(135deg,#F2C4C4,#C9B3DA,#F2A97E)'][$index % 7]])->all(),
 flowers:['Mẫu đơn','Tulip','Mao lương','Hồng Ecuador','Protea','Lan hồ điệp','Cẩm chướng','Cúc Malaysia','Ly','Không có yêu cầu'],
 styles:@json(collect($mysteryContent['styles'])->map(fn ($style) => [$style, ''])->all()),
 interests:@json(array_values($mysteryContent['preferences'])),
 budgets:@json($mysteryBudgets->pluck('label')->all()),
 budgetValues:@json($mysteryBudgets->pluck('value', 'label')->all()),
 surprises:@json(collect($mysteryContent['surprise_levels'])->map(fn ($level) => [$level, ''])->all())
};
const FIELDS=[
 {id:'color',obj:'Bảng màu',label:'Tông màu hoa',help:'Chọn tối đa 3 tông màu bạn muốn.',type:'chips',opts:CONFIG.colors.map(c=>({t:c[0],sw:c[1]})),multi:3,req:true},
 {id:'flower',obj:'Sách thực vật',label:'Loại hoa đặc biệt',help:'Loài hoa bạn mong có trong hộp, nếu có.',type:'chips',opts:CONFIG.flowers.map(t=>({t})),multi:4,req:false},
 {id:'style',obj:'Khung tranh',label:'Phong cách',help:'Bạn muốn hộp hoa mang cảm giác nào?',type:'chips',opts:CONFIG.styles.map(s=>({t:s[0],d:s[1]})),multi:1,req:true,big:true},
 {id:'interest',obj:'Đĩa nhạc',label:'Sở thích',help:'Người nhận (hoặc bạn) yêu thích điều gì? LNT sẽ dựa vào đó để chọn hoa và chi tiết đi kèm.',type:'chips',opts:CONFIG.interests.map(t=>({t})),multi:4,req:true,extra:'Kể thêm một chút (không bắt buộc)'},
 {id:'budget',obj:'Heo đất',label:'Ngân sách',help:'Chọn mức ngân sách cho hộp hoa.',type:'chips',opts:CONFIG.budgets.map(t=>({t})),multi:1,req:true},
 {id:'surprise',obj:'Hộp quà nhỏ',label:'Mức độ bất ngờ',help:'Bạn muốn bất ngờ đến đâu?',type:'chips',opts:CONFIG.surprises.map(s=>({t:s[0],d:s[1]})),multi:1,req:false,big:true},
 {id:'note',obj:'Cuốn sổ',label:'Lưu ý',help:'Dị ứng phấn hoa, màu hay loài hoa muốn tránh, dịp tặng, lời nhắn kèm thiệp…',type:'textarea',req:false},
 {id:'confirm',obj:'Chiếc chìa khoá',label:'Xác nhận',help:'Thông tin nhận hàng. Chìa khoá cuối cùng để khoá căn phòng.',type:'contact',req:true}
];
const ICON={"color": "<svg viewBox=\"0 0 42 42\"><path d=\"M8 26c-4-10 4-18 15-18 10 0 15 5 13 10-1 3-6 2-7 5s3 5-3 6c-7 2-15 0-18-3z\" fill=\"#EFE3D3\" stroke=\"#CDB59E\"/><circle cx=\"16\" cy=\"18\" r=\"3\" fill=\"#D7A3A0\"/><circle cx=\"23\" cy=\"14\" r=\"3\" fill=\"#C98E6A\"/><circle cx=\"30\" cy=\"17\" r=\"3\" fill=\"#9AA07A\"/><circle cx=\"14\" cy=\"25\" r=\"3\" fill=\"#B98CB4\"/></svg>", "flower": "<svg viewBox=\"0 0 42 42\"><rect x=\"6\" y=\"22\" width=\"30\" height=\"10\" rx=\"2\" fill=\"#7E8A52\"/><rect x=\"8\" y=\"13\" width=\"26\" height=\"10\" rx=\"2\" fill=\"#E6D3C6\"/><circle cx=\"21\" cy=\"18\" r=\"3.4\" fill=\"#D7A3A0\"/></svg>", "style": "<svg viewBox=\"0 0 42 42\"><ellipse cx=\"21\" cy=\"21\" rx=\"12\" ry=\"15\" fill=\"#B28A6C\"/><ellipse cx=\"21\" cy=\"21\" rx=\"8\" ry=\"11\" fill=\"#F1E2D4\"/><circle cx=\"19\" cy=\"19\" r=\"3\" fill=\"#C79A8F\"/></svg>", "interest": "<svg viewBox=\"0 0 42 42\"><circle cx=\"21\" cy=\"21\" r=\"14\" fill=\"#2E2420\"/><circle cx=\"21\" cy=\"21\" r=\"9\" fill=\"none\" stroke=\"#4A3A32\"/><circle cx=\"21\" cy=\"21\" r=\"4.5\" fill=\"#C78E66\"/></svg>", "budget": "<svg viewBox=\"0 0 42 42\"><ellipse cx=\"20\" cy=\"23\" rx=\"13\" ry=\"9\" fill=\"#E3AFA8\"/><circle cx=\"32\" cy=\"21\" r=\"4\" fill=\"#E3AFA8\"/><rect x=\"16\" y=\"13\" width=\"7\" height=\"2\" fill=\"#8F5B47\"/><rect x=\"12\" y=\"30\" width=\"3\" height=\"5\" fill=\"#D59A92\"/><rect x=\"25\" y=\"30\" width=\"3\" height=\"5\" fill=\"#D59A92\"/></svg>", "surprise": "<svg viewBox=\"0 0 42 42\"><rect x=\"10\" y=\"17\" width=\"22\" height=\"17\" rx=\"2\" fill=\"#C79A8F\"/><rect x=\"8\" y=\"13\" width=\"26\" height=\"6\" rx=\"2\" fill=\"#B98C7C\"/><rect x=\"19\" y=\"13\" width=\"4\" height=\"21\" fill=\"#F3E2D2\"/><path d=\"M21 13c-6-7-12-5-10-1 1 3 7 2 10 1zM21 13c6-7 12-5 10-1-1 3-7 2-10 1z\" fill=\"#F3E2D2\"/></svg>", "note": "<svg viewBox=\"0 0 42 42\"><rect x=\"9\" y=\"10\" width=\"22\" height=\"24\" rx=\"2\" fill=\"#A86E4E\"/><rect x=\"12\" y=\"12\" width=\"18\" height=\"20\" fill=\"#FBF4EC\"/><path d=\"M14 18h14M14 22h14M14 26h10\" stroke=\"#C9B3A0\"/><path d=\"M30 12l6-6\" stroke=\"#7A4A38\" stroke-width=\"3\" stroke-linecap=\"round\"/></svg>", "confirm": "<svg viewBox=\"0 0 42 42\"><circle cx=\"13\" cy=\"21\" r=\"6\" fill=\"none\" stroke=\"#D9A85E\" stroke-width=\"4\"/><rect x=\"18\" y=\"19\" width=\"18\" height=\"4\" fill=\"#D9A85E\"/><rect x=\"30\" y=\"23\" width=\"3\" height=\"6\" fill=\"#D9A85E\"/></svg>"};
const $=s=>document.querySelector(s),data={},found=new Set(),reduce=matchMedia('(prefers-reduced-motion: reduce)').matches;let busy=false;
const byId=Object.fromEntries(FIELDS.map(f=>[f.id,f]));
function esc(s){return String(s).replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]))}
function short(f){const v=data[f.id];if(!v)return'';if(f.id==='confirm')return'Đã niêm phong ✓';if(f.type==='textarea')return'Đã ghi lại ✓';
 const t=v.sel.join(', ');return (t.length>26?t.slice(0,24)+'…':t)+' ✓'}
/* list */
FIELDS.forEach(f=>{const s=document.createElement('button');s.type='button';s.className='slot';s.dataset.id=f.id;
 s.innerHTML=`${ICON[f.id]}<b>${f.label}${f.req?' <span class="req">*</span>':''}</b><small data-s></small>`;
 s.onclick=()=>{if(found.has(f.id))openPanel(f,s);else hintFor(f.id)};$('#list').appendChild(s)});
/* scene */
document.querySelectorAll('.hid').forEach(g=>{const f=byId[g.dataset.f];
 const go=()=>{if(busy)return;if(!found.has(f.id)){found.add(f.id);g.classList.add('found');celebrate(g,()=>openPanel(f,g))}else openPanel(f,g)};
 g.addEventListener('click',e=>{e.stopPropagation();go()});g.addEventListener('keydown',e=>{if(e.key==='Enter'||e.key===' '){e.preventDefault();go()}})});
$('#scene').addEventListener('click',e=>{if(busy||reduce)return;const r=$('#stage').getBoundingClientRect();const m=document.createElement('span');m.className='miss';
 m.textContent=['Không phải đây…','Thử chỗ khác nhé','Hmm…'][Math.floor(Math.random()*3)];m.style.left=(e.clientX-r.left-40)+'px';m.style.top=(e.clientY-r.top-20)+'px';$('#stage').appendChild(m);setTimeout(()=>m.remove(),900)});
function celebrate(g,cb){if(reduce){cb();return}const ring=g.querySelector('.hint-ring');const cx=+ring.getAttribute('cx'),cy=+ring.getAttribute('cy');
 const ns='http://www.w3.org/2000/svg',grp=document.createElementNS(ns,'g');grp.setAttribute('class','spark');
 for(let k=0;k<10;k++){const c=document.createElementNS(ns,'circle');c.setAttribute('cx',cx);c.setAttribute('cy',cy);c.setAttribute('r',3);c.setAttribute('fill',k%2?'#FFE2B8':'#C78E66');grp.appendChild(c);
  const a=k/10*Math.PI*2;c.animate([{transform:'translate(0,0)',opacity:1},{transform:`translate(${Math.cos(a)*46}px,${Math.sin(a)*46}px)`,opacity:0}],{duration:650,easing:'ease-out',fill:'forwards'})}
 $('#scene').appendChild(grp);setTimeout(()=>{grp.remove();cb()},500)}
function hintFor(id){const g=document.querySelector(`.hid[data-f="${id}"] .hint-ring`);g.classList.remove('on');void g.getBoundingClientRect();g.classList.add('on')}
$('#hint').onclick=()=>{const left=FIELDS.filter(f=>!found.has(f.id));if(!left.length)return;hintFor(left[Math.floor(Math.random()*left.length)].id)};
$('#reveal').onclick=()=>{FIELDS.forEach(f=>{found.add(f.id);document.querySelector(`.hid[data-f="${f.id}"]`).classList.add('found');sync(f)})};
/* panel */
function body(f){const v=data[f.id]||{sel:[],extra:''};
 if(f.type==='chips')return`<div class="chips" role="group" aria-label="${esc(f.label)}">${f.opts.map(o=>`<button type="button" class="chip${f.big?' big':''}" aria-pressed="${v.sel.includes(o.t)}" data-t="${esc(o.t)}">${o.sw?`<span class="sw" style="background:${o.sw}"></span>`:''}${f.big?`<span>${esc(o.t)}<small>${esc(o.d)}</small></span>`:esc(o.t)}</button>`).join('')}</div>${f.extra?`<label class="extra" style="font-size:.85rem;font-weight:400;color:var(--soft)">${f.extra}<textarea id="pextra" maxlength="200" style="min-height:70px;margin-top:.3rem">${esc(v.extra||'')}</textarea></label>`:''}`;
 if(f.type==='textarea')return`<textarea id="pin" maxlength="400" aria-label="${esc(f.label)}">${esc(v.text||'')}</textarea>`;
 if(f.type==='contact'){const c=v.c||{};const t=new Date();t.setMinutes(t.getMinutes()-t.getTimezoneOffset());
  const rows=FIELDS.filter(x=>x.id!=='confirm'&&data[x.id]).map(x=>`<div><b>${x.label}:</b> ${esc(x.type==='textarea'?data[x.id].text:data[x.id].sel.join(', '))}</div>`).join('')||'<div>Bạn chưa chọn sở thích nào. LNT sẽ tự do sáng tạo.</div>';
  return`<div class="sum">${rows}</div><div class="fgrid">
  <label>Họ và tên *<input id="c_name" autocomplete="name" value="${esc(c.name||'')}"></label>
  <label>Số điện thoại / Zalo *<input id="c_phone" type="tel" autocomplete="tel" value="${esc(c.phone||'')}"></label>
  <label>Địa chỉ nhận hoa *<input id="c_addr" autocomplete="street-address" value="${esc(c.addr||'')}"></label>
  <label>Ngày nhận mong muốn *<input id="c_date" type="date" min="${t.toISOString().slice(0,10)}" value="${esc(c.date||'')}"></label>
  <label>Lưu ý thêm (không bắt buộc)<textarea id="c_note" maxlength="400" style="min-height:70px" placeholder="Dị ứng phấn hoa, màu hay loài hoa muốn tránh, dịp tặng, lời nhắn kèm thiệp…">${esc((data.note&&data.note.text)||'')}</textarea></label></div>
  <label class="check"><input type="checkbox" id="c_ok" ${c.ok?'checked':''}> <span>Tôi đã đọc <a href="/trang/chinh-sach-doi-tra" target="_blank" rel="noopener">chính sách đổi trả</a> và đồng ý để LNT liên hệ xác nhận đơn.</span></label>`}
}
function openPanel(f,from){busy=true;const stage=$('#stage');const bd=document.createElement('div');bd.className='backdrop';stage.appendChild(bd);
 const p=document.createElement('div');p.className='panel';p.setAttribute('role','dialog');p.setAttribute('aria-modal','true');p.setAttribute('aria-labelledby','pl');
 p.innerHTML=`<p class="k">BẠN ĐÃ TÌM THẤY · ${f.obj.toUpperCase()}</p><label id="pl">${f.label}${f.req?' *':''}</label><p class="help">${f.help}</p>${body(f)}<p class="err" id="perr" aria-live="polite"></p>
 <div class="row"><button class="btn" id="pc" type="button">Để sau</button><button class="btn primary" id="pok" type="button">${f.id==='confirm'?'Khoá căn phòng':'Cất giữ'}</button></div>`;
 stage.appendChild(p);
 p.querySelectorAll('.chip').forEach(ch=>ch.onclick=()=>{const on=ch.getAttribute('aria-pressed')==='true';const all=[...p.querySelectorAll('.chip')];
  if(f.multi===1){all.forEach(x=>x.setAttribute('aria-pressed','false'));ch.setAttribute('aria-pressed',!on);return}
  const cnt=all.filter(x=>x.getAttribute('aria-pressed')==='true').length;
  if(!on&&cnt>=f.multi){$('#perr').textContent=`Chọn tối đa ${f.multi} mục.`;return}$('#perr').textContent='';ch.setAttribute('aria-pressed',!on)});
 const first=p.querySelector('.chip,textarea,input');setTimeout(()=>first&&first.focus(),reduce?0:200);
 const close=saved=>{const fin=()=>{p.remove();bd.remove();busy=false;sync(f);from&&from.focus&&from.focus()};
  if(saved&&!reduce){const slot=document.querySelector(`.slot[data-id="${f.id}"]`).getBoundingClientRect(),r=p.getBoundingClientRect();const base=getComputedStyle(p).transform==='none'?'':getComputedStyle(p).transform;
   p.animate([{transform:base,opacity:1},{transform:`${base} translate(${slot.left+slot.width/2-(r.left+r.width/2)}px,${slot.top+slot.height/2-(r.top+r.height/2)}px) scale(.08)`,opacity:.2}],{duration:600,easing:'cubic-bezier(.5,0,.3,1)',fill:'forwards'}).onfinish=fin}else fin()};
 p.querySelector('#pc').onclick=()=>close(false);bd.onclick=()=>close(false);
 const err=m=>{$('#perr').textContent=m};
 p.querySelector('#pok').onclick=()=>{
  if(f.type==='chips'){const sel=[...p.querySelectorAll('.chip[aria-pressed="true"]')].map(x=>x.dataset.t);const extra=(p.querySelector('#pextra')||{}).value||'';
   if(f.req&&!sel.length)return err('Hãy chọn ít nhất một lựa chọn.');if(sel.length||extra.trim())data[f.id]={sel,extra:extra.trim()};else delete data[f.id]}
  else if(f.type==='textarea'){const t=p.querySelector('#pin').value.trim();if(t)data[f.id]={text:t};else delete data[f.id]}
  else{const g=id=>p.querySelector(id).value.trim();const c={name:g('#c_name'),phone:g('#c_phone'),addr:g('#c_addr'),date:g('#c_date'),ok:p.querySelector('#c_ok').checked};
   if(!c.name||!c.phone||!c.addr||!c.date)return err('Vui lòng điền đủ các thông tin có dấu *.');
   if(!/^[0-9+\s.-]{9,20}$/.test(c.phone))return err('Số điện thoại chưa đúng.');
   if(!c.ok)return err('Vui lòng xác nhận đã đọc chính sách.');
   const miss=FIELDS.filter(x=>x.req&&x.id!=='confirm'&&!data[x.id]).map(x=>x.label);if(miss.length)return err('Còn thiếu: '+miss.join(', ')+'. Hãy tìm món đồ tương ứng trong phòng.');
   const nt=p.querySelector('#c_note').value.trim();if(nt){data.note={text:nt};found.add('note');document.querySelector('.hid[data-f="note"]').classList.add('found');sync(byId.note)}else if(data.note){delete data.note;sync(byId.note)}
   data[f.id]={c}}
  close(true)};
 p.addEventListener('keydown',e=>{if(e.key==='Escape')close(false);if(e.key==='Tab'){const fs=[...p.querySelectorAll('input,textarea,button,a')],i=fs.indexOf(document.activeElement);
   if(e.shiftKey&&i===0){e.preventDefault();fs[fs.length-1].focus()}else if(!e.shiftKey&&i===fs.length-1){e.preventDefault();fs[0].focus()}}});
}
function sync(f){const s=document.querySelector(`.slot[data-id="${f.id}"]`),isF=found.has(f.id);s.classList.toggle('found',isF);s.classList.toggle('done',!!data[f.id]);
 s.querySelector('[data-s]').textContent=data[f.id]?short(f):(isF?'Chạm để chọn':'Chưa tìm thấy');
 s.setAttribute('aria-label',`${f.label}${f.req?' (bắt buộc)':''}. ${data[f.id]?'Đã cất giữ.':isF?'Đã tìm thấy, chưa chọn.':'Chưa tìm thấy, chạm để xem gợi ý.'}`);
 const g=document.querySelector(`.hid[data-f="${f.id}"]`);g.setAttribute('aria-label',isF?`${f.obj}: ${f.label}`:'Món đồ ẩn');update()}
function update(){const n=found.size,filled=FIELDS.filter(f=>data[f.id]).length,ok=FIELDS.filter(f=>f.req).every(f=>data[f.id]);
 $('#ptext').textContent=`Đã tìm thấy ${n}/${FIELDS.length} món đồ · đã cất giữ ${filled} điều`+(ok?' · sẵn sàng niêm phong':'');$('#send').disabled=!ok}
FIELDS.forEach(f=>{document.querySelector(`.slot[data-id="${f.id}"] [data-s]`).textContent='Chưa tìm thấy'});
async function onSubmit(payload){
 const c=payload.confirm.c;
 const note=[payload.interest?.extra&&`Sở thích thêm: ${payload.interest.extra}`,payload.note?.text].filter(Boolean).join('\n')||null;
 const body={
  name:c.name,phone:c.phone,style:payload.style.sel[0],colors:payload.color.sel,
  preferences:payload.interest?.sel||[],flower_preferences:payload.flower?.sel||[],
  budget_range:CONFIG.budgetValues[payload.budget.sel[0]],surprise_level:payload.surprise?.sel[0]||CONFIG.surprises[0][0],
  note,delivery_address:c.addr,delivery_date:c.date
 };
 try{
  const response=await fetch('{{ route('mystery-box.store') }}',{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},body:JSON.stringify(body)});
  const result=await response.json();
  if(!response.ok){alert(result.message||Object.values(result.errors||{})[0]?.[0]||'Không thể gửi yêu cầu.');return}
  window.location.href=result.redirect;
 }catch(error){alert('Không thể kết nối. Vui lòng thử lại.');}
}
$('#send').onclick=async event=>{event.currentTarget.disabled=true;try{await onSubmit(JSON.parse(JSON.stringify(data)))}finally{update()}};
update();
</script>
@endpush
