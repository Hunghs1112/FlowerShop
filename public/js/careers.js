(function(){
'use strict';
const C=window.CAREER_CONFIG;
const $=s=>document.querySelector(s), $$=s=>[...document.querySelectorAll(s)];
const esc=s=>String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const pad=n=>String(n).padStart(2,'0');
const lines=t=>String(t||'').split('\n').map(x=>x.trim()).filter(Boolean);
const STATUS={open:'ĐANG TUYỂN',soon:'SẮP MỞ',closed:'ĐÃ ĐỦ'};
const br=t=>esc(t).replace(/\n/g,'<br>');
function render(){
  $('#cvImg').src=C.coverImg; $('#cvMast').textContent=C.masthead; $('#cvIssue').textContent=C.issue; $('#cvNo').textContent=C.issueNo;
  $('#cvLines').innerHTML=C.coverLines.filter(l=>l.k!=='CHUYÊN ĐỀ').map(l=>`<div><small>${esc(l.k)}</small><strong>${esc(l.v)}</strong></div>`).join('');
  $('#tocKicker').textContent=C.tocKicker; $('#tocTitle').innerHTML=br(C.title).replace(/\*(.+?)\*/g,'<em>$1</em>'); $('#tocLead').textContent=C.lead;
  $('#toc').innerHTML=C.jobs.map((j,i)=>`<li><a href="#bai-${i}"><span class="pg">${pad(i*4+4)}</span><span><b>${esc(j.title)}</b><small>${esc(j.standfirst)}</small></span><span class="st ${esc(j.status)}">${STATUS[j.status]}</span></a></li>`).join('');
  const letterHTML=lines(C.letter).map(p=>`<p>${esc(p)}</p>`).join('');
  $('#letter').innerHTML=`<div class="fold" id="fold-letter"><div class="fold-in">${letterHTML}</div></div><button type="button" class="fold-btn center" aria-expanded="false" aria-controls="fold-letter" hidden>Đọc tiếp thư <span aria-hidden="true">▾</span></button>`;
  $('#sign').textContent=C.signature;

  if((C.jobLayout||'accordion')==='accordion'){
    const LIM=Math.max(1,+C.listLimit||4);
    const li=(a,id)=>{const L=lines(a);const extra=L.length-LIM;
      return L.map((x,k)=>`<li${k>=LIM?' class="more-li" hidden':''}>${esc(x)}</li>`).join('')+(extra>0?`</ul><button type="button" class="li-more" data-more="${id}" aria-expanded="false">+ Xem thêm ${extra} ý</button><ul hidden>`:'');};
    $('#features').innerHTML=`<section class="acc-sec"><div class="wrap"><p class="eyebrow">${esc(C.accKicker||'VỊ TRÍ ĐANG TUYỂN')}</p><h2>${esc(C.accTitle||'Các chuyến đang mở')}</h2><div class="acc">`+C.jobs.map((j,i)=>`<div class="acc-item" id="bai-${i}">
      <button type="button" class="acc-h" aria-expanded="false" aria-controls="acc-p-${i}" data-acc="${i}">
        <span class="acc-no">${pad(i+1)}</span><span class="acc-t">${esc(j.title)}</span>
        <span class="acc-meta"><span class="st ${esc(j.status)}">${STATUS[j.status]}</span><span class="acc-cnt">${pad(j.count)} người</span></span>
        <span class="acc-ic" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg></span></button>
      <div class="acc-p" id="acc-p-${i}" role="region" aria-labelledby="bai-${i}"><div class="acc-in">
        ${j.img?`<figure><img src="${esc(j.img)}" alt="${esc(j.imgAlt||j.title)}" loading="lazy"></figure>`:''}
        <div class="acc-body"><p class="kicker"><span>${esc(j.kicker)}</span></p>
          ${j.standfirst?`<p class="stand">${esc(j.standfirst)}</p>`:''}${j.quote?`<blockquote class="pull">“${esc(j.quote)}”</blockquote>`:''}
          <div class="cols3"><div id="c-${i}-d"><h4>CÔNG VIỆC</h4><ul>${li(j.desc,i+'-d')}</ul></div><div id="c-${i}-r"><h4>YÊU CẦU</h4><ul>${li(j.req,i+'-r')}</ul></div><div id="c-${i}-p"><h4>QUYỀN LỢI</h4><ul>${li(j.perks,i+'-p')}</ul></div></div>
          <div class="feat-foot"><span><b>${pad(j.count)}</b><span class="meta">người · ${esc(j.type)}</span></span>${j.status==='open'?`<a class="btn" href="#dang-ky" data-apply="${i}">Ứng tuyển vị trí này →</a>`:''}</div>
        </div></div></div></div>`).join('')+`</div></div></section>`;
  } else {
  $('#features').innerHTML=C.jobs.map((j,i)=>`<article class="feat ${i%2?'rev':''}" id="bai-${i}"><div class="wrap feat-grid">
    <figure><img src="${esc(j.img)}" alt="${esc(j.imgAlt||j.title)}" loading="lazy"><figcaption><span>${esc(C.masthead)} · ${esc(C.issueNo)}</span><span>TR. ${pad(i*4+4)}</span></figcaption></figure>
    <div><p class="kicker"><span>VỊ TRÍ ${pad(i+1)} · ${esc(j.kicker)}</span><span class="st ${esc(j.status)}">${STATUS[j.status]}</span></p>
      <h2>${esc(j.title)}</h2><p class="stand">${esc(j.standfirst)}</p>
      ${j.quote?`<blockquote class="pull">“${esc(j.quote)}”</blockquote>`:''}
      <div class="cols3"><div><h4>CÔNG VIỆC</h4><ul>${lines(j.desc).map(x=>`<li>${esc(x)}</li>`).join('')}</ul></div><div><h4>YÊU CẦU</h4><ul>${lines(j.req).map(x=>`<li>${esc(x)}</li>`).join('')}</ul></div><div><h4>QUYỀN LỢI</h4><ul>${lines(j.perks).map(x=>`<li>${esc(x)}</li>`).join('')}</ul></div></div>
      <div class="feat-foot"><span><b>${pad(j.count)}</b><span class="meta">người · ${esc(j.type)}</span></span>${j.status==='open'?`<a class="btn" href="#dang-ky" data-apply="${i}">Ứng tuyển vị trí này →</a>`:''}</div>
    </div></div></article>`).join('');
  }
  $('#steps').innerHTML=C.steps.map((s,i)=>`<li><span class="no">${pad(i+1)}</span><small>${esc(s.code)}</small><h4>${esc(s.title)}</h4><p>${esc(s.text)}</p></li>`).join('');
  $('#subLead').textContent=C.subLead; $('#cpMast').textContent=C.masthead;
  const s=$('#sPos'),keep=s.value;
  s.innerHTML='<option value="">Chọn vị trí…</option>'+C.jobs.map((j,i)=>j.status==='open'?`<option value="${i}">${esc(j.title)}</option>`:'').join(''); if(keep!=='')s.value=keep;
  $('#shint').textContent=C.endpoint?'Phiếu được gửi trực tiếp tới bộ phận tuyển dụng.':'Bấm gửi, ứng dụng email sẽ mở thư soạn sẵn. Bạn chỉ cần đính kèm CV rồi gửi.';
  const ic={mail:'<path d="M4 6h16v12H4z"/><path d="M4 7l8 6 8-6"/>',zalo:'<path d="M5 5h14v10H10l-5 4z"/><path d="M9 9h6M9 12h4"/>',fb:'<rect x="4" y="4" width="16" height="16" rx="4"/><path d="M14 8h-1.5A1.5 1.5 0 0 0 11 9.5V20M9 12.5h5"/>',web:'<circle cx="12" cy="12" r="8"/><path d="M4 12h16M12 4c2.5 2.4 3.5 5 3.5 8s-1 5.6-3.5 8c-2.5-2.4-3.5-5-3.5-8s1-5.6 3.5-8z"/>'};
  const sv=k=>`<span class="ic"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">${ic[k]}</svg></span>`;
  const z=String(C.zalo).replace(/\D/g,''),zf=z.replace(/(\d{4})(\d{3})(\d{3})/,'$1 $2 $3');
  $('#contact').innerHTML=[['mail','GỬI CV VỀ',C.email,'mailto:'+C.email],['zalo','ZALO',zf,'https://zalo.me/'+z],['fb','FANPAGE',C.fanpage.replace(/^https?:\/\/(www\.)?/,''),C.fanpage],['web','WEBSITE',C.website.replace(/^https?:\/\//,''),C.website]]
   .map(([k,l,v,h])=>`<li><a href="${esc(h)}" ${k==='mail'?'':'target="_blank" rel="noopener"'}>${sv(k)}<span><small>${l}</small>${esc(v)}</span></a></li>`).join('');

  requestAnimationFrame(setupFolds);
}
window.__lntRender=render; render();
document.addEventListener('click',e=>{const a=e.target.closest('[data-apply]');if(a)$('#sPos').value=a.dataset.apply});

// ===== Accordion (jobLayout=accordion) =====
function accToggle(i){
  const it=document.getElementById('bai-'+i); if(!it||!it.classList.contains('acc-item')) return;
  const h=it.querySelector('.acc-h'), p=it.querySelector('.acc-p'), open=h.getAttribute('aria-expanded')==='true';
  if(open){
    p.style.maxHeight=p.scrollHeight+'px';
    requestAnimationFrame(()=>{p.style.maxHeight='0px'});
    it.classList.remove('open'); h.setAttribute('aria-expanded','false');
  } else {
    p.style.maxHeight=p.scrollHeight+'px';
    it.classList.add('open'); h.setAttribute('aria-expanded','true');
    p.addEventListener('transitionend',function te(){
      if(h.getAttribute('aria-expanded')==='true') p.style.maxHeight='none';
      p.removeEventListener('transitionend',te);
    });
  }
}
document.addEventListener('click',e=>{
  const h=e.target.closest('.acc-h'); if(h){accToggle(+h.dataset.acc); return}
  const t=e.target.closest('#toc a');
  if(t&&(C.jobLayout||'accordion')==='accordion'){
    const i=+t.getAttribute('href').split('-')[1];
    const it=document.getElementById('bai-'+i);
    if(it&&!it.classList.contains('open')) accToggle(i);
  }
});

// "Xem thêm" trong từng cột CÔNG VIỆC/YÊU CẦU/QUYỀN LỢI (chỉ dùng khi accordion)
document.addEventListener('click',e=>{
  const m=e.target.closest('.li-more'); if(!m) return;
  const col=document.getElementById('c-'+m.dataset.more), open=m.getAttribute('aria-expanded')==='true';
  col.querySelectorAll('.more-li').forEach(x=>x.hidden=open);
  const n=col.querySelectorAll('.more-li').length;
  m.setAttribute('aria-expanded',String(!open));
  m.textContent=open?`+ Xem thêm ${n} ý`:`− Thu gọn`;
  const p=m.closest('.acc-p');
  if(p&&p.style.maxHeight!=='none') p.style.maxHeight='none';
  if(open){const it=m.closest('.acc-item'); if(it&&it.getBoundingClientRect().top<0) it.scrollIntoView({behavior:'smooth',block:'start'})}
});

// ===== Fold (thư toà soạn, có thể mở rộng cho bài viết sau) =====
function setupFolds(){
  $$('.fold').forEach(f=>{
    const btn=f.nextElementSibling, inner=f.firstElementChild;
    if(!btn||!inner) return;
    const lim=f.id==='fold-letter'?(+C.letterFold||170):(+C.foldHeight||230);
    if(btn.getAttribute('aria-expanded')==='true'&&!btn.hidden) return;
    let n=f, bg='';
    while(n&&n!==document.documentElement){
      const c=getComputedStyle(n).backgroundColor;
      if(c&&c!=='transparent'&&!/rgba\(.*, 0\)$/.test(c)){bg=c;break}
      n=n.parentElement;
    }
    if(!bg) bg=getComputedStyle(document.body).backgroundColor;
    f.style.setProperty('--fold-bg',bg);
    f.style.maxHeight='none';
    const full=inner.scrollHeight;
    if(full>lim+40){
      f.classList.add('closed');
      f.style.maxHeight=lim+'px';
      btn.hidden=false;
      btn.setAttribute('aria-expanded','false');
      btn.firstChild.nodeValue=(f.id==='fold-letter'?'Đọc tiếp thư ':'Đọc tiếp ');
    } else {
      f.classList.remove('closed');
      btn.hidden=true;
    }
  });
}
function toggleFold(btn){
  const f=document.getElementById(btn.getAttribute('aria-controls'));
  if(!f) return;
  const inner=f.firstElementChild, open=btn.getAttribute('aria-expanded')==='true';
  const lim=f.id==='fold-letter'?(+C.letterFold||170):(+C.foldHeight||230);
  if(open){
    f.style.maxHeight=inner.scrollHeight+'px';
    requestAnimationFrame(()=>{f.classList.add('closed'); f.style.maxHeight=lim+'px'});
    btn.setAttribute('aria-expanded','false');
    btn.firstChild.nodeValue=(f.id==='fold-letter'?'Đọc tiếp thư ':'Đọc tiếp ');
    const top=f.getBoundingClientRect().top; if(top<0) f.scrollIntoView({behavior:'smooth',block:'start'});
  } else {
    f.classList.remove('closed');
    f.style.maxHeight=inner.scrollHeight+'px';
    btn.setAttribute('aria-expanded','true');
    btn.firstChild.nodeValue='Thu gọn ';
    f.addEventListener('transitionend',function te(){
      if(btn.getAttribute('aria-expanded')==='true') f.style.maxHeight='none';
      f.removeEventListener('transitionend',te);
    });
  }
}
document.addEventListener('click',e=>{const b=e.target.closest('.fold-btn'); if(b) toggleFold(b)});
let rz; addEventListener('resize',()=>{clearTimeout(rz); rz=setTimeout(()=>{if($$('.fold-btn[aria-expanded="false"]').length) setupFolds()},200)});

const err=$('#serr');
function bad(el,m){el.setAttribute('aria-invalid','true');err.textContent=m;err.hidden=false;el.focus();}
$('#sform').addEventListener('submit',async e=>{
  e.preventDefault(); err.hidden=true; $$('[aria-invalid]').forEach(x=>x.removeAttribute('aria-invalid'));
  const v={i:$('#sPos').value,name:$('#sName').value.trim(),year:$('#sYear').value.trim(),phone:$('#sPhone').value.trim(),email:$('#sEmail').value.trim(),cv:$('#sCv').value.trim(),note:$('#sNote').value.trim()};
  if(v.i==='') return bad($('#sPos'),'Vui lòng chọn vị trí.');
  if(!v.name) return bad($('#sName'),'Vui lòng nhập họ và tên.');
  if(!/^[0-9+\s.-]{9,15}$/.test(v.phone)) return bad($('#sPhone'),'Số điện thoại chưa đúng.');
  if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.email)) return bad($('#sEmail'),'Email chưa đúng.');
  const j=C.jobs[+v.i];
  try{
    const response=await fetch(C.endpoint,{method:'POST',headers:{'Accept':'application/json','Content-Type':'application/json','X-CSRF-TOKEN':C.csrfToken},body:JSON.stringify({position:+v.i,name:v.name,year:v.year||null,phone:v.phone,email:v.email,cv:v.cv||null,note:v.note||null})});
    if(!response.ok){const data=await response.json().catch(()=>({}));throw new Error(Object.values(data.errors||{})[0]?.[0]||data.message||'Chưa gửi được phiếu.');}
  }catch(x){err.textContent=x.message||'Chưa gửi được, vui lòng thử lại hoặc nhắn Zalo.';err.hidden=false;return}
  $('#doneTxt').textContent='Phiếu ứng tuyển vị trí '+j.title+' đã được gửi. Chúng tôi sẽ liên hệ bạn sớm.';
  $('#done').hidden=false; $('#again').focus();
});
$('#again').addEventListener('click',()=>{$('#sform').reset();$('#done').hidden=true});
})();
