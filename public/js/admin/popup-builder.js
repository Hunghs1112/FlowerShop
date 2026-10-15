(function () {
    'use strict';

    var form = document.getElementById('popup-form');
    var preview = document.getElementById('popup-preview');
    var status = document.getElementById('popup-status');
    var bullets = document.getElementById('popup-bullets');
    var bulletInputs = document.getElementById('popup-bullet-inputs');
    var cta2 = document.getElementById('popup-cta2');
    var customCta2 = document.getElementById('popup-custom-cta2');

    if (!form || !preview || !window.LNTPopup) return;

    function field(name) {
        var element = form.elements[name];
        return element ? element.value : '';
    }

    function campaign() {
        return {
            id: field('id_key'),
            active: form.elements.is_active.checked,
            start: field('start_date'),
            end: field('end_date'),
            theme: field('theme'),
            eyebrow: field('eyebrow'),
            route: field('route'),
            title: field('title'),
            text: field('text'),
            bullets: bullets.value.split('\n').map(function (item) { return item.trim(); }).filter(Boolean),
            countdown: field('countdown'),
            countdownLabel: field('countdown_label'),
            image: field('image'),
            imageAlt: field('image_alt'),
            stamp: field('stamp'),
            stampSub: field('stamp_sub'),
            ctaLabel: field('cta_label'),
            ctaLink: field('cta_link'),
            cta2: field('cta2'),
            cta2Label: field('cta2_label'),
            cta2Link: field('cta2_link'),
            note: field('note'),
            teaser: field('teaser')
        };
    }

    function popupConfig() {
        return {
            delay: Number(field('popup_delay')) || 0,
            frequency: field('popup_frequency'),
            zalo: field('popup_zalo')
        };
    }

    function isActiveNow(item) {
        if (!item.active) return false;
        var now = new Date(new Date().toLocaleString('en-US', { timeZone: 'Asia/Ho_Chi_Minh' }));
        var start = item.start ? new Date(item.start + 'T00:00:00') : null;
        var end = item.end ? new Date(item.end + 'T23:59:59') : null;
        return (!start || now >= start) && (!end || now <= end);
    }

    function syncBullets(item) {
        bulletInputs.innerHTML = '';
        item.bullets.forEach(function (text) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'bullets[]';
            input.value = text;
            bulletInputs.appendChild(input);
        });
    }

    function render() {
        var item = campaign();
        var oldPreview = preview.firstElementChild;
        if (oldPreview && oldPreview._timer) clearInterval(oldPreview._timer);
        preview.innerHTML = '';
        preview.appendChild(window.LNTPopup.build(item, popupConfig()));
        syncBullets(item);

        if (!item.active) {
            status.textContent = '○ Đang tắt';
            status.className = 'off';
        } else if (isActiveNow(item)) {
            status.textContent = '● Đang trong thời gian hiển thị';
            status.className = 'on';
        } else {
            status.textContent = '○ Ngoài thời gian hiển thị (' + (item.start || '…') + ' → ' + (item.end || '…') + ')';
            status.className = 'off';
        }

        customCta2.hidden = item.cta2 !== 'custom';
    }

    form.addEventListener('input', render);
    form.addEventListener('change', render);
    form.addEventListener('submit', function () { syncBullets(campaign()); });
    document.getElementById('preview-popup-button').addEventListener('click', function () {
        window.LNTPopup.open(campaign(), popupConfig());
    });

    render();
}());
