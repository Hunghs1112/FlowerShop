(() => {
    const root = document.getElementById('aboutAtlas');
    if (!root) return;
    const tabs = [...root.querySelectorAll('#aboutChips [data-id]')];
    const pins = [...root.querySelectorAll('.atlas-pin[data-id]')];
    const countries = [...root.querySelectorAll('[data-origin]')];
    const routes = [...root.querySelectorAll('.atlas-route[data-id]')];
    const viewport = root.querySelector('#atlasViewport');
    const map = root.querySelector('#atlasMap');
    const card = root.querySelector('#aboutCard');
    const fields = Object.fromEntries(['Image', 'Country', 'Flower', 'Latin', 'Region', 'Coordinate', 'Link']
        .map(name => [name.toLowerCase(), root.querySelector(`#card${name}`)]));
    let selected = tabs[0].dataset.id;
    let zoom = window.matchMedia('(max-width: 767px)').matches ? 3 : 1;

    function center() {
        const pin = pins.find(item => item.dataset.id === selected);
        const scale = map.getBoundingClientRect().width / 1200;
        viewport.scrollTo({ left: Number(pin.dataset.x) * scale - viewport.clientWidth / 2,
            top: Number(pin.dataset.y) * scale - viewport.clientHeight / 2 });
    }

    function setZoom(value, recenter = true) {
        zoom = Math.max(1, Math.min(3, value));
        map.style.width = `${zoom * 100}%`;
        root.querySelector('#atlasZoom').textContent = `${Math.round(zoom * 100)}%`;
        root.querySelector('[data-zoom="out"]').disabled = zoom === 1;
        root.querySelector('[data-zoom="in"]').disabled = zoom === 3;
        if (recenter) requestAnimationFrame(center);
        else viewport.scrollTo(0, 0);
    }

    function select(id, focus = false, recenter = false) {
        const tab = tabs.find(item => item.dataset.id === id);
        if (!tab) return;
        selected = id;
        tabs.forEach(item => {
            item.setAttribute('aria-selected', String(item === tab));
            item.tabIndex = item === tab ? 0 : -1;
        });
        pins.forEach(pin => {
            const active = pin.dataset.id === id;
            pin.classList.toggle('is-selected', active);
            pin.setAttribute('aria-pressed', String(active));
        });
        countries.forEach(country => country.classList.toggle('is-selected', country.dataset.origin === id));
        routes.forEach(route => route.classList.toggle('is-selected', route.dataset.id === id));
        fields.image.hidden = !tab.dataset.image;
        card.classList.toggle('has-image', Boolean(tab.dataset.image));
        if (tab.dataset.image) fields.image.src = tab.dataset.image;
        else fields.image.removeAttribute('src');
        fields.image.alt = `Bộ sưu tập hoa từ ${tab.dataset.country}`;
        ['country', 'flower', 'latin', 'region'].forEach(name => { fields[name].textContent = tab.dataset[name]; });
        fields.coordinate.textContent = tab.dataset.coord;
        fields.link.href = tab.dataset.url;
        card.setAttribute('aria-labelledby', tab.id);
        if (focus) tab.focus({ preventScroll: true });
        if (recenter && zoom > 1) requestAnimationFrame(center);
    }

    pins.forEach(pin => {
        pin.addEventListener('click', () => select(pin.dataset.id));
        pin.addEventListener('keydown', event => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault(); select(pin.dataset.id);
            }
        });
    });
    countries.forEach(country => country.addEventListener('click', () => select(country.dataset.origin)));
    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => select(tab.dataset.id, false, true));
        tab.addEventListener('keydown', event => {
            let next;
            if (event.key === 'ArrowRight') next = (index + 1) % tabs.length;
            if (event.key === 'ArrowLeft') next = (index - 1 + tabs.length) % tabs.length;
            if (event.key === 'Home') next = 0;
            if (event.key === 'End') next = tabs.length - 1;
            if (next === undefined) return;
            event.preventDefault(); select(tabs[next].dataset.id, true, true);
        });
    });
    root.querySelectorAll('[data-zoom]').forEach(button => button.addEventListener('click', () => {
        const action = button.dataset.zoom;
        setZoom(action === 'reset' ? 1 : zoom + (action === 'in' ? .5 : -.5), action !== 'reset');
    }));
    select(selected);
    setZoom(zoom);
    fields.image.addEventListener('error', () => {
        fields.image.hidden = true;
        card.classList.remove('has-image');
    });
})();
