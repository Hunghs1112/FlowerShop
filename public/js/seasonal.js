(function(){
'use strict';
const C=window.LNT_SEASON_CONFIG,root=document.querySelector('.seasonal-page'),$=s=>root.querySelector(s),app=$('#seasonalApp');
const red=matchMedia('(prefers-reduced-motion: reduce)').matches;
const esc=s=>String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const img=s=>!s?'':(s.startsWith('img:')?(window.SEASON_IMG||{})[s.slice(4)]||'':s);
const safe=u=>/^(https?:\/\/|\/|#)/i.test(u||'')?u:'#';
function days(d){if(!d)return null;const t=new Date(d+'T23:59:59');const n=Math.ceil((t-new Date())/864e5);return isNaN(n)?null:n}
function fmt(d){if(!d)return'';const x=new Date(d+'T00:00:00');return isNaN(x)?d:`${String(x.getDate()).padStart(2,'0')}/${String(x.getMonth()+1).padStart(2,'0')}/${x.getFullYear()}`}
const ST=s=>{const k=(s||'').normalize('NFD').replace(/[\u0300-\u036f]/g,'').replace(/đ/gi,'d').toLowerCase();
  return /dang bay/.test(k)?'fly':/dat truoc/.test(k)?'pre':/ha canh/.test(k)?'done':'soon'};
function cells(t){return [...t].map(c=>`<span class="f" data-c="${esc(c)}">${red?esc(c):''}</span>`).join('')}
function flip(root){if(red)return;const CH='ABCDEGHIKLMNOPQRSTUVXY';root.querySelectorAll('.f[data-c]').forEach(s=>{let n=7+Math.floor(Math.random()*8);(function k(){if(n--<=0){s.textContent=s.dataset.c;return}s.textContent=CH[Math.floor(Math.random()*CH.length)];setTimeout(k,60)})()})}
function product(p){return `<a class="card" href="${esc(safe(p.link))}"><div class="ph">${img(p.img)?`<img src="${esc(img(p.img))}" alt="${esc(p.name)}" loading="lazy">`:''}${p.badge?`<span class="badge">${esc(p.badge)}</span>`:''}${p.code?`<span class="tag">${esc(p.code)} → HAN</span>`:''}</div><h3>${esc(p.name)}</h3><p>${esc(p.origin||'')}</p></a>`}
function treeSVG(cm,big){ // person 170cm vs tree
  const H=260,scale=H/260, th=cm*scale, ph=170*scale, base=H;
  const w=th*0.62, x=big?150:110;
  let layers='';for(let i=0;i<5;i++){const y0=base-18-th*(i/5)*0.92, ww=w*(1-i*0.17);layers+=`<path d="M${x} ${y0-th*0.28} L${x+ww/2} ${y0} L${x-ww/2} ${y0} Z" fill="url(#tg)"/>`}
  return `<svg viewBox="0 0 260 ${H+8}" role="img" aria-label="Cây cao ${cm} cm so với người cao 1,7 m"><defs><linearGradient id="tg" x1="0" x2="1"><stop offset="0" stop-color="#2F5A47"/><stop offset="1" stop-color="#1E3F31"/></linearGradient></defs>
  <line x1="0" y1="${base}" x2="260" y2="${base}" stroke="currentColor" stroke-opacity=".25"/>
  <rect x="${x-7}" y="${base-20}" width="14" height="20" fill="#6B4632"/><path d="M${x-22} ${base} h44 l-5 -12 h-34 z" fill="#C78E66"/>
  ${layers}<path d="M${x} ${base-th-6} l4 9 9 1-7 6 2 9-8-5-8 5 2-9-7-6 9-1z" fill="#E2AE84"/>
  <g transform="translate(220 ${base})" fill="currentColor" fill-opacity=".45"><circle cx="0" cy="${-ph+10}" r="10"/><rect x="-9" y="${-ph+22}" width="18" height="${ph*0.42}" rx="8"/><rect x="-8" y="${-ph+20+ph*0.42}" width="7" height="${ph*0.5}" rx="3"/><rect x="1" y="${-ph+20+ph*0.42}" width="7" height="${ph*0.5}" rx="3"/></g>
  <text x="220" y="${base-ph-8}" text-anchor="middle" font-size="10" fill="currentColor" fill-opacity=".7">1,7 m</text></svg>`}
/* ---------- HUB ---------- */
let VIEW='hub';
function hub(){
  VIEW='hub';root.dataset.seasonTheme='hub';
  const rows=C.seasons.map(s=>{const st=ST(s.status),d=days(s.date);
    return `<a class="brow" href="${esc(s.url)}"><span class="cells">${cells(s.code)}<span class="f ar">→</span>${cells('HAN')}</span><span class="fl">${esc(s.name)}<small>${d!=null&&d>=0?`còn ${d} ngày · ${fmt(s.date)}`:esc(s.tagline)}</small></span><span class="st ${st}">${esc(s.status).toUpperCase()}</span></a>`}).join('');
  app.innerHTML=`<section class="shead"><div class="wrap hubgrid"><div><p class="eyebrow">${esc(C.hub.eyebrow)}</p><h1>${esc(C.hub.title)}</h1><p class="lead">${esc(C.hub.intro)}</p></div>
  <div class="board"><div class="bh"><span>LỊCH BAY MÙA LỄ</span><span id="clk"></span></div>${rows}</div></div></section>
  <section class="wrap seasons">${C.seasons.map(s=>`<a class="scard t-${esc(s.theme)}" href="${esc(s.url)}"><div class="sv">${img(s.img)?`<img src="${esc(img(s.img))}" alt="" loading="lazy">`:treeSVG(180,true)}</div><div class="si"><span class="code">${esc(s.code)} → HAN</span><h2>${esc(s.name)}</h2><p>${esc(s.tagline)}</p><span class="go">Lên chuyến bay →</span></div></a>`).join('')}</section>`;
  flip(app);
}
/* ---------- SEASON ---------- */
function season(s){
  VIEW=s.id;root.dataset.seasonTheme=s.theme;
  const d=days(s.date), st=ST(s.status);
  let h=`<section class="shero"><div class="wrap sgrid"><div><a class="back" href="${esc(C.hub.url)}">← Lịch bay mùa lễ</a><p class="eyebrow">${esc(s.code)} → HAN · ${esc(s.status).toUpperCase()}</p><h1>${esc(s.name)}</h1><p class="tag2">${esc(s.tagline)}</p><p class="lead">${esc(s.intro)}</p>
  <div class="ctas"><a class="btn primary" href="${esc(safe(s.cta.link))}">${esc(s.cta.label)}</a><a class="btn ghost" href="https://zalo.me/${esc(C.contact.zalo)}" target="_blank" rel="noopener">Tư vấn qua Zalo</a></div>
  ${d!=null&&d>=0?`<div class="cd" data-date="${esc(s.date)}"><b>${d}</b><span>ngày nữa đến ${esc(s.name)} · ${fmt(s.date)}</span></div>`:''}</div>
  <div class="hv">${img(s.img)?`<img src="${esc(img(s.img))}" alt="${esc(s.name)}">`:`<div class="treeart">${treeSVG(210,true)}</div>`}</div></div>${s.theme==='nordic'&&!red?'<div class="snow" aria-hidden="true"></div>':''}</section>`;
  if(s.palette) h+=`<section class="wrap blk"><p class="eyebrow">BẢNG MÀU MÙA</p><div class="pal">${s.palette.map(p=>`<span><i style="background:${esc(p[1])}"></i>${esc(p[0])}</span>`).join('')}</div></section>`;
  if(s.products&&s.products.length) h+=`<section class="wrap blk"><p class="eyebrow">BỘ SƯU TẬP</p><div class="prods">${s.products.map(product).join('')}</div></section>`;
  if(s.trickTreat){const t=s.trickTreat;h+=`<section class="wrap blk"><div class="tt"><div><p class="eyebrow">MYSTERY BOX</p><h2>${esc(t.title)}</h2><p class="lead">${esc(t.intro)}</p></div><div class="cards2">
   ${['trick','treat'].map(k=>`<button type="button" class="flip" aria-pressed="false"><span class="fr"><b>${esc(t[k].label)}</b><small>Chạm để lật</small></span><span class="bk"><b>${esc(t[k].title)}</b><small>${esc(t[k].desc)}</small><a href="${esc(safe(t.link))}">Chọn hộp ${esc(t[k].label)} →</a></span></button>`).join('')}</div></div></section>`}
  if(s.tree) h+=treeBlock(s);
  if(s.extra) h+=`<section class="wrap blk"><a class="extra" href="${esc(safe(s.extra.link))}">${esc(s.extra.label)}</a></section>`;
  app.innerHTML=h;
  if(s.theme==='nordic'&&!red){const sn=app.querySelector('.snow');for(let i=0;i<40;i++){const f=document.createElement('i');f.style.left=Math.random()*100+'%';f.style.animationDelay=(-Math.random()*10)+'s';f.style.animationDuration=(7+Math.random()*7)+'s';f.style.opacity=.3+Math.random()*.6;f.style.width=f.style.height=(3+Math.random()*4)+'px';sn.appendChild(f)}}
  app.querySelectorAll('.flip').forEach(b=>b.addEventListener('click',e=>{if(e.target.tagName==='A')return;b.setAttribute('aria-pressed',b.getAttribute('aria-pressed')!=='true')}));
  if(s.tree) bindTree(s);
}
const ICO={
 chau:'<circle cx="24" cy="27" r="13" fill="#B5562F"/><rect x="20" y="10" width="8" height="5" rx="1.5" fill="#C9A24A"/><path d="M14 24c4 3 16 3 20 0" stroke="#F3E2C2" stroke-width="2" fill="none"/>',
 den:'<path d="M4 16c10 10 30 10 40 0" stroke="#6B4632" stroke-width="2" fill="none"/>'+[8,17,27,36].map((x,i)=>`<g transform="translate(${x} ${i%2?23:21})"><rect x="-2" y="-3" width="4" height="3" fill="#6B4632"/><ellipse cy="5" rx="3.5" ry="5" fill="${['#F2C14E','#E9853A','#F2C14E','#E9853A'][i]}"/></g>`).join(''),
 sao:'<path d="M24 6l5 11 12 1-9 8 3 12-11-6-11 6 3-12-9-8 12-1z" fill="#D9B36A" stroke="#B07A52" stroke-width="1.5"/>',
 ruybang:'<path d="M24 22c-8-10-18-8-15-1 2 4 10 3 15 1zM24 22c8-10 18-8 15-1-2 4-10 3-15 1z" fill="#8E1F2B"/><path d="M22 23l-6 16 5-3 3 4M26 23l6 16-5-3-3 4" fill="#A3283A"/><circle cx="24" cy="22" r="3.5" fill="#6E1622"/>',
 vong:'<circle cx="24" cy="25" r="14" fill="none" stroke="#2F5A47" stroke-width="7"/><circle cx="24" cy="25" r="14" fill="none" stroke="#3D7058" stroke-width="2" stroke-dasharray="2 4"/><circle cx="16" cy="16" r="2.5" fill="#B5562F"/><circle cx="33" cy="33" r="2.5" fill="#B5562F"/><path d="M24 11l-4-4h8z" fill="#8E1F2B"/>',
 de:'<path d="M12 40h24l-3-14H15z" fill="#6B4632"/><rect x="10" y="38" width="28" height="4" rx="2" fill="#4E3324"/><rect x="21" y="8" width="6" height="20" fill="#8A5A3C"/><path d="M15 30h18" stroke="#9FC3D6" stroke-width="2"/>',
 tham:'<ellipse cx="24" cy="30" rx="20" ry="9" fill="#8E1F2B"/><ellipse cx="24" cy="30" rx="20" ry="9" fill="none" stroke="#F3E2C2" stroke-width="2" stroke-dasharray="3 3"/><ellipse cx="24" cy="28" rx="6" ry="2.5" fill="#6E1622"/>',
 thong:'<ellipse cx="24" cy="26" rx="10" ry="14" fill="#8A5A3C"/>'+[0,1,2,3].map(i=>`<path d="M15 ${16+i*6}q9 5 18 0" stroke="#5E3B26" stroke-width="2" fill="none"/>`).join('')+'<path d="M24 12v-5" stroke="#2F5A47" stroke-width="2"/>',
 hop:'<rect x="9" y="20" width="30" height="20" rx="2" fill="#2F5A47"/><rect x="7" y="15" width="34" height="7" rx="2" fill="#3D7058"/><rect x="22" y="15" width="5" height="25" fill="#C9A24A"/><path d="M24.5 15c-6-8-13-6-11-1 1 3 7 2 11 1zM24.5 15c6-8 13-6 11-1-1 3-7 2-11 1z" fill="#C9A24A"/>'};
const icon=k=>`<svg viewBox="0 0 48 48" aria-hidden="true">${ICO[k]||ICO.hop}</svg>`;
const num=p=>{const d=String(p||'').replace(/[^0-9]/g,'');return d?+d:null};
const vnd=n=>n.toLocaleString('vi-VN')+'đ';
function accBlock(t){
  let h='';
  if(t.packages&&t.packages.items&&t.packages.items.length){const P=t.packages;
    h+=`<div class="acc"><h3>${esc(P.title)}</h3><p class="lead" style="margin:.2rem 0 1rem">${esc(P.intro||'')}</p><div class="pkgs" role="radiogroup" aria-label="${esc(P.title)}">${P.items.map((p,i)=>`<button type="button" role="radio" aria-checked="false" class="pkg" data-i="${i}">${img(p.img)?`<img src="${esc(img(p.img))}" alt="" loading="lazy">`:`<span class="sw">${(p.colors||[]).map(c=>`<i style="background:${esc(c)}"></i>`).join('')}</span>`}<b>${esc(p.name)}</b><small>${esc(p.desc||'')}</small><em>${p.price?esc(p.price):'Liên hệ báo giá'}</em></button>`).join('')}</div></div>`}
  (t.accessories||[]).forEach((g,gi)=>{h+=`<div class="acc"><h3>${esc(g.group)}</h3><div class="items">${g.items.map((it,ii)=>`<div class="item" data-g="${gi}" data-i="${ii}"><div class="iv">${img(it.img)?`<img src="${esc(img(it.img))}" alt="" loading="lazy">`:icon(it.icon)}</div><b>${esc(it.name)}</b><small>${esc(it.desc||'')}</small><em>${it.price?esc(it.price):'Liên hệ báo giá'}</em>
    <div class="qty" role="group" aria-label="Số lượng ${esc(it.name)}"><button type="button" class="qm" aria-label="Bớt">−</button><output>0</output><button type="button" class="qp" aria-label="Thêm">+</button></div></div>`).join('')}</div></div>`});
  return h?`<div class="accwrap" id="phu-kien"><p class="eyebrow">PHỤ KIỆN & ĐỒ TRANG TRÍ</p><h2 class="acct">Hoàn thiện cây thông của bạn</h2>${h}<p class="accback"><a href="#dat-truoc">↑ Về phiếu đặt trước</a></p></div>`:'';
}
function treeBlock(s){const t=s.tree,dl=days(t.deadline);
  return `<section class="wrap blk" id="dat-truoc"><div class="order"><div class="ol">
   <p class="eyebrow">ĐẶT TRƯỚC · CPH → HAN</p><h2>Chọn chiều cao cây</h2>
   ${dl!=null&&dl>=0?`<p class="dl">Hạn chót đặt trước: <b>${fmt(t.deadline)}</b> · còn <b>${dl}</b> ngày</p>`:''}
   <div class="sizes" role="radiogroup" aria-label="Chiều cao cây">${t.sizes.map((z,i)=>`<button type="button" role="radio" class="sz" aria-checked="${i===2}" data-i="${i}"><b>${esc(z.label)}</b><small>${z.price?esc(z.price):'Liên hệ báo giá'}</small></button>`).join('')}</div>
   <div class="viz" id="viz"></div>
   <dl class="facts"><dt>Hàng về dự kiến</dt><dd>${esc(t.arrival)}</dd><dt>Đặt cọc</dt><dd>${esc(t.deposit)}</dd></dl></div>
   <form class="or" id="orderForm" novalidate><div class="oh">PHIẾU ĐẶT TRƯỚC · PRE-ORDER</div>
   <a class="acclink" href="#phu-kien">+ Chọn phụ kiện & đồ trang trí</a><p class="acccount" id="accCount" hidden></p><fieldset><legend>Dịch vụ đi kèm</legend>${t.addons.map((a,i)=>`<label class="chk"><input type="checkbox" name="addon" value="${esc(a.name)}"><span>${esc(a.name)}${a.price?` · ${esc(a.price)}`:''}</span></label>`).join('')}</fieldset>
   <div class="g2"><label>Họ và tên *<input name="hoten" required autocomplete="name"></label><label>Số điện thoại / Zalo *<input name="sdt" type="tel" required autocomplete="tel"></label>
   <label class="full">Địa chỉ nhận cây *<input name="diachi" required autocomplete="street-address"></label><label>Ngày nhận mong muốn<input name="ngaynhan" type="date"></label><label>Ghi chú<input name="ghichu" placeholder="Tầng, thang máy, giờ nhận…"></label></div>
   <p class="sum" id="sum"></p><p class="err" id="oerr" aria-live="polite"></p>
   <button class="btn primary" type="submit">Gửi đặt trước</button>
   <div class="done" id="odone" hidden role="status"><b>ĐÃ GIỮ CHỖ TRÊN CHUYẾN CPH → HAN</b><p id="odoneText"></p><div class="ctas"><button type="button" class="btn ghost" id="copyOrder">Sao chép thông tin đặt</button><a class="btn primary" href="https://zalo.me/${esc(C.contact.zalo)}" target="_blank" rel="noopener">Mở Zalo LNT</a></div></div></form></div>
   ${accBlock(t)}<div class="care"><div class="ch"><b>THẺ CHĂM CÂY · CARE CARD</b><span>CPH → HAN</span></div><div class="cb"><h3>${esc((t.care.find(c=>c[0]==='Tên')||['', s.name])[1])}</h3><dl>${t.care.filter(c=>c[0]!=='Tên').map(c=>`<dt>${esc(c[0])}</dt><dd>${esc(c[1])}</dd>`).join('')}</dl></div></div>
   <div class="faq"><h2>Câu hỏi thường gặp</h2>${t.faq.map(f=>`<details><summary>${esc(f.q)}</summary><p>${esc(f.a)}</p></details>`).join('')}</div></section>`}
function bindTree(s){const t=s.tree,viz=$('#viz'),btns=[...root.querySelectorAll('.sz')];let cur=2;
  const show=i=>{cur=i;btns.forEach((b,k)=>b.setAttribute('aria-checked',k===i));viz.innerHTML=treeSVG(t.sizes[i].cm,false)+`<p>Cây ${esc(t.sizes[i].label)} · ${t.sizes[i].price?esc(t.sizes[i].price):'Liên hệ báo giá'}</p>`;summ()};
  btns.forEach((b,i)=>{b.addEventListener('click',()=>show(i));b.addEventListener('keydown',e=>{if(e.key==='ArrowRight'||e.key==='ArrowDown'){e.preventDefault();const n=(i+1)%btns.length;btns[n].focus();show(n)}if(e.key==='ArrowLeft'||e.key==='ArrowUp'){e.preventDefault();const n=(i-1+btns.length)%btns.length;btns[n].focus();show(n)}})});
  const form=$('#orderForm');let pkg=-1;const q={};
  root.querySelectorAll('.pkg').forEach(b=>b.addEventListener('click',()=>{const i=+b.dataset.i;pkg=pkg===i?-1:i;root.querySelectorAll('.pkg').forEach(x=>x.setAttribute('aria-checked',+x.dataset.i===pkg));summ()}));
  root.querySelectorAll('.item').forEach(el=>{const k=el.dataset.g+'-'+el.dataset.i,o=el.querySelector('output');
    el.querySelector('.qp').addEventListener('click',()=>{q[k]=Math.min(99,(q[k]||0)+1);o.textContent=q[k];el.classList.toggle('on',q[k]>0);summ()});
    el.querySelector('.qm').addEventListener('click',()=>{q[k]=Math.max(0,(q[k]||0)-1);o.textContent=q[k];el.classList.toggle('on',q[k]>0);summ()})});
  const picked=()=>{const L=[];if(pkg>=0)L.push({n:'Bộ '+t.packages.items[pkg].name,c:1,p:num(t.packages.items[pkg].price)});
    (t.accessories||[]).forEach((g,gi)=>g.items.forEach((it,ii)=>{const c=q[gi+'-'+ii]||0;if(c)L.push({n:it.name,c,p:num(it.price)})}));return L};
  const summ=()=>{const ad=[...form.querySelectorAll('input[name=addon]:checked')].map(x=>x.value),L=picked();
    const tp=num(t.sizes[cur].price);let tot=tp||0,unk=!tp;L.forEach(x=>{if(x.p==null)unk=true;else tot+=x.p*x.c});
    $('#sum').innerHTML=`<b>Cây ${esc(t.sizes[cur].label)}</b>`+(L.length?`<br>Phụ kiện: ${esc(L.map(x=>x.n+(x.c>1?' ×'+x.c:'')).join(', '))}`:'')+(ad.length?`<br>Dịch vụ: ${esc(ad.join(', '))}`:'')+
      (tot?`<br>Tạm tính: <b>${vnd(tot)}</b>${unk?' (chưa gồm mục liên hệ báo giá)':''}`:'');
    const n=L.reduce((a,x)=>a+x.c,0);const bd=document.getElementById('accCount');if(bd){bd.textContent=n?`${n} phụ kiện đã chọn · xem phiếu đặt trước`:'';bd.hidden=!n}};
  window.__lntPicked=picked;
  form.addEventListener('change',summ);show(cur);
  form.addEventListener('submit',async e=>{e.preventDefault();const f=new FormData(form),err=$('#oerr');
    const selected=window.__lntPicked(),PK=selected.map(x=>x.n+(x.c>1?' x'+x.c:'')).join(', ');const d={kichthuoc:t.sizes[cur].label,phukien:PK,tuychon:f.getAll('addon').join(', '),hoten:(f.get('hoten')||'').trim(),sdt:(f.get('sdt')||'').trim(),diachi:(f.get('diachi')||'').trim(),ngaynhan:f.get('ngaynhan')||'',ghichu:(f.get('ghichu')||'').trim(),thoigian:new Date().toISOString()};
    if(!d.hoten||!d.sdt||!d.diachi){err.textContent='Vui lòng điền họ tên, số điện thoại và địa chỉ.';return}
    if(!/^[0-9+\s.]{9,15}$/.test(d.sdt)){err.textContent='Số điện thoại chưa đúng.';return}err.textContent='';
    const text=`ĐẶT TRƯỚC CÂY THÔNG ĐAN MẠCH\nCỡ cây: ${d.kichthuoc}\nPhụ kiện: ${d.phukien||'-'}\nDịch vụ: ${d.tuychon||'-'}\nHọ tên: ${d.hoten}\nSĐT/Zalo: ${d.sdt}\nĐịa chỉ: ${d.diachi}\nNgày nhận: ${d.ngaynhan||'-'}\nGhi chú: ${d.ghichu||'-'}`;
    try{const response=await fetch(C.orderEndpoint,{method:'POST',headers:{'Accept':'application/json','Content-Type':'application/json','X-CSRF-TOKEN':C.csrfToken},body:JSON.stringify({season_slug:C.seasonSlug,size:d.kichthuoc,accessories:selected.map(x=>x.n),accessory_quantities:selected.map(x=>({name:x.n,quantity:x.c})),addons:f.getAll('addon'),name:d.hoten,phone:d.sdt,address:d.diachi,delivery_date:d.ngaynhan||null,notes:d.ghichu||null})});
      const result=await response.json();if(!response.ok)throw new Error(Object.values(result.errors||{}).flat()[0]||result.message||'Chưa gửi được phiếu đặt trước.');$('#odoneText').textContent=result.message}
    catch(x){err.textContent=x.message||'Chưa gửi được, bạn vui lòng thử lại hoặc nhắn Zalo cho LNT.';return}
    form.querySelectorAll('fieldset,.g2,.sum,button[type=submit]').forEach(x=>x.hidden=true);$('#odone').hidden=false;
    $('#copyOrder').onclick=async ev=>{try{await navigator.clipboard.writeText(text);ev.target.textContent='Đã sao chép ✓'}catch(x){ev.target.textContent='Hãy chụp màn hình phiếu này'}}})}
/* ---------- PAGE ---------- */
const view=window.LNT_SEASON_VIEW||'hub';
const syncTheme=()=>root.dataset.siteTheme=document.documentElement.dataset.theme||'light';
syncTheme();new MutationObserver(syncTheme).observe(document.documentElement,{attributes:true,attributeFilter:['data-theme']});
const legacyHash=location.hash.slice(1).split('/')[0];
const legacySeason=C.seasons.find(item=>item.id===legacyHash||(legacyHash==='dat-truoc'&&item.id==='thong'));
if(view==='hub'&&legacySeason)location.replace(legacySeason.url+(legacyHash==='dat-truoc'?'#dat-truoc':''));
else if(view==='hub')hub();else{const current=C.seasons.find(item=>item.id===view);current?season(current):hub()}
const clk=()=>{const e=document.getElementById('clk');if(e)e.textContent=new Date().toLocaleTimeString('vi-VN',{hour:'2-digit',minute:'2-digit'})};clk();setInterval(clk,30000);
})();
