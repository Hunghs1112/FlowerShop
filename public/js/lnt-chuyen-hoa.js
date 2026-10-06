/*!
 * LNT · Bảng "Chuyến hoa hôm nay"  v1.0
 * Dùng được cho mọi website. Không cần thư viện ngoài.
 *
 * CÁCH DÙNG (dán vào ô nội dung / khối HTML trong trang admin):
 *
 *   <div class="lnt-chuyen-hoa">
 *     <p>UIO | Hồng Freedom · Ecuador | Đã hạ cánh | /san-pham/hong-freedom</p>
 *     <p>CHC | Mẫu đơn · New Zealand | Đang bay</p>
 *     <p>AMS | Tulip · Hà Lan | Mở đặt trước | /san-pham/tulip</p>
 *   </div>
 *   + nạp file này một lần trong trang:  thẻ script với src="/duong-dan/lnt-chuyen-hoa.js" defer
 *
 * Mỗi dòng:  MÃ SÂN BAY | Tên hoa | Trạng thái | Link (không bắt buộc)
 * Trạng thái: "Đã hạ cánh" · "Đang bay" · "Mở đặt trước" (gõ có dấu hay không dấu đều được)
 *
 * Tuỳ chọn trên thẻ div:
 *   data-title="CHUYẾN HOA HÔM NAY"   tiêu đề bảng
 *   data-dest="HAN"                   mã điểm đến
 *   data-theme="dark" | "light"       màu bảng (mặc định dark)
 *   data-sheet="https://docs.google.com/.../pub?output=csv"  lấy dữ liệu từ Google Sheets (cột A–D)
 *   data-src="/api/chuyen-hoa"        lấy dữ liệu JSON: [{code, flower, status, link}]
 * Nếu có data-sheet / data-src mà tải lỗi, bảng tự dùng các dòng chữ viết sẵn bên trong.
 */
