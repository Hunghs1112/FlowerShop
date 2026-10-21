<div style="display:flex; align-items:center; flex-wrap:wrap; gap:10px; margin-top:8px;">
    <input id="postContentImages" type="file" accept=".jpg,.jpeg,.png,.gif,.webp" multiple hidden>
    <button id="postContentImagesButton" class="btn btn-secondary" type="button">Thêm ảnh vào nội dung</button>
    <small id="postContentImagesStatus">Có thể chọn nhiều ảnh và tải thêm nhiều lần.</small>
</div>

@once
@push('scripts')
<script>
(() => {
    const input = document.getElementById('postContentImages');
    const button = document.getElementById('postContentImagesButton');
    const status = document.getElementById('postContentImagesStatus');
    const editor = document.getElementById('contentEditor');
    if (!input || !button || !status || !editor) return;

    button.addEventListener('click', () => input.click());
    input.addEventListener('change', async () => {
        const files = [...input.files];
        if (!files.length) return;

        let cursor = editor.selectionStart ?? editor.value.length;
        let inserted = false;
        button.disabled = true;

        try {
            for (const [index, file] of files.entries()) {
                status.textContent = `Đang tải ảnh ${index + 1}/${files.length}...`;
                const body = new FormData();
                body.append('image', file);

                const response = await fetch(@json(route('blog.content-image')), {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body,
                });
                const result = await response.json();

                if (!response.ok) {
                    const error = Object.values(result.errors ?? {}).flat()[0];
                    throw new Error(error ?? result.message ?? 'Không thể tải ảnh.');
                }

                const alt = file.name.replace(/[\\[\]()]/g, '');
                const markdown = `\n\n![${alt}](${result.url})\n\n`;
                editor.setRangeText(markdown, cursor, cursor, 'end');
                cursor += markdown.length;
                inserted = true;
            }

            status.textContent = `Đã thêm ${files.length} ảnh vào nội dung.`;
        } catch (error) {
            status.textContent = error.message;
        } finally {
            button.disabled = false;
            input.value = '';
            if (inserted) editor.dispatchEvent(new Event('input', { bubbles: true }));
            editor.focus();
        }
    });
})();
</script>
@endpush
@endonce
