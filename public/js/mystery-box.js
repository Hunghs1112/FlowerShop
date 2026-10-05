(() => {
    const root = document.getElementById('mysteryBoxExperience');
    if (!root) return;

    const options = JSON.parse(root.dataset.options);
    const initial = JSON.parse(root.dataset.initial);
    const fields = [
        { id: 'color', object: 'Bảng màu', label: 'Tông màu hoa', help: 'Chọn tối đa 3 tông màu bạn muốn.', type: 'chips', options: options.colors, max: 3, required: true },
        { id: 'flower', object: 'Sách thực vật', label: 'Loài hoa', help: 'Những loài hoa bạn mong có trong hộp, nếu có.', type: 'chips', options: ['Mẫu đơn', 'Tulip', 'Mao lương', 'Hồng Ecuador', 'Protea', 'Lan hồ điệp', 'Cẩm chướng', 'Cúc Malaysia', 'Ly', 'Không có yêu cầu'], max: 4 },
        { id: 'style', object: 'Khung tranh', label: 'Phong cách', help: 'Bạn muốn hộp hoa mang cảm giác nào?', type: 'chips', options: options.styles, max: 1, required: true },
        { id: 'interest', object: 'Đĩa nhạc', label: 'Sở thích', help: 'Người nhận (hoặc bạn) yêu thích điều gì? LNT sẽ dựa vào đó để chọn hoa và chi tiết đi kèm.', type: 'chips', options: options.preferences, max: 4, required: true, extra: 'Kể thêm một chút (không bắt buộc)' },
        { id: 'budget', object: 'Heo đất', label: 'Ngân sách', help: 'Chọn mức ngân sách cho hộp hoa.', type: 'chips', options: options.budgets.map(item => ({ value: item.value, label: item.label })), max: 1, required: true },
        { id: 'surprise', object: 'Hộp quà nhỏ', label: 'Mức độ bất ngờ', help: 'Bạn muốn bất ngờ đến đâu?', type: 'chips', options: options.surprise_levels, max: 1, required: true },
        { id: 'note', object: 'Cuốn sổ', label: 'Lưu ý', help: 'Dị ứng phấn hoa, màu hay loài hoa muốn tránh, dịp tặng, lời nhắn kèm thiệp…', type: 'textarea' },
        { id: 'confirm', object: 'Chiếc chìa khoá', label: 'Xác nhận', help: 'Thông tin nhận hoa. Chiếc chìa khoá cuối cùng để niêm phong căn phòng.', type: 'contact', required: true },
    ];
    const data = {
        color: { sel: initial.colors || [] },
        flower: { sel: [] },
        style: { sel: initial.style ? [initial.style] : [] },
        interest: { sel: initial.preferences || [], extra: '' },
        budget: { value: initial.budget_range || '', sel: options.budgets.filter(item => item.value === initial.budget_range).map(item => item.label) },
        surprise: { sel: initial.surprise_level ? [initial.surprise_level] : [] },
        note: { text: initial.note || '' },
        confirm: { contact: { name: initial.name || '', phone: initial.phone || '', email: initial.email || '', address: '', date: '', agree: false } },
    };
    const found = new Set();
    const stage = document.getElementById('mysteryStage');
    const dialog = document.getElementById('mysteryDialog');
    const backdrop = document.getElementById('mysteryDialogBackdrop');
    const dialogFields = document.getElementById('mysteryDialogFields');
    const dialogError = document.getElementById('mysteryDialogError');
    const collection = document.getElementById('mysteryCollection');
    let activeField = null;
    let returnFocus = null;

    const icons = {
        color: '<svg viewBox="0 0 42 42"><path d="M8 26c-4-10 4-18 15-18 10 0 15 5 13 10-1 3-6 2-7 5s3 5-3 6c-7 2-15 0-18-3z" fill="#efe3d3"/><circle cx="16" cy="18" r="3" fill="#d7a3a0"/><circle cx="23" cy="14" r="3" fill="#c98e6a"/><circle cx="30" cy="17" r="3" fill="#9aa07a"/></svg>',
        flower: '<svg viewBox="0 0 42 42"><rect x="6" y="22" width="30" height="10" rx="2" fill="#7e8a52"/><rect x="8" y="13" width="26" height="10" rx="2" fill="#e6d3c6"/><circle cx="21" cy="18" r="4" fill="#d7a3a0"/></svg>',
        style: '<svg viewBox="0 0 42 42"><ellipse cx="21" cy="21" rx="12" ry="15" fill="#b28a6c"/><ellipse cx="21" cy="21" rx="8" ry="11" fill="#f1e2d4"/><circle cx="20" cy="20" r="4" fill="#c79a8f"/></svg>',
        interest: '<svg viewBox="0 0 42 42"><circle cx="21" cy="21" r="14" fill="#2e2420"/><circle cx="21" cy="21" r="9" fill="none" stroke="#4a3a32"/><circle cx="21" cy="21" r="4" fill="#c78e66"/></svg>',
        budget: '<svg viewBox="0 0 42 42"><ellipse cx="20" cy="23" rx="13" ry="9" fill="#e3afa8"/><circle cx="32" cy="21" r="4" fill="#e3afa8"/><path d="M16 14h8" stroke="#8f5b47" stroke-width="2"/></svg>',
        surprise: '<svg viewBox="0 0 42 42"><rect x="10" y="17" width="22" height="17" rx="2" fill="#c79a8f"/><rect x="8" y="13" width="26" height="6" rx="2" fill="#b98c7c"/><path d="M21 13c-6-7-12-5-10-1 1 3 7 2 10 1s9-8 10-1c1 3-5 3-10 1z" fill="#f3e2d2"/></svg>',
        note: '<svg viewBox="0 0 42 42"><rect x="9" y="10" width="22" height="24" rx="2" fill="#a86e4e"/><rect x="12" y="12" width="18" height="20" fill="#fbf4ec"/><path d="M14 18h14m-14 4h14m-14 4h10" stroke="#c9b3a0"/></svg>',
        confirm: '<svg viewBox="0 0 42 42"><circle cx="13" cy="21" r="6" fill="none" stroke="#d9a85e" stroke-width="4"/><rect x="18" y="19" width="18" height="4" fill="#d9a85e"/></svg>',
    };
    const colorSwatches = { 'Hồng': '#e7aeb4', 'Hồng phấn': '#f2c4c4', 'Trắng': '#f6efe4', 'Trắng kem': '#f6efe4', 'Kem': '#e6d3c6', 'Đỏ': '#9e2b33', 'Đỏ nhung': '#9e2b33', 'Cam đào': '#f2a97e', 'Tím pastel': '#c9b3da', 'Vàng nắng': '#efcb5e', 'Xanh': '#9aaeb0', 'Xanh lá': '#9aa07a', 'Pastel': 'linear-gradient(135deg,#f2c4c4,#c9b3da,#f2a97e)' };
    const esc = value => String(value ?? '').replace(/[&<>"']/g, char => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[char]));

    function selected(id) { return data[id]?.sel || []; }
    function chosen(f) { return f.id === 'note' ? !!data.note.text : f.id === 'confirm' ? !!(data.confirm.contact.name && data.confirm.contact.phone && data.confirm.contact.address && data.confirm.contact.date && data.confirm.contact.agree) : selected(f.id).length > 0; }
    function complete() { return fields.filter(f => f.required).every(f => chosen(f)); }

    function renderCollection() {
        collection.innerHTML = fields.map((field, index) => `<button class="mystery-room__slot${found.has(field.id) ? ' is-found' : ''}${chosen(field) ? ' is-done' : ''}" type="button" data-open-item="${field.id}" aria-label="${found.has(field.id) ? 'Đã tìm thấy' : 'Chưa tìm thấy'}: ${esc(field.label)}">${icons[field.id]}<b>${index + 1}. ${esc(field.object)}</b><small>${chosen(field) ? 'Đã cất giữ' : found.has(field.id) ? 'Đã tìm thấy' : 'Chưa tìm thấy'}</small></button>`).join('');
        document.getElementById('mysteryStatus').textContent = complete() ? 'Bạn đã tìm thấy mọi điều cần thiết. Căn phòng đã sẵn sàng để niêm phong.' : `Đã tìm thấy ${found.size} / ${fields.length} món đồ · Hoàn tất các lựa chọn có dấu * để gửi hộp hoa.`;
        document.getElementById('mysteryProgress').textContent = `${found.size} / ${fields.length} MÓN ĐỒ`;
        document.getElementById('mysterySuccess').hidden = !complete();
        document.getElementById('mysteryBoxMark').setAttribute('opacity', complete() ? '1' : '0');
    }

    function chipMarkup(field, value) {
        const label = typeof value === 'string' ? value : value.label;
        const isSelected = selected(field.id).includes(label);
        const swatch = colorSwatches[label];
        const description = field.id === 'budget' ? value.value : '';
        return `<button class="mystery-room__chip${field.id === 'style' || field.id === 'surprise' || field.id === 'budget' ? ' is-wide' : ''}" type="button" aria-pressed="${isSelected}" data-choice="${esc(label)}"${description ? ` data-value="${esc(description)}"` : ''}>${swatch ? `<i style="background:${swatch}"></i>` : ''}<span>${esc(label)}${description ? `<small>${esc(description)}</small>` : ''}</span></button>`;
    }

    function showField(field, trigger) {
        activeField = field;
        returnFocus = trigger;
        const stored = data[field.id] || {};
        document.getElementById('mysteryDialogKicker').textContent = `BẠN ĐÃ TÌM THẤY · ${field.object.toUpperCase()}`;
        document.getElementById('mysteryDialogTitle').textContent = `${field.label}${field.required ? ' *' : ''}`;
        document.getElementById('mysteryDialogHelp').textContent = field.help || '';
        document.getElementById('mysteryDialogSave').textContent = field.id === 'confirm' ? 'Khoá căn phòng' : 'Cất giữ';
        dialogError.textContent = '';

        if (field.type === 'chips') {
            dialogFields.innerHTML = `<div class="mystery-room__chips" role="group" aria-label="${esc(field.label)}">${field.options.map(value => chipMarkup(field, value)).join('')}</div>${field.extra ? `<label class="mystery-room__extra">${esc(field.extra)}<textarea id="mysteryInterestExtra" maxlength="200">${esc(stored.extra)}</textarea></label>` : ''}`;
            dialogFields.querySelectorAll('[data-choice]').forEach(button => button.addEventListener('click', () => {
                const label = button.dataset.choice;
                const current = selected(field.id);
                const index = current.indexOf(label);
                if (index >= 0) current.splice(index, 1);
                else if (field.max === 1) data[field.id].sel = [label];
                else if (current.length >= field.max) { dialogError.textContent = `Bạn có thể chọn tối đa ${field.max} mục.`; return; }
                else current.push(label);
                if (field.id === 'budget') data.budget.value = button.dataset.value;
                showField(field, null);
            }));
            dialogFields.querySelector('#mysteryInterestExtra')?.addEventListener('input', event => { data.interest.extra = event.target.value; });
        } else if (field.type === 'textarea') {
            dialogFields.innerHTML = `<textarea id="mysteryNote" maxlength="400" aria-label="${esc(field.label)}" placeholder="Dị ứng phấn hoa, màu hay loài hoa muốn tránh, dịp tặng, lời nhắn kèm thiệp…">${esc(stored.text)}</textarea>`;
        } else {
            const contact = stored.contact;
            const budget = selected('budget')[0] || '—';
            const chosenDetails = [
                ['Phong cách', selected('style').join(', ')], ['Tông màu', selected('color').join(', ')],
                ['Loài hoa', selected('flower').join(', ')], ['Sở thích', selected('interest').join(', ')],
                ['Ngân sách', budget], ['Bất ngờ', selected('surprise').join(', ')],
            ].filter(([, value]) => value).map(([label, value]) => `<div><b>${label}:</b> ${esc(value)}</div>`).join('');
            dialogFields.innerHTML = `<div class="mystery-room__summary">${chosenDetails}</div><div class="mystery-room__contact-grid">
                <label>Họ và tên *<input id="mbName" autocomplete="name" maxlength="255" value="${esc(contact.name)}"></label>
                <label>Số điện thoại / Zalo *<input id="mbPhone" type="tel" autocomplete="tel" maxlength="20" pattern="[0-9+\\s-]+" value="${esc(contact.phone)}"></label>
                <label>Email (không bắt buộc)<input id="mbEmail" type="email" autocomplete="email" value="${esc(contact.email)}"></label>
                <label>Địa chỉ nhận hoa *<input id="mbAddress" autocomplete="street-address" maxlength="300" value="${esc(contact.address)}"></label>
                <label>Ngày nhận mong muốn *<input id="mbDate" type="date" min="${new Date().toLocaleDateString('en-CA')}" value="${esc(contact.date)}"></label>
            </div><label class="mystery-room__agreement"><input id="mbAgree" type="checkbox" ${contact.agree ? 'checked' : ''}> <span>Tôi đã đọc <a href="${root.dataset.returnPolicy}" target="_blank" rel="noopener">chính sách đổi trả</a> và đồng ý để LNT liên hệ xác nhận yêu cầu.</span></label>`;
        }
        backdrop.hidden = false;
        dialog.hidden = false;
        dialog.querySelector('.mystery-room__chip, textarea, input')?.focus();
        stage.classList.add('is-dialog-open');
    }

    function closeDialog() {
        dialog.hidden = true;
        backdrop.hidden = true;
        stage.classList.remove('is-dialog-open');
        returnFocus?.focus?.();
    }

    function saveField() {
        const field = activeField;
        if (!field) return;
        if (field.type === 'textarea') data.note.text = dialogFields.querySelector('#mysteryNote').value.trim();
        if (field.id === 'interest') data.interest.extra = dialogFields.querySelector('#mysteryInterestExtra')?.value.trim() || '';
        if (field.type === 'contact') {
            const contact = data.confirm.contact;
            contact.name = dialogFields.querySelector('#mbName').value.trim();
            contact.phone = dialogFields.querySelector('#mbPhone').value.trim();
            contact.email = dialogFields.querySelector('#mbEmail').value.trim();
            contact.address = dialogFields.querySelector('#mbAddress').value.trim();
            contact.date = dialogFields.querySelector('#mbDate').value;
            contact.agree = dialogFields.querySelector('#mbAgree').checked;
            if (!/^[0-9+\-\s]+$/.test(contact.phone)) {
                dialogError.textContent = 'Số điện thoại chỉ gồm chữ số, dấu +, dấu gạch ngang hoặc khoảng trắng.';
                return;
            }
            if (contact.email && !dialogFields.querySelector('#mbEmail').checkValidity()) {
                dialogError.textContent = 'Vui lòng kiểm tra lại địa chỉ email.';
                return;
            }
        }
        if (field.required && !chosen(field)) {
            dialogError.textContent = field.id === 'confirm' ? 'Vui lòng điền tên, số điện thoại, địa chỉ, ngày nhận và xác nhận chính sách.' : 'Vui lòng chọn ít nhất một mục trước khi cất giữ.';
            return;
        }
        found.add(field.id);
        document.querySelector(`.mystery-room__object[data-item="${field.id}"]`)?.classList.add('is-found');
        closeDialog();
        renderCollection();
    }

    fields.forEach(field => {
        const object = document.querySelector(`.mystery-room__object[data-item="${field.id}"]`);
        object.addEventListener('click', () => { if (!stage.classList.contains('is-dialog-open')) showField(field, object); });
        object.addEventListener('keydown', event => { if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); object.click(); } });
        const restored = field.id === 'note' ? !!initial.note : field.id === 'confirm' ? false : field.id === 'budget' ? !!initial.budget_range : field.id === 'surprise' ? !!initial.surprise_level : field.id === 'style' ? !!initial.style : ['color', 'interest'].includes(field.id) && (initial.colors?.length || initial.preferences?.length);
        if (restored) { found.add(field.id); object.classList.add('is-found'); }
    });

    collection.addEventListener('click', event => {
        const button = event.target.closest('[data-open-item]');
        if (button) showField(fields.find(field => field.id === button.dataset.openItem), button);
    });
    document.getElementById('mysteryHint').addEventListener('click', () => {
        const remaining = fields.filter(field => !found.has(field.id));
        if (!remaining.length) return;
        const next = remaining[Math.floor(Math.random() * remaining.length)];
        const object = document.querySelector(`.mystery-room__object[data-item="${next.id}"]`);
        object.classList.remove('is-hinted');
        void object.getBoundingClientRect();
        object.classList.add('is-hinted');
        document.getElementById('mysteryStatus').textContent = `Gợi ý: ${next.object} đang chờ bạn trong căn phòng.`;
    });
    document.getElementById('mysteryReveal').addEventListener('click', () => {
        fields.forEach(field => {
            found.add(field.id);
            document.querySelector(`.mystery-room__object[data-item="${field.id}"]`).classList.add('is-found');
        });
        renderCollection();
    });
    document.getElementById('mysteryDialogSave').addEventListener('click', saveField);
    document.getElementById('mysteryDialogClose').addEventListener('click', closeDialog);
    backdrop.addEventListener('click', closeDialog);
    document.addEventListener('keydown', event => { if (event.key === 'Escape' && !dialog.hidden) closeDialog(); });
    dialog.addEventListener('keydown', event => {
        if (event.key !== 'Tab') return;
        const focusable = [...dialog.querySelectorAll('button:not([disabled]),input:not([disabled]),textarea:not([disabled]),a[href]')];
        if (event.shiftKey && document.activeElement === focusable[0]) { event.preventDefault(); focusable.at(-1).focus(); }
        else if (!event.shiftKey && document.activeElement === focusable.at(-1)) { event.preventDefault(); focusable[0].focus(); }
    });

    document.getElementById('mysterySubmit').addEventListener('click', () => {
        if (!complete()) return;
        const form = document.getElementById('mysteryBoxForm');
        const contact = data.confirm.contact;
        const budget = options.budgets.find(item => item.value === data.budget.value);
        form.elements.style.value = selected('style')[0];
        form.elements.budget_range.value = budget.value;
        form.elements.surprise_level.value = selected('surprise')[0];
        form.elements.name.value = contact.name;
        form.elements.phone.value = contact.phone;
        form.elements.email.value = contact.email;
        document.getElementById('mysteryColors').innerHTML = selected('color').map(value => `<input type="hidden" name="colors[]" value="${esc(value)}">`).join('');
        document.getElementById('mysteryPreferences').innerHTML = selected('interest').map(value => `<input type="hidden" name="preferences[]" value="${esc(value)}">`).join('');
        form.elements.note.value = [
            selected('flower').length ? `Loài hoa mong muốn: ${selected('flower').join(', ')}` : '',
            data.interest.extra ? `Sở thích thêm: ${data.interest.extra}` : '',
            data.note.text ? `Lưu ý: ${data.note.text}` : '',
            `Địa chỉ nhận hoa: ${contact.address}`,
            `Ngày nhận mong muốn: ${contact.date}`,
        ].filter(Boolean).join('\n');
        form.requestSubmit();
    });

    renderCollection();
})();
