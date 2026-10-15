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
  $('#letter').innerHTML=lines(C.letter).map(p=>`<p>${esc(p)}</p>`).join(''); $('#sign').textContent=C.signature;
  $('#features').innerHTML=C.jobs.map((j,i)=>`<article class="feat ${i%2?'rev':''}" id="bai-${i}"><div class="wrap feat-grid">
    <figure><img src="${esc(j.img)}" alt="${esc(j.imgAlt||j.title)}" loading="lazy"><figcaption><span>${esc(C.masthead)} · ${esc(C.issueNo)}</span><span>TR. ${pad(i*4+4)}</span></figcaption></figure>
    <div><p class="kicker"><span>VỊ TRÍ ${pad(i+1)} · ${esc(j.kicker)}</span><span class="st ${esc(j.status)}">${STATUS[j.status]}</span></p>
      <h2>${esc(j.title)}</h2><p class="stand">${esc(j.standfirst)}</p>
      ${j.quote?`<blockquote class="pull">“${esc(j.quote)}”</blockquote>`:''}
      <div class="cols3"><div><h4>CÔNG VIỆC</h4><ul>${lines(j.desc).map(x=>`<li>${esc(x)}</li>`).join('')}</ul></div><div><h4>YÊU CẦU</h4><ul>${lines(j.req).map(x=>`<li>${esc(x)}</li>`).join('')}</ul></div><div><h4>QUYỀN LỢI</h4><ul>${lines(j.perks).map(x=>`<li>${esc(x)}</li>`).join('')}</ul></div></div>
      <div class="feat-foot"><span><b>${pad(j.count)}</b><span class="meta">người · ${esc(j.type)}</span></span>${j.status==='open'?`<a class="btn" href="#dang-ky" data-apply="${i}">Ứng tuyển vị trí này →</a>`:''}</div>
    </div></div></article>`).join('');
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
}
window.__lntRender=render; render();
document.addEventListener('click',e=>{const a=e.target.closest('[data-apply]');if(a)$('#sPos').value=a.dataset.apply});
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
