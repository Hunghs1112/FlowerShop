(() => {
    const root = document.getElementById('aboutAtlas');
    if (!root) return;
    const tabs = [...root.querySelectorAll('#aboutChips [data-id]')];
    const pins = [...root.querySelectorAll('.pin[data-id]')];
    const arcs = [...root.querySelectorAll('.arc[data-id]')];
    const fields = {
        image: root.querySelector('#cardImage'), country: root.querySelector('#cardCountry'),
        flower: root.querySelector('#cardFlower'), latin: root.querySelector('#cardLatin'),
        region: root.querySelector('#cardRegion'), link: root.querySelector('#cardLink'),
    };
    function select(id, focus = false) {
        const tab = tabs.find((item) => item.dataset.id === id);
        if (!tab) return;
        tabs.forEach((item) => item.setAttribute('aria-selected', String(item === tab)));
        pins.forEach((pin) => {
            const active = pin.dataset.id === id;
            pin.classList.toggle('on', active);
            pin.setAttribute('aria-pressed', String(active));
        });
        arcs.forEach((arc) => arc.classList.toggle('on', arc.dataset.id === id));
        fields.image.src = tab.dataset.image;
        fields.image.alt = `${tab.dataset.flower} từ ${tab.dataset.country}`;
        fields.country.textContent = tab.dataset.country;
        fields.flower.textContent = tab.dataset.flower;
        fields.latin.textContent = tab.dataset.latin;
        fields.region.textContent = `${tab.dataset.region} · ${tab.dataset.coord}`;
        fields.link.href = tab.dataset.url;
        const card = root.querySelector('#aboutCard');
        card.classList.remove('swap'); void card.offsetWidth; card.classList.add('swap');
        if (focus) tab.focus();
    }
    pins.forEach((pin) => {
        ['pointerenter', 'focus', 'click'].forEach((event) => pin.addEventListener(event, () => select(pin.dataset.id)));
        pin.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); select(pin.dataset.id); }
        });
    });
    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => select(tab.dataset.id));
        tab.addEventListener('keydown', (event) => {
            if (!['ArrowLeft', 'ArrowRight'].includes(event.key)) return;
            event.preventDefault();
            select(tabs[(index + (event.key === 'ArrowRight' ? 1 : -1) + tabs.length) % tabs.length].dataset.id, true);
        });
    });
    select(tabs[0]?.dataset.id);
})();
