<div style="display:flex; align-items:center; flex-wrap:wrap; gap:10px; margin-top:8px;">
    <input id="postContentImages" type="file" accept=".jpg,.jpeg,.png,.gif,.webp" multiple hidden>
    <button id="postContentImagesButton" class="btn btn-secondary" type="button">{{ __('storefront.upload_content_images') }}</button>
    <small id="postContentImagesStatus">{{ __('storefront.upload_content_images_hint') }}</small>
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
                status.textContent = @json(__('storefront.uploading_image', ['current' => ':current', 'total' => ':total'])).replace(':current', index + 1).replace(':total', files.length);
                const body = new FormData();
                body.append('image', file);

                const response = await fetch(@json(localized_route('blog.content-image')), {
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
                    throw new Error(error ?? result.message ?? @json(__('storefront.upload_image_error')));
                }

                const alt = file.name.replace(/[\\[\]()]/g, '');
                const markdown = `\n\n![${alt}](${result.url})\n\n`;
                editor.setRangeText(markdown, cursor, cursor, 'end');
                cursor += markdown.length;
                inserted = true;
            }

            status.textContent = @json(__('storefront.images_added', ['count' => ':count'])).replace(':count', files.length);
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
