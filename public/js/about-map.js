(() => {
    const atlas = document.getElementById('originStory');
    if (!atlas) return;

    const card = atlas.querySelector('#flowerCard');
    const tabs = [...atlas.querySelectorAll('.flower-tabs [data-region]')];
    const pins = [...atlas.querySelectorAll('.map-pin[data-region]')];
    const routes = [...atlas.querySelectorAll('.flight-route[data-region]')];
    const fields = {
        image: atlas.querySelector('#flowerImage'),
        index: atlas.querySelector('#flowerIndex'),
        country: atlas.querySelector('#flowerCountry'),
        flower: atlas.querySelector('#flowerName'),
        latin: atlas.querySelector('#flowerLatin'),
        region: atlas.querySelector('#flowerRegion'),
        coordinate: atlas.querySelector('#flowerCoordinate'),
    };

    function selectRegion(id, focusTab = false) {
        const tab = tabs.find((item) => item.dataset.region === id);
        if (!tab) return;

        tabs.forEach((item, index) => {
            const selected = item === tab;
            item.setAttribute('aria-selected', String(selected));
            item.tabIndex = selected ? 0 : -1;
            if (selected) fields.index.textContent = String(index + 1).padStart(2, '0');
        });
        pins.forEach((pin) => {
            const selected = pin.dataset.region === id;
            pin.classList.toggle('is-active', selected);
            pin.setAttribute('aria-pressed', String(selected));
        });
        routes.forEach((route) => route.classList.toggle('is-active', route.dataset.region === id));

        fields.image.src = tab.dataset.image;
        fields.image.alt = `${tab.dataset.flower} từ ${tab.dataset.country}`;
        fields.country.textContent = tab.dataset.country;
        fields.flower.textContent = tab.dataset.flower;
        fields.latin.textContent = tab.dataset.latin;
        fields.region.textContent = tab.dataset.growingRegion;
        fields.coordinate.textContent = tab.dataset.coordinate;

        card.classList.remove('is-changing');
        requestAnimationFrame(() => card.classList.add('is-changing'));
        if (focusTab) tab.focus();
    }

    pins.forEach((pin) => {
        pin.addEventListener('pointerenter', () => selectRegion(pin.dataset.region));
        pin.addEventListener('focus', () => selectRegion(pin.dataset.region));
        pin.addEventListener('click', () => selectRegion(pin.dataset.region));
        pin.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                selectRegion(pin.dataset.region);
            }
        });
    });

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => selectRegion(tab.dataset.region));
        tab.addEventListener('keydown', (event) => {
            if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') return;
            event.preventDefault();
            const direction = event.key === 'ArrowRight' ? 1 : -1;
            const next = (index + direction + tabs.length) % tabs.length;
            selectRegion(tabs[next].dataset.region, true);
        });
    });

    selectRegion(tabs[0]?.dataset.region || 'netherlands');
})();