(function () {
  'use strict';
  var CSS = '' +
  '.lntch{--b:#3A2C24;--t:#241B16;--ti:#F4E8DC;--a:#E2AE84;--m:#BFA493;font-family:"Josefin Sans","Avenir Next","Century Gothic",system-ui,sans-serif;background:var(--b);color:var(--ti);border-radius:18px;padding:16px 16px 12px;box-shadow:0 30px 60px -24px rgba(0,0,0,.45);max-width:520px;box-sizing:border-box}' +
  '.lntch.light{--b:#FCF8F5;--t:#3A2C24;--ti:#F4E8DC;--a:#A8714E;--m:#8C6E5C;color:#5E4636;border:1px solid #E6D3C6;box-shadow:0 20px 40px -28px rgba(120,80,55,.35)}' +
  '.lntch *{box-sizing:border-box}' +
  '.lntch-h{display:flex;justify-content:space-between;align-items:center;color:var(--a);font-weight:600;letter-spacing:.18em;font-size:12px;margin:0 2px 10px}' +
  '.lntch-h time{color:var(--m);letter-spacing:.1em}' +
  '.lntch-r{display:grid;grid-template-columns:auto 1fr auto;gap:10px;align-items:center;padding:8px 4px;border-top:1px solid rgba(226,174,132,.16);text-decoration:none;color:inherit;border-radius:8px}' +
  'a.lntch-r:hover,a.lntch-r:focus-visible{background:rgba(226,174,132,.1);outline:none}' +
  'a.lntch-r:focus-visible{box-shadow:0 0 0 2px var(--a)}' +
  '.lntch-c{display:flex;gap:2px}' +
  '.lntch-f{width:15px;height:22px;background:var(--t);color:var(--ti);border-radius:3px;display:grid;place-items:center;font-size:11px;font-weight:600;position:relative;overflow:hidden;line-height:1}' +
  '.lntch-f:after{content:"";position:absolute;left:0;right:0;top:50%;height:1px;background:rgba(0,0,0,.6)}' +
  '.lntch-f.ar{background:transparent;color:var(--a)}.lntch-f.ar:after{display:none}' +
  '.lntch-n{font-family:Lora,Georgia,"Times New Roman",serif;font-size:14.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;opacity:.95}' +
  '.lntch-s{font-size:10.5px;letter-spacing:.12em;font-weight:600;border-radius:999px;padding:4px 9px;white-space:nowrap}' +
  '.lntch-s.landed{background:rgba(154,160,122,.25);color:#C9D1A4}.lntch-s.flying{background:rgba(226,174,132,.22);color:#E2AE84}.lntch-s.pre{background:rgba(201,179,218,.22);color:#D9C8E6}.lntch-s.other{background:rgba(255,255,255,.12)}' +
  '.lntch.light .lntch-s.landed{color:#6E7A45;background:rgba(154,160,122,.2)}.lntch.light .lntch-s.flying{color:#A8714E}.lntch.light .lntch-s.pre{color:#7A5F92}' +
  '.lntch-e{font-size:13px;color:var(--m);padding:10px 4px;border-top:1px solid rgba(226,174,132,.16)}' +
  '@media (max-width:420px){.lntch-f{width:12px;height:19px;font-size:9.5px}.lntch-n{font-size:13px}.lntch-s{font-size:9.5px;padding:3px 7px}}' +
  '@media (prefers-reduced-motion:reduce){.lntch *{animation:none!important;transition:none!important}}';

  function injectCSS() {
    if (document.getElementById('lntch-css')) return;
    var s = document.createElement('style'); s.id = 'lntch-css'; s.textContent = CSS;
    document.head.appendChild(s);
  }
  function strip(s) { return (s || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/đ/g, 'd').replace(/Đ/g, 'D').toLowerCase().trim(); }
  function status(raw) {
    var s = strip(raw);
    if (/ha canh|da ve|landed|co san|san hang/.test(s)) return { k: 'landed', t: 'ĐÃ HẠ CÁNH' };
    if (/dang bay|dang ve|flying|van chuyen/.test(s)) return { k: 'flying', t: 'ĐANG BAY' };
    if (/dat truoc|pre|preorder|order/.test(s)) return { k: 'pre', t: 'MỞ ĐẶT TRƯỚC' };
    return { k: 'other', t: (raw || '').toUpperCase() };
  }
  function esc(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
  function safeLink(u) { u = (u || '').trim(); if (!u) return ''; return /^(https?:\/\/|\/|#)/i.test(u) ? u : ''; }

  /* Đọc các dòng chữ viết sẵn trong khối (chịu được mọi trình soạn thảo: <p>, <li>, <br>, xuống dòng) */
  function readInline(el) {
    var html = el.innerHTML.replace(/<br\s*\/?>/gi, '\n').replace(/<\/(p|li|div|tr)>/gi, '\n');
    var tmp = document.createElement('div'); tmp.innerHTML = html;
    var text = tmp.textContent || '';
    return text.split(/\n+/).map(function (l) { return l.trim(); })
      .filter(function (l) { return l && l.indexOf('|') > -1; })
      .map(function (l) { var p = l.split('|').map(function (x) { return x.trim(); }); return { code: p[0], flower: p[1], status: p[2], link: p[3] }; });
  }
  function parseCSV(t) {
    var rows = [], row = [], cur = '', q = false;
    for (var i = 0; i < t.length; i++) {
      var c = t[i];
      if (q) { if (c === '"' && t[i + 1] === '"') { cur += '"'; i++; } else if (c === '"') q = false; else cur += c; }
      else if (c === '"') q = true; else if (c === ',') { row.push(cur); cur = ''; }
      else if (c === '\n' || c === '\r') { if (c === '\r' && t[i + 1] === '\n') i++; row.push(cur); rows.push(row); row = []; cur = ''; }
      else cur += c;
    }
    if (cur || row.length) { row.push(cur); rows.push(row); }
    return rows.filter(function (r) { return r.some(function (x) { return x.trim(); }); })
      .map(function (r) { return { code: (r[0] || '').trim(), flower: (r[1] || '').trim(), status: (r[2] || '').trim(), link: (r[3] || '').trim() }; })
      .filter(function (r) { return /^[A-Za-z]{3}$/.test(r.code); }); // bỏ dòng tiêu đề
  }

  var CH = 'ABCDEGHIKLMNOPQRSTUVXY';
  var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
  function cells(code) {
    return code.split('').map(function (c) { return '<span class="lntch-f" data-c="' + esc(c) + '">' + (reduce ? esc(c) : '') + '</span>'; }).join('');
  }
  function render(el, data) {
    var title = el.getAttribute('data-title') || 'CHUYẾN HOA HÔM NAY';
    var dest = (el.getAttribute('data-dest') || 'HAN').toUpperCase().slice(0, 3);
    var rows = data.filter(function (d) { return d && d.code; }).slice(0, 8);
    var h = '<div class="lntch-h"><span>' + esc(title) + '</span><time aria-label="Giờ hiện tại"></time></div>';
    if (!rows.length) h += '<div class="lntch-e">Các chuyến hoa mới sẽ sớm cập bến.</div>';
    rows.forEach(function (d) {
      var code = String(d.code).toUpperCase().replace(/[^A-Z]/g, '').slice(0, 3);
      var st = status(d.status), link = safeLink(d.link), tag = link ? 'a' : 'div';
      h += '<' + tag + ' class="lntch-r"' + (link ? ' href="' + esc(link) + '"' : '') + ' aria-label="' + esc(code + ' đến ' + dest + ': ' + d.flower + ', ' + st.t.toLowerCase()) + '">' +
        '<span class="lntch-c" aria-hidden="true">' + cells(code) + '<span class="lntch-f ar">→</span>' + cells(dest) + '</span>' +
        '<span class="lntch-n">' + esc(d.flower) + '</span><span class="lntch-s ' + st.k + '">' + esc(st.t) + '</span></' + tag + '>';
    });
    el.innerHTML = h; el.classList.add('lntch'); el.hidden = false;
    if ((el.getAttribute('data-theme') || '').toLowerCase() === 'light') el.classList.add('light');
    if (!reduce) [].forEach.call(el.querySelectorAll('.lntch-f[data-c]'), function (s) {
      var n = 8 + Math.floor(Math.random() * 8);
      (function k() { if (n-- <= 0) { s.textContent = s.getAttribute('data-c'); return; } s.textContent = CH[Math.floor(Math.random() * CH.length)]; setTimeout(k, 60); })();
    });
    var tm = el.querySelector('time');
    function tick() { try { tm.textContent = new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' }); } catch (e) {} }
    tick(); setInterval(tick, 30000);
  }
  function boot(el) {
    if (el.getAttribute('data-lntch-ready')) return; el.setAttribute('data-lntch-ready', '1');
    var inline = readInline(el), src = el.getAttribute('data-src'), sheet = el.getAttribute('data-sheet');
    el.hidden = true;
    var fallback = function () { render(el, inline); };
    if (src) {
      fetch(src, { credentials: 'same-origin' }).then(function (r) { if (!r.ok) throw 0; return r.json(); })
        .then(function (j) { var a = Array.isArray(j) ? j : (j && j.items) || []; a.length ? render(el, a) : fallback(); }).catch(fallback);
    } else if (sheet) {
      fetch(sheet).then(function (r) { if (!r.ok) throw 0; return r.text(); })
        .then(function (t) { var a = parseCSV(t); a.length ? render(el, a) : fallback(); }).catch(fallback);
    } else fallback();
  }
  function init() { injectCSS(); [].forEach.call(document.querySelectorAll('.lnt-chuyen-hoa'), boot); }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();
  window.LNTChuyenHoa = { refresh: init };
})();

