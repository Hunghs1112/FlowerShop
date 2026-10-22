/*!
 * LNT · Popup mùa lễ (pre-order cây thông, 20/10, 8/3, Valentine, Tết…)  v1.0
 * Không cần thư viện. Nội dung nằm trong khối cấu hình JSON – sửa bằng trang "popup-builder.html".
 *
 * GẮN VÀO WEBSITE (1 lần, ở cuối trang hoặc phần "mã tuỳ chỉnh" của admin):
 *   <script type="application/json" id="lnt-popup-config"> { ...cấu hình... } </script>
 *   <script src="/assets/lnt-popup.js" defer></script>
 *
 * Popup tự chọn đợt lễ đang diễn ra (theo ngày bắt đầu – kết thúc, giờ Việt Nam).
 * Xem thử bất kỳ lúc nào: thêm ?popup=<id> vào cuối link, ví dụ lamnhienthao.com/?popup=cay-thong
 */
(function () {
  'use strict';
  var THEMES = {
    cream:  { bg: '#FCF8F5', ink: '#5E4636', soft: '#8C6E5C', acc: '#C78E66', band: '#3A2C24', band2: '#E2AE84', line: '#E6D3C6' },
    nordic: { bg: '#F5F2EA', ink: '#22362C', soft: '#5C6F62', acc: '#2F5A47', band: '#1C3A2E', band2: '#D9B36A', line: '#D8DDD2' },
    rose:   { bg: '#FDF4F4', ink: '#5A2E3A', soft: '#8E6370', acc: '#C25B7A', band: '#4E1F31', band2: '#F0B6C6', line: '#F0D6DC' },
    autumn: { bg: '#FBF2E7', ink: '#4A2A1A', soft: '#86624A', acc: '#B5562F', band: '#3E2416', band2: '#E9A15E', line: '#EBD7C2' },
    night:  { bg: '#1E1628', ink: '#F3E8F7', soft: '#BBAACB', acc: '#E9853A', band: '#0F0B15', band2: '#F2A65E', line: '#3A2F48' }
  };
  var ART = {
    nordic: '<svg viewBox="0 0 200 260" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="3" stroke-linejoin="round"><path d="M100 20l40 60h-22l38 56h-24l40 58H28l40-58H44l38-56H60z"/><path d="M92 194h16v34H92z"/></g><g fill="currentColor"><circle cx="100" cy="14" r="7"/><circle cx="84" cy="110" r="5"/><circle cx="122" cy="150" r="5"/><circle cx="76" cy="176" r="5"/><circle cx="132" cy="190" r="5"/></g></svg>',
    rose: '<svg viewBox="0 0 200 260" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><circle cx="100" cy="90" r="16"/><path d="M100 64c22 0 36 16 30 36M100 64c-22 0-36 16-30 36M72 100c-2 24 12 40 28 40s30-16 28-40"/><path d="M100 40c34 0 58 22 58 54 0 34-24 58-58 58s-58-24-58-58c0-32 24-54 58-54z"/><path d="M100 152v90M100 196c-20-6-34-22-36-40 18 2 32 16 36 40zM100 214c18-6 30-20 32-38-16 2-28 14-32 38z"/></g></svg>',
    autumn: '<svg viewBox="0 0 200 260" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="3" stroke-linejoin="round"><path d="M100 30l14 34 30-14-8 34 34 6-28 22 18 28-34-6-6 36-20-28-20 28-6-36-34 6 18-28-28-22 34-6-8-34 30 14z"/><path d="M100 70v170"/></g></svg>',
    night: '<svg viewBox="0 0 200 260" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="3"><ellipse cx="100" cy="140" rx="70" ry="56"/><path d="M100 84c-10-20 0-34 14-38M70 92c-16 20-16 76 0 96M130 92c16 20 16 76 0 96"/></g><g fill="currentColor"><path d="M74 130l14-10 6 16zM126 130l-14-10-6 16zM80 166c14 10 26 10 40 0-6 14-34 14-40 0z"/></g></svg>',
    cream: '<svg viewBox="0 0 200 260" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><path d="M100 120c-14-28-42-28-48-10 8 14 28 20 48 10zM100 120c14-28 42-28 48-10-8 14-28 20-48 10zM100 120c-14-14-14-42 0-52 14 10 14 38 0 52zM100 120c-24 6-40 26-30 40 14 2 26-16 30-40zM100 120c24 6 40 26 30 40-14 2-26-16-30-40z"/><path d="M100 160v84"/></g></svg>'
  };
  var CSS = '' +
  '.lntp-ov{position:fixed;inset:0;z-index:2147483000;background:rgba(25,16,12,.55);display:flex;align-items:center;justify-content:center;padding:16px;opacity:0;transition:opacity .3s}' +
  '.lntp-ov.on{opacity:1}' +
  '.lntp{--bg:#FCF8F5;--ink:#5E4636;--soft:#8C6E5C;--acc:#C78E66;--band:#3A2C24;--band2:#E2AE84;--line:#E6D3C6;position:relative;width:min(780px,100%);max-height:calc(100vh - 32px);overflow:auto;background:var(--bg);color:var(--ink);border-radius:22px;display:grid;grid-template-columns:42% 1fr;box-shadow:0 40px 90px -30px rgba(0,0,0,.55);font-family:"Josefin Sans","Avenir Next","Century Gothic",system-ui,sans-serif;transform:translateY(16px) scale(.98);transition:transform .35s cubic-bezier(.2,.9,.3,1)}' +
  '.lntp-ov.on .lntp{transform:none}' +
  '.lntp.inline{box-shadow:0 30px 60px -36px rgba(0,0,0,.45);transform:none}' +
  '.lntp *{box-sizing:border-box}' +
  '.lntp-media{position:relative;min-height:320px;background:var(--band);color:var(--band2);display:flex;align-items:center;justify-content:center}' +
  '.lntp-media img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}' +
  '.lntp-media svg{width:56%;max-width:190px;opacity:.9}' +
  '.lntp-media::after{content:"";position:absolute;top:0;bottom:0;right:-1px;width:0;border-right:3px dashed var(--bg)}' +
  '.lntp-stamp{position:absolute;left:14px;bottom:14px;z-index:1;width:84px;height:84px;border-radius:50%;border:2px solid rgba(255,255,255,.85);color:#fff;display:grid;place-items:center;text-align:center;font-size:10px;letter-spacing:.14em;font-weight:600;line-height:1.3;background:rgba(0,0,0,.18);transform:rotate(-10deg);backdrop-filter:blur(2px)}' +
  '.lntp-stamp b{display:block;font-size:17px;letter-spacing:.06em}' +
  '.lntp-body{padding:0 0 22px}' +
  '.lntp-band{display:flex;justify-content:space-between;gap:12px;background:var(--band);color:var(--band2);font-size:11px;letter-spacing:.2em;font-weight:600;padding:12px 56px 12px 22px}' +
  '.lntp-in{padding:18px 24px 0}' +
  '.lntp h2{font-family:Lora,Georgia,serif;font-weight:500;font-size:clamp(24px,4.4vw,34px);line-height:1.12;margin:4px 0 10px;color:var(--ink)}' +
  '.lntp p{margin:0 0 12px;line-height:1.6;color:var(--soft);font-size:15px}' +
  '.lntp ul{list-style:none;padding:0;margin:0 0 14px}' +
  '.lntp li{position:relative;padding-left:24px;margin:6px 0;font-size:15px;color:var(--ink);line-height:1.45}' +
  '.lntp li::before{content:"";position:absolute;left:2px;top:6px;width:12px;height:7px;border-left:2px solid var(--acc);border-bottom:2px solid var(--acc);transform:rotate(-45deg)}' +
  '.lntp-cd{display:flex;align-items:center;gap:8px;margin:4px 0 16px;flex-wrap:wrap}' +
  '.lntp-cd span{font-size:11px;letter-spacing:.16em;color:var(--soft);font-weight:600;margin-right:4px}' +
  '.lntp-cd i{font-style:normal;display:grid;place-items:center;min-width:52px;padding:6px 4px;border-radius:10px;background:var(--band);color:var(--band2);font-weight:600;font-size:20px;line-height:1;font-variant-numeric:tabular-nums}' +
  '.lntp-cd i small{display:block;font-size:9px;letter-spacing:.14em;margin-top:4px;color:rgba(255,255,255,.7);font-weight:600}' +
  '.lntp-btns{display:flex;gap:10px;flex-wrap:wrap}' +
  '.lntp-btn{display:inline-flex;align-items:center;justify-content:center;font:600 15px "Josefin Sans",system-ui,sans-serif;letter-spacing:.03em;background:var(--acc);color:#fff;border:1.5px solid var(--acc);border-radius:999px;padding:12px 20px;text-decoration:none;cursor:pointer}' +
  '.lntp-btn:hover{filter:brightness(.92)}.lntp-btn.ghost{background:transparent;color:var(--acc)}' +
  '.lntp-note{font-size:12.5px!important;margin:12px 0 0!important;font-family:Lora,Georgia,serif;font-style:italic}' +
  '.lntp-x{position:absolute;top:8px;right:10px;z-index:2;display:grid;place-items:center;width:30px;height:30px;padding:0;border:1px solid currentColor;border-radius:50%;background:rgba(255,255,255,.14);color:var(--band2);font:400 20px/1 Arial,sans-serif;cursor:pointer}' +
  '.lntp-x:hover{background:rgba(255,255,255,.26)}' +
  '.lntp-btn:focus-visible,.lntp-teaser:focus-visible{outline:3px solid var(--band2);outline-offset:2px}' +
  '.lntp-x:focus-visible{outline:0;border-width:2px;background:rgba(255,255,255,.3)}' +
  '.lntp-teaser{position:fixed;left:16px;bottom:calc(16px + env(safe-area-inset-bottom,0px));z-index:2147482999;display:flex;align-items:center;gap:8px;border:0;border-radius:999px;padding:10px 16px 10px 12px;font:600 14px "Josefin Sans",system-ui,sans-serif;cursor:pointer;box-shadow:0 14px 30px -12px rgba(0,0,0,.45);animation:lntpIn .4s ease}' +
  '.lntp-teaser .d{width:10px;height:10px;border-radius:50%;animation:lntpPulse 1.8s infinite}' +
  '@keyframes lntpIn{from{transform:translateY(20px);opacity:0}}@keyframes lntpPulse{50%{opacity:.35}}' +
  '@media (max-width:640px){.lntp{grid-template-columns:1fr}.lntp-media{min-height:190px;max-height:34vh}.lntp-media::after{top:auto;left:0;right:0;bottom:-1px;width:auto;height:0;border-right:0;border-bottom:3px dashed var(--bg)}.lntp-in{padding:16px 18px 0}.lntp-band{padding:11px 52px 11px 18px;font-size:10px;letter-spacing:.16em}.lntp-x{background:rgba(0,0,0,.25);color:#fff}}' +
  '.lntp-band span:last-child{white-space:nowrap}' +
  '@media (prefers-reduced-motion:reduce){.lntp-ov,.lntp,.lntp-teaser,.lntp-teaser .d{transition:none!important;animation:none!important}}';
  function css() { if (document.getElementById('lntp-css')) return; var s = document.createElement('style'); s.id = 'lntp-css'; s.textContent = CSS; document.head.appendChild(s); }
  function esc(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
  function safe(u) { u = String(u || '').trim(); return /^(https?:\/\/|\/|#|data:image\/|mailto:|tel:)/i.test(u) ? u : ''; }
  function vnNow() { var d = new Date(); var v = new Date(d.toLocaleString('en-US', { timeZone: 'Asia/Ho_Chi_Minh' })); return isNaN(v) ? d : v; }
  function day(s, end) { if (!s) return null; var p = String(s).split('-'); var d = new Date(+p[0], +p[1] - 1, +p[2]); if (end) d.setHours(23, 59, 59); return d; }
  function pad(n) { return (n < 10 ? '0' : '') + n; }
  function build(c, cfg, inline) {
    var th = THEMES[c.theme] || THEMES.cream;
    var cp = cfg.copy || {};
    var el = document.createElement('div');
    el.className = 'lntp' + (inline ? ' inline' : '');
    el.setAttribute('role', 'dialog'); el.setAttribute('aria-modal', inline ? 'false' : 'true'); el.setAttribute('aria-labelledby', 'lntp-t-' + (c.id || 'x'));
    Object.keys(th).forEach(function (k) { el.style.setProperty('--' + k, th[k]); });
    var img = safe(c.image);
    var media = '<div class="lntp-media">' + (img ? '<img src="' + esc(img) + '" alt="' + esc(c.imageAlt || '') + '">' : (ART[c.theme] || ART.cream)) +
      (c.stamp ? '<div class="lntp-stamp"><span><b>' + esc(c.stamp) + '</b>' + esc(c.stampSub || '') + '</span></div>' : '') + '</div>';
    var bullets = (c.bullets || []).filter(Boolean);
    var z = String(cfg.zalo || '').replace(/\D/g, '');
    var b2 = c.cta2 === 'zalo' && z ? '<a class="lntp-btn ghost" href="https://zalo.me/' + z + '" target="_blank" rel="noopener">' + esc(cp.zalo || 'Tư vấn qua Zalo') + '</a>' :
             (c.cta2Label && safe(c.cta2Link) ? '<a class="lntp-btn ghost" href="' + esc(safe(c.cta2Link)) + '">' + esc(c.cta2Label) + '</a>' : '');
    el.innerHTML = media + '<div class="lntp-body">' +
      '<div class="lntp-band"><span>' + esc(c.eyebrow || '') + '</span><span>' + esc(c.route || '') + '</span></div>' +
      '<div class="lntp-in"><h2 id="lntp-t-' + esc(c.id || 'x') + '">' + esc(c.title || '') + '</h2>' +
      (c.text ? '<p>' + esc(c.text) + '</p>' : '') +
      (bullets.length ? '<ul>' + bullets.map(function (b) { return '<li>' + esc(b) + '</li>'; }).join('') + '</ul>' : '') +
      (c.countdown ? '<div class="lntp-cd" aria-live="off"><span>' + esc(c.countdownLabel || cp.remaining || 'CÒN') + '</span><i data-k="d">--<small>' + esc(cp.days || 'NGÀY') + '</small></i><i data-k="h">--<small>' + esc(cp.hours || 'GIỜ') + '</small></i><i data-k="m">--<small>' + esc(cp.minutes || 'PHÚT') + '</small></i></div>' : '') +
      '<div class="lntp-btns">' + (c.ctaLabel ? '<a class="lntp-btn" href="' + esc(safe(c.ctaLink) || '#') + '">' + esc(c.ctaLabel) + '</a>' : '') + b2 + '</div>' +
      (c.note ? '<p class="lntp-note">' + esc(c.note) + '</p>' : '') + '</div></div>' +
      '<button type="button" class="lntp-x" aria-label="' + esc(cp.close || 'Đóng') + '">×</button>';
    if (c.countdown) {
      var target = new Date(c.countdown);
      var tick = function () {
        var s = Math.max(0, Math.floor((target - new Date()) / 1000));
        var m = { d: Math.floor(s / 86400), h: Math.floor(s % 86400 / 3600), m: Math.floor(s % 3600 / 60) };
        [].forEach.call(el.querySelectorAll('.lntp-cd i'), function (i) { i.firstChild.nodeValue = pad(m[i.getAttribute('data-k')]); });
      };
      tick(); el._timer = setInterval(tick, 30000);
    }
    return el;
  }
  var lastFocus = null;
  function open(c, cfg, opts) {
    css(); opts = opts || {};
    close(true);
    var ov = document.createElement('div'); ov.className = 'lntp-ov'; ov.id = 'lntp-ov';
    var box = build(c, cfg, false); ov.appendChild(box); document.body.appendChild(ov);
    lastFocus = document.activeElement;
    requestAnimationFrame(function () { ov.classList.add('on'); });
    var x = box.querySelector('.lntp-x'); x.focus();
    x.addEventListener('click', function () { close(); });
    ov.addEventListener('click', function (e) { if (e.target === ov) close(); });
    ov.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') { close(); return; }
      if (e.key === 'Tab') { var f = box.querySelectorAll('a,button'); if (!f.length) return; var a = f[0], z = f[f.length - 1];
        if (e.shiftKey && document.activeElement === a) { e.preventDefault(); z.focus(); } else if (!e.shiftKey && document.activeElement === z) { e.preventDefault(); a.focus(); } }
    });
    box.querySelectorAll('.lntp-btns a').forEach(function (a) { a.addEventListener('click', function () { mark(c, cfg); }); });
    ov._c = c; ov._cfg = cfg; ov._box = box;
  }
  function close(silent) {
    var ov = document.getElementById('lntp-ov'); if (!ov) return;
    clearInterval(ov._box && ov._box._timer);
    var c = ov._c, cfg = ov._cfg;
    ov.classList.remove('on'); setTimeout(function () { ov.remove(); }, 250);
    if (!silent) { mark(c, cfg); teaser(c, cfg); if (lastFocus && lastFocus.focus) lastFocus.focus(); }
  }
  function key(c) { return 'lntp-seen-' + (c.id || 'x'); }
  function mark(c) { try { localStorage.setItem(key(c), String(Date.now())); sessionStorage.setItem(key(c), '1'); } catch (e) {} }
  function seen(c, cfg) {
    var f = cfg.frequency || 'day';
    try {
      if (f === 'always') return false;
      if (f === 'session') return !!sessionStorage.getItem(key(c));
      if (f === 'once') return !!localStorage.getItem(key(c));
      var t = +localStorage.getItem(key(c)) || 0; return Date.now() - t < 864e5;
    } catch (e) { return false; }
  }
  function teaser(c, cfg) {
    if (!c.teaser) return; var old = document.getElementById('lntp-teaser'); if (old) old.remove();
    var th = THEMES[c.theme] || THEMES.cream;
    var b = document.createElement('button'); b.type = 'button'; b.id = 'lntp-teaser'; b.className = 'lntp-teaser';
    b.style.background = th.band; b.style.color = th.band2;
    b.innerHTML = '<span class="d" style="background:' + th.band2 + '"></span>' + esc(c.teaser);
    b.addEventListener('click', function () { b.remove(); open(c, cfg); });
    document.body.appendChild(b);
  }
  function pick(cfg) {
    var now = vnNow(), forced = (location.search.match(/[?&]popup=([^&]+)/) || [])[1];
    var list = cfg.campaigns || [];
    if (forced) { for (var i = 0; i < list.length; i++) if (list[i].id === decodeURIComponent(forced)) return { c: list[i], forced: true }; }
    for (var j = 0; j < list.length; j++) { var c = list[j]; if (c.active === false) continue;
      var s = day(c.start), e = day(c.end, true); if ((!s || now >= s) && (!e || now <= e)) return { c: c }; }
    return null;
  }
  function init() {
    if (window.__LNTP_NOAUTO) return;
    var node = document.getElementById('lnt-popup-config'); if (!node) return;
    var cfg; try { cfg = JSON.parse(node.textContent); } catch (e) { console.warn('LNT popup: cấu hình JSON bị lỗi', e); return; }
    var hit = pick(cfg); if (!hit) return;
    css();
    if (!hit.forced && seen(hit.c, cfg)) { teaser(hit.c, cfg); return; }
    setTimeout(function () { open(hit.c, cfg); }, hit.forced ? 300 : Math.max(0, +(cfg.delay == null ? 4 : cfg.delay)) * 1000);
  }
  window.LNTPopup = { open: open, close: close, build: function (c, cfg) { css(); return build(c, cfg, true); }, themes: Object.keys(THEMES) };
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();
})();
