@push('styles')
<style>
.seasonal{--bg:#f5ebe6;--paper:#fcf8f5;--ink:#5e4636;--soft:#8c6e5c;--accent:#c78e66;--deep:#2f5a47;--line:#e6d3c6;background:var(--bg);color:var(--ink);min-height:70vh}
.seasonal *{box-sizing:border-box}.seasonal a{color:inherit}.seasonal .wrap{max-width:1200px;margin:auto;padding-left:clamp(1rem,4vw,3rem);padding-right:clamp(1rem,4vw,3rem)}
.seasonal .hero{padding:clamp(3rem,7vw,6rem) 0}.seasonal .hero-grid{display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:center}
.seasonal .eyebrow{color:var(--accent);font-size:.75rem;font-weight:700;letter-spacing:.24em;margin:0 0 .8rem}.seasonal h1,.seasonal h2{color:var(--accent);text-transform:uppercase;line-height:1.08}
.seasonal h1{font-size:clamp(2.2rem,5vw,4rem);margin:0}.seasonal .lead{font-family:Georgia,serif;color:var(--soft);font-size:1.08rem;line-height:1.75}
.seasonal .board{background:#3a2c24;color:#f4e8dc;border-radius:20px;padding:1rem;box-shadow:0 30px 60px -28px rgba(0,0,0,.4)}
.seasonal .board-head{display:flex;justify-content:space-between;color:#e2ae84;font-size:.72rem;font-weight:700;letter-spacing:.18em;margin-bottom:.5rem}
.seasonal .flight{display:grid;grid-template-columns:70px 1fr auto;gap:.75rem;align-items:center;padding:.8rem .25rem;border-top:1px solid rgba(226,174,132,.15);text-decoration:none}.seasonal .flight strong{letter-spacing:.15em}.seasonal .flight small{display:block;color:#bfa493;margin-top:.2rem}.seasonal .status{font-size:.65rem;letter-spacing:.1em;padding:.3rem .55rem;border-radius:999px;background:rgba(226,174,132,.2)}
.seasonal .cards{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;padding-bottom:4rem}.seasonal .season-card,.seasonal .product{background:var(--paper);border:1px solid var(--line);border-radius:22px;overflow:hidden;text-decoration:none}.seasonal .season-card{padding:1.5rem;min-height:220px;display:flex;flex-direction:column;justify-content:flex-end}.seasonal .season-card span{color:var(--accent);font-weight:700;letter-spacing:.14em}.seasonal .season-card h2{margin:.5rem 0}.seasonal .season-card p{font-family:Georgia,serif;color:var(--soft)}
.seasonal .back{display:inline-block;margin-bottom:1rem;text-decoration:none}.seasonal .actions{display:flex;gap:.75rem;flex-wrap:wrap;margin-top:1.5rem}.seasonal .btn{border:1px solid var(--accent);border-radius:999px;background:transparent;color:var(--accent);cursor:pointer;padding:.8rem 1.2rem;text-decoration:none;font-weight:700}.seasonal .btn.primary{background:var(--accent);color:white}
.seasonal .products{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;padding:1rem 0 4rem}.seasonal .product img{width:100%;aspect-ratio:1.2;object-fit:cover}.seasonal .product div{padding:1rem}.seasonal .product h3{margin:0 0 .25rem}.seasonal .product p{margin:0;color:var(--soft)}
.seasonal .preorder{padding:1rem 0 5rem}.seasonal .preorder-grid{display:grid;grid-template-columns:1fr 1fr;gap:2rem;align-items:start}.seasonal .sizes{display:flex;flex-wrap:wrap;gap:.5rem}.seasonal .size{border:1px solid var(--line);background:var(--paper);border-radius:12px;padding:.65rem .9rem;cursor:pointer}.seasonal .size[aria-checked=true]{background:var(--deep);border-color:var(--deep);color:white}.seasonal .tree{height:300px;display:flex;align-items:flex-end;justify-content:center;margin:1rem 0;background:linear-gradient(#dce5de,#f7f8f4);border-radius:20px;overflow:hidden}.seasonal .tree-shape{width:0;height:0;border-left:110px solid transparent;border-right:110px solid transparent;border-bottom:260px solid #2f5a47;transform:scale(var(--tree-scale));transform-origin:bottom}.seasonal .order-form{background:var(--paper);border:1px solid var(--line);border-radius:22px;padding:1.25rem}.seasonal .order-form label{display:grid;gap:.3rem;margin:.8rem 0;color:var(--soft);font-size:.85rem}.seasonal .order-form input,.seasonal .order-form textarea{font:inherit;color:var(--ink);border:1px solid var(--line);border-radius:10px;background:var(--bg);padding:.7rem}.seasonal .checks label{display:flex;align-items:center;gap:.5rem;margin:.4rem 0}.seasonal .feedback{min-height:1.4em;color:#a43f32}.seasonal .success{padding:1rem;border-radius:12px;background:#e4eee7;color:#234a38}.seasonal .faq{padding:1rem 0}.seasonal details{background:var(--paper);border:1px solid var(--line);border-radius:12px;padding:1rem;margin:.5rem 0}
@media(max-width:800px){.seasonal .hero-grid,.seasonal .preorder-grid{grid-template-columns:1fr}.seasonal .cards,.seasonal .products{grid-template-columns:1fr}.seasonal .flight{grid-template-columns:60px 1fr}.seasonal .status{grid-column:2}}
</style>
@endpush

<main class="seasonal" id="seasonalApp"></main>

<script>
(() => {
    const config = @json($seasonConfig);
    const app = document.getElementById('seasonalApp');
    const preorderUrl = @json(route('season.preorder'));
    const csrf = @json(csrf_token());
    const esc = value => String(value ?? '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[char]));
    const safeUrl = value => /^(https?:\/\/|\/|#)/i.test(value ?? '') ? value : '#';
    const currentSeason = () => config.seasons.find(season => season.id === location.hash.slice(1).split('/')[0]);

    function hub() {
        app.innerHTML = `<section class="hero"><div class="wrap hero-grid"><div><p class="eyebrow">${esc(config.hub.eyebrow)}</p><h1>${esc(config.hub.title)}</h1><p class="lead">${esc(config.hub.intro)}</p></div><div class="board"><div class="board-head"><span>LỊCH BAY MÙA LỄ</span><span>HAN</span></div>${config.seasons.map(season => `<a class="flight" href="#${esc(season.id)}"><strong>${esc(season.code)} → HAN</strong><span>${esc(season.name)}<small>${esc(season.tagline)}</small></span><span class="status">${esc(season.status)}</span></a>`).join('')}</div></div></section><section class="wrap cards">${config.seasons.map(season => `<a class="season-card" href="#${esc(season.id)}"><span>${esc(season.code)} → HAN</span><h2>${esc(season.name)}</h2><p>${esc(season.tagline)}</p></a>`).join('')}</section>`;
    }

    function seasonPage(season) {
        app.innerHTML = `<section class="hero"><div class="wrap"><a class="back" href="#">← Lịch bay mùa lễ</a><p class="eyebrow">${esc(season.code)} → HAN · ${esc(season.status)}</p><h1>${esc(season.name)}</h1><p class="lead">${esc(season.intro)}</p><div class="actions"><a class="btn primary" href="${esc(safeUrl(season.cta?.link))}">${esc(season.cta?.label)}</a></div></div></section>${products(season)}${season.tree ? preorder(season) : ''}`;
        if (season.tree) bindPreorder(season);
    }

    function products(season) {
        if (!season.products?.length) return '';
        return `<section class="wrap"><p class="eyebrow">BỘ SƯU TẬP</p><div class="products">${season.products.map(product => `<a class="product" href="${esc(safeUrl(product.link))}"><img src="${esc(safeUrl(product.image))}" alt="${esc(product.name)}" loading="lazy"><div><h3>${esc(product.name)}</h3><p>${esc(product.origin)} · ${esc(product.code)}</p></div></a>`).join('')}</div></section>`;
    }

    function preorder(season) {
        const tree = season.tree;
        return `<section class="preorder" id="dat-truoc"><div class="wrap preorder-grid"><div><p class="eyebrow">ĐẶT TRƯỚC · CPH → HAN</p><h2>Chọn chiều cao cây</h2><div class="sizes">${tree.sizes.map((size, index) => `<button type="button" class="size" data-index="${index}" aria-checked="${index === 2}">${esc(size.label)}</button>`).join('')}</div><div class="tree"><div class="tree-shape"></div></div><p>Hàng về: <strong>${esc(tree.arrival)}</strong><br>Đặt cọc: <strong>${esc(tree.deposit)}</strong></p></div><form class="order-form" id="preorderForm"><h2>Phiếu đặt trước</h2><div class="checks"><strong>Phụ kiện</strong>${tree.accessories.map(item => `<label><input type="checkbox" name="accessories[]" value="${esc(item)}"> ${esc(item)}</label>`).join('')}</div><div class="checks"><strong>Dịch vụ đi kèm</strong>${tree.addons.map(item => `<label><input type="checkbox" name="addons[]" value="${esc(item)}"> ${esc(item)}</label>`).join('')}</div><label>Họ và tên *<input name="name" required autocomplete="name"></label><label>Số điện thoại / Zalo *<input name="phone" required autocomplete="tel"></label><label>Địa chỉ nhận cây *<input name="address" required autocomplete="street-address"></label><label>Ngày nhận mong muốn<input name="delivery_date" type="date"></label><label>Ghi chú<textarea name="notes" rows="3"></textarea></label><p class="feedback" id="preorderFeedback" aria-live="polite"></p><button class="btn primary" type="submit">Gửi đặt trước</button></form></div><div class="wrap faq"><h2>Câu hỏi thường gặp</h2>${tree.faq.map(item => `<details><summary>${esc(item.question)}</summary><p>${esc(item.answer)}</p></details>`).join('')}</div></section>`;
    }

    function bindPreorder(season) {
        const tree = season.tree;
        let selected = Math.min(2, tree.sizes.length - 1);
        const shape = app.querySelector('.tree-shape');
        const sizes = [...app.querySelectorAll('.size')];
        const selectSize = index => {
            selected = index;
            sizes.forEach((button, i) => button.setAttribute('aria-checked', String(i === index)));
            shape.style.setProperty('--tree-scale', Math.max(.55, tree.sizes[index].cm / 240));
        };
        sizes.forEach((button, index) => button.addEventListener('click', () => selectSize(index)));
        selectSize(selected);

        app.querySelector('#preorderForm').addEventListener('submit', async event => {
            event.preventDefault();
            const form = event.currentTarget;
            const feedback = app.querySelector('#preorderFeedback');
            const data = new FormData(form);
            const payload = {
                season_slug: @json($seasonPage->slug), size: tree.sizes[selected].label,
                accessories: data.getAll('accessories[]'), addons: data.getAll('addons[]'),
                name: data.get('name'), phone: data.get('phone'), address: data.get('address'),
                delivery_date: data.get('delivery_date') || null, notes: data.get('notes') || null,
            };
            feedback.textContent = 'Đang gửi phiếu đặt trước…';
            try {
                const response = await fetch(preorderUrl, {method: 'POST', headers: {'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf}, body: JSON.stringify(payload)});
                const result = await response.json();
                if (!response.ok) throw new Error(result.message || Object.values(result.errors || {}).flat()[0] || 'Không thể gửi phiếu đặt trước.');
                form.innerHTML = `<div class="success" role="status"><strong>Đã nhận phiếu đặt trước.</strong><p>${esc(result.message)}</p></div>`;
            } catch (error) {
                feedback.textContent = error.message || 'Chưa gửi được phiếu. Vui lòng thử lại.';
            }
        });
    }

    function render() {
        if (location.hash === '#dat-truoc') {
            seasonPage(config.seasons.find(item => item.tree));
            requestAnimationFrame(() => document.getElementById('dat-truoc')?.scrollIntoView());
            return;
        }
        const season = currentSeason();
        season ? seasonPage(season) : hub();
    }

    addEventListener('hashchange', render);
    render();
})();
</script>
