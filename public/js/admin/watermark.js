(function () {
    'use strict';

    const root = document.getElementById('watermarkTool');
    if (!root) return;

    const find = id => document.getElementById(id);
    const defaults = { variant: 'color', position: 'br', size: 22, margin: 4, opacity: 100, background: 'glow', glow: 70, format: 'jpeg', quality: 92 };
    const positions = ['tl', 'tc', 'tr', 'ml', 'mc', 'mr', 'bl', 'bc', 'br'];
    const presets = {
        sharp: { variant: 'color', opacity: 100, background: 'glow', glow: 70, position: 'br', size: 22 },
        transparent: { variant: 'white', opacity: 45, background: 'shadow', glow: 45, position: 'br', size: 28 },
        'color-transparent': { variant: 'color', opacity: 55, background: 'none', position: 'br', size: 28 },
        centered: { variant: 'white', opacity: 32, background: 'none', position: 'mc', size: 60 }
    };
    let options = { ...defaults };
    let files = [];
    let selected = 0;
    let logo = new Image();
    let tintedLogos = {};

    try {
        options = { ...options, ...JSON.parse(localStorage.getItem('lnt-watermark') || 'null') };
    } catch (_) {}

    const save = () => {
        try { localStorage.setItem('lnt-watermark', JSON.stringify(options)); } catch (_) {}
    };

    function tinted(variant) {
        if (variant === 'color') return logo;
        if (tintedLogos[variant]) return tintedLogos[variant];
        const canvas = document.createElement('canvas');
        canvas.width = logo.naturalWidth;
        canvas.height = logo.naturalHeight;
        const context = canvas.getContext('2d');
        context.drawImage(logo, 0, 0);
        context.globalCompositeOperation = 'source-in';
        context.fillStyle = { white: '#ffffff', brown: '#4a3826', cream: '#f4e8dc' }[variant];
        context.fillRect(0, 0, canvas.width, canvas.height);
        tintedLogos[variant] = canvas;
        return canvas;
    }

    function render(image, settings) {
        const width = image.naturalWidth;
        const height = image.naturalHeight;
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        canvas.width = width;
        canvas.height = height;
        context.drawImage(image, 0, 0);
        if (!logo.naturalWidth) return canvas;

        const base = Math.min(width, height);
        const logoWidth = base * settings.size / 100;
        const logoHeight = logoWidth * logo.naturalHeight / logo.naturalWidth;
        const margin = base * settings.margin / 100;
        const column = settings.position[1];
        const row = settings.position[0];
        const left = column === 'l' ? margin : column === 'c' ? (width - logoWidth) / 2 : width - logoWidth - margin;
        const top = row === 't' ? margin : row === 'm' ? (height - logoHeight) / 2 : height - logoHeight - margin;
        const centerX = left + logoWidth / 2;
        const centerY = top + logoHeight / 2;
        const strength = settings.glow / 100;

        if (settings.background === 'glow') {
            const radiusX = logoWidth * .95;
            const radiusY = logoHeight * 1.15;
            const x = Math.max(0, centerX - radiusX);
            const y = Math.max(0, centerY - radiusY);
            const glowWidth = Math.min(width, centerX + radiusX) - x;
            const glowHeight = Math.min(height, centerY + radiusY) - y;
            const glow = document.createElement('canvas');
            glow.width = Math.ceil(glowWidth);
            glow.height = Math.ceil(glowHeight);
            const glowContext = glow.getContext('2d');
            if ('filter' in glowContext) glowContext.filter = `blur(${Math.max(2, base * .012 * strength)}px)`;
            glowContext.drawImage(canvas, x, y, glowWidth, glowHeight, 0, 0, glowWidth, glowHeight);
            glowContext.filter = 'none';
            glowContext.globalCompositeOperation = 'destination-in';
            glowContext.setTransform(radiusX, 0, 0, radiusY, centerX - x, centerY - y);
            const mask = glowContext.createRadialGradient(0, 0, 0, 0, 0, 1);
            mask.addColorStop(0, 'rgba(0,0,0,1)');
            mask.addColorStop(.55, 'rgba(0,0,0,.75)');
            mask.addColorStop(1, 'rgba(0,0,0,0)');
            glowContext.fillStyle = mask;
            glowContext.fillRect(-1, -1, 2, 2);
            context.drawImage(glow, x, y);

            const isLight = settings.variant === 'white' || settings.variant === 'cream';
            context.save();
            context.translate(centerX, centerY);
            context.scale(radiusX, radiusY);
            const halo = context.createRadialGradient(0, 0, 0, 0, 0, 1);
            const tone = isLight ? '30,22,18' : '250,244,236';
            halo.addColorStop(0, `rgba(${tone},${.82 * strength})`);
            halo.addColorStop(.6, `rgba(${tone},${.45 * strength})`);
            halo.addColorStop(1, `rgba(${tone},0)`);
            context.fillStyle = halo;
            context.beginPath();
            context.arc(0, 0, 1, 0, Math.PI * 2);
            context.fill();
            context.restore();
        }

        context.save();
        context.globalAlpha = settings.opacity / 100;
        if (settings.background === 'shadow') {
            context.shadowColor = `rgba(25,16,12,${.25 + .45 * strength})`;
            context.shadowBlur = logoWidth * .06;
            context.shadowOffsetY = logoWidth * .01;
        }
        context.drawImage(tinted(settings.variant), left, top, logoWidth, logoHeight);
        context.restore();
        return canvas;
    }

    function redraw() {
        const stage = find('watermarkStage');
        if (!files.length) {
            stage.innerHTML = '<p>Tải ảnh lên để xem logo được gắn tự động.</p>';
            find('watermarkInfo').textContent = '';
            find('watermarkDownloadOne').disabled = true;
            find('watermarkDownloadAll').disabled = true;
            return;
        }

        const file = files[selected];
        const canvas = render(file.image, options);
        canvas.setAttribute('role', 'img');
        canvas.setAttribute('aria-label', `Xem trước: ${file.name}`);
        stage.replaceChildren(canvas);
        find('watermarkInfo').textContent = `${selected + 1}/${files.length} · ${file.name} · ${file.image.naturalWidth}×${file.image.naturalHeight}`;
        find('watermarkDownloadOne').disabled = false;
        find('watermarkDownloadAll').disabled = files.length < 2;
        find('watermarkDownloadAll').textContent = files.length > 1 ? `Tải tất cả (${files.length})` : 'Tải tất cả';
    }

    function drawThumbnails() {
        const list = find('watermarkThumbnails');
        list.replaceChildren();
        files.forEach((file, index) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.setAttribute('aria-label', `Ảnh ${index + 1}: ${file.name}`);
            button.setAttribute('aria-current', index === selected ? 'true' : 'false');
            const image = document.createElement('img');
            image.src = file.url;
            image.alt = '';
            const remove = document.createElement('span');
            remove.className = 'watermark-remove';
            remove.setAttribute('aria-hidden', 'true');
            remove.textContent = '×';
            button.append(image, remove);
            button.addEventListener('click', event => {
                if (event.target === remove) {
                    URL.revokeObjectURL(file.url);
                    files.splice(index, 1);
                    selected = Math.max(0, Math.min(selected, files.length - 1));
                } else {
                    selected = index;
                }
                drawThumbnails();
                redraw();
            });
            list.appendChild(button);
        });
    }

    function addFiles(fileList) {
        const images = [...fileList].filter(file => file.type.startsWith('image/'));
        let remaining = images.length;
        if (!remaining) return;
        images.forEach(file => {
            const url = URL.createObjectURL(file);
            const image = new Image();
            image.onload = () => {
                files.push({ name: file.name, url, image });
                if (--remaining === 0) {
                    selected = files.length - 1;
                    drawThumbnails();
                    redraw();
                }
            };
            image.onerror = () => {
                URL.revokeObjectURL(url);
                if (--remaining === 0) {
                    drawThumbnails();
                    redraw();
                }
            };
            image.src = url;
        });
    }

    function sync() {
        root.querySelectorAll('#watermarkVariant button').forEach(button => button.setAttribute('aria-pressed', button.dataset.value === options.variant ? 'true' : 'false'));
        root.querySelectorAll('#watermarkBackground button').forEach(button => button.setAttribute('aria-pressed', button.dataset.value === options.background ? 'true' : 'false'));
        root.querySelectorAll('#watermarkPosition button').forEach(button => button.setAttribute('aria-pressed', button.dataset.position === options.position ? 'true' : 'false'));
        [['Size', 'size'], ['Margin', 'margin'], ['Opacity', 'opacity'], ['Glow', 'glow'], ['Quality', 'quality']].forEach(([id, key]) => {
            find(`watermark${id}`).value = options[key];
            find(`watermark${id}Output`).textContent = `${options[key]}%`;
        });
        find('watermarkFormat').value = options.format;
        find('watermarkGlow').disabled = options.background === 'none';
        find('watermarkQuality').disabled = options.format !== 'jpeg';
    }

    function setOption(key, value) {
        options[key] = value;
        save();
        sync();
        redraw();
    }

    const drop = find('watermarkDrop');
    find('watermarkFiles').addEventListener('change', event => {
        addFiles(event.target.files);
        event.target.value = '';
    });
    ['dragenter', 'dragover'].forEach(type => drop.addEventListener(type, event => {
        event.preventDefault();
        drop.classList.add('is-over');
    }));
    ['dragleave', 'drop'].forEach(type => drop.addEventListener(type, event => {
        event.preventDefault();
        drop.classList.remove('is-over');
    }));
    drop.addEventListener('drop', event => addFiles(event.dataTransfer.files));

    find('watermarkLogoFile').addEventListener('change', event => {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = () => {
            logo = new Image();
            logo.onload = () => { tintedLogos = {}; redraw(); };
            logo.src = reader.result;
        };
        reader.readAsDataURL(file);
    });

    find('watermarkPosition').innerHTML = positions.map(position => {
        const vertical = { t: 'Trên', m: 'Giữa', b: 'Dưới' }[position[0]];
        const horizontal = { l: 'trái', c: 'giữa', r: 'phải' }[position[1]];
        return `<button type="button" data-position="${position}" aria-label="${vertical} ${horizontal}"></button>`;
    }).join('');

    find('watermarkVariant').addEventListener('click', event => {
        const button = event.target.closest('button');
        if (button) setOption('variant', button.dataset.value);
    });
    find('watermarkBackground').addEventListener('click', event => {
        const button = event.target.closest('button');
        if (button) setOption('background', button.dataset.value);
    });
    find('watermarkPosition').addEventListener('click', event => {
        const button = event.target.closest('button');
        if (button) setOption('position', button.dataset.position);
    });
    [['Size', 'size'], ['Margin', 'margin'], ['Opacity', 'opacity'], ['Glow', 'glow'], ['Quality', 'quality']].forEach(([id, key]) => {
        find(`watermark${id}`).addEventListener('input', event => setOption(key, Number(event.target.value)));
    });
    find('watermarkFormat').addEventListener('change', event => setOption('format', event.target.value));
    find('watermarkPreset').addEventListener('click', event => {
        const button = event.target.closest('button');
        if (!button) return;
        Object.assign(options, presets[button.dataset.key]);
        save();
        sync();
        redraw();
        root.querySelectorAll('#watermarkPreset button').forEach(item => item.setAttribute('aria-pressed', item === button ? 'true' : 'false'));
    });

    const outputName = name => `${name.replace(/\.[^.]+$/, '')}-lnt.${options.format === 'png' ? 'png' : 'jpg'}`;
    const toBlob = canvas => new Promise(resolve => canvas.toBlob(resolve, `image/${options.format}`, options.quality / 100));
    function download(blob, name) {
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = name;
        document.body.appendChild(link);
        link.click();
        link.remove();
        setTimeout(() => URL.revokeObjectURL(link.href), 4000);
    }

    find('watermarkDownloadOne').addEventListener('click', async () => {
        const file = files[selected];
        download(await toBlob(render(file.image, options)), outputName(file.name));
    });
    find('watermarkDownloadAll').addEventListener('click', async () => {
        const button = find('watermarkDownloadAll');
        const progress = find('watermarkProgress');
        const bar = progress.firstElementChild;
        button.disabled = true;
        progress.style.display = 'block';
        try {
            if (window.JSZip) {
                const zip = new JSZip();
                for (let index = 0; index < files.length; index++) {
                    zip.file(outputName(files[index].name), await toBlob(render(files[index].image, options)));
                    bar.style.width = `${(index + 1) / files.length * 100}%`;
                }
                download(await zip.generateAsync({ type: 'blob' }), 'anh-gan-logo-lnt.zip');
            } else {
                for (let index = 0; index < files.length; index++) {
                    download(await toBlob(render(files[index].image, options)), outputName(files[index].name));
                    bar.style.width = `${(index + 1) / files.length * 100}%`;
                    await new Promise(resolve => setTimeout(resolve, 400));
                }
            }
        } finally {
            button.disabled = false;
            setTimeout(() => { progress.style.display = 'none'; bar.style.width = '0'; }, 800);
        }
    });

    console.assert(positions.length === 9 && Object.keys(presets).length === 4, 'Watermark controls are incomplete');
    logo.onload = () => { tintedLogos = {}; redraw(); };
    logo.src = root.dataset.logoSrc;
    sync();
    redraw();
})();
