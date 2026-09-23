<div style="display: grid; grid-template-columns: 1fr 320px; gap: 24px;">
    {{-- Main Content --}}
    <div style="display: flex; flex-direction: column; gap: 24px;">
        {{-- Basic Info --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    Thông Tin Trang
                </h2>
            </div>
            <div class="admin-card-body">
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Tiêu Đề <span style="color: var(--admin-error);">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $page->title ?? '') }}" 
                               id="titleInput"
                               class="auto-save-input"
                               data-entity="pages"
                               data-id="{{ $page->id }}"
                               style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; transition: all 0.2s;" 
                               required>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Slug <span style="color: var(--admin-error);">*</span></label>
                        <input type="text" name="slug" value="{{ old('slug', $page->slug ?? '') }}" 
                               id="slugInput"
                               class="auto-save-input"
                               data-entity="pages"
                               data-id="{{ $page->id }}"
                               style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; font-family: var(--admin-font-mono);">
                        <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Ví dụ: chinh-sach-bao-mat, dieu-khoan-dich-vu</small>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Nội Dung <span style="color: var(--admin-error);">*</span></label>
                        <textarea name="content" rows="15" 
                                  id="contentEditor"
                                  class="auto-save-input"
                                  data-entity="pages"
                                  data-id="{{ $page->id }}"
                                  style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical; font-family: inherit; line-height: 1.6;" 
                                  required>{{ old('content', $page->content ?? '') }}</textarea>
                        <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Ctrl+Enter để lưu ngay</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div style="display: flex; flex-direction: column; gap: 24px;">
        {{-- Status --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    Trạng Thái
                </h2>
            </div>
            <div class="admin-card-body">
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" 
                               {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }}
                               class="auto-save-checkbox"
                               data-entity="pages"
                               data-id="{{ $page->id }}"
                               style="width: 20px; height: 20px; accent-color: var(--admin-accent);">
                        <span style="font-size: 14px; font-weight: 500;">Kích hoạt</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- SEO --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    SEO
                </h2>
            </div>
            <div class="admin-card-body">
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Tiêu Đề Meta</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title ?? '') }}"
                               class="auto-save-input"
                               data-entity="pages"
                               data-id="{{ $page->id }}"
                               style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Mô Tả Meta</label>
                        <textarea name="meta_description" rows="3"
                                  class="auto-save-input"
                                  data-entity="pages"
                                  data-id="{{ $page->id }}"
                                  style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical;">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Header Image --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    Ảnh Nền Trang
                </h2>
            </div>
            <div class="admin-card-body">
                @php
                    $hasHeaderImage = isset($page) && $page->header_image_url;
                @endphp
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @if($hasHeaderImage)
                        <div id="currentHeaderImage" style="position: relative; border-radius: 8px; overflow: hidden; border: 2px solid var(--admin-border);">
                            <img src="{{ $page->header_image_url }}" alt="Header Image" style="width: 100%; height: 120px; object-fit: cover; display: block;">
                            <button type="button" onclick="removeHeaderImage()" style="position: absolute; top: 8px; right: 8px; width: 28px; height: 28px; border-radius: 50%; background: rgba(0,0,0,0.7); color: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    <div id="headerImageUpload" style="{{ $hasHeaderImage ? 'display: none;' : '' }}">
                        <input type="file"
                               name="header_image_file"
                               accept="image/*"
                               id="headerImageInput"
                               onchange="uploadHeaderImage(this)"
                               style="width: 100%; height: 44px; padding: 8px 14px; border: 2px dashed var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; cursor: pointer;">
                        <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Kích thước đề xuất: 1600x600px hoặc 1920x800px</small>
                    </div>

                    <input type="hidden" name="header_image" value="{{ $page->header_image ?? '' }}" id="headerImageValue">
                </div>
            </div>
        </div>

        @if(!isset($isEdit) || !$isEdit)
        {{-- Submit Button - ONLY for create pages --}}
        <button type="submit" class="btn btn-primary" style="width: 100%; height: 48px; font-size: 15px;">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ isset($page) ? 'Cập Nhật' : 'Tạo Trang' }}
        </button>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Auto-generate slug from title
document.getElementById('titleInput')?.addEventListener('input', function(e) {
    const slugInput = document.getElementById('slugInput');
    if (!slugInput.dataset.manual) {
        slugInput.value = e.target.value
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
});

document.getElementById('slugInput')?.addEventListener('input', function() {
    this.dataset.manual = 'true';
});

// Upload header image
function uploadHeaderImage(input) {
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    const formData = new FormData();
    formData.append('file', file);

    fetch('{{ isset($page) ? route("admin.pages.uploadHeaderImage", $page) : "" }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('headerImageValue').value = data.url;
            // Show preview
            const previewHtml = `
                <div id="currentHeaderImage" style="position: relative; border-radius: 8px; overflow: hidden; border: 2px solid var(--admin-border);">
                    <img src="${data.url}" alt="Header Image" style="width: 100%; height: 120px; object-fit: cover; display: block;">
                    <button type="button" onclick="removeHeaderImage()" style="position: absolute; top: 8px; right: 8px; width: 28px; height: 28px; border-radius: 50%; background: rgba(0,0,0,0.7); color: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            `;
            document.getElementById('headerImageUpload').style.display = 'none';
            const container = document.querySelector('#headerImageUpload').parentElement;
            // Remove old preview if exists
            const oldPreview = document.getElementById('currentHeaderImage');
            if (oldPreview) oldPreview.remove();
            container.insertAdjacentHTML('afterbegin', previewHtml);
        } else {
            alert('Upload failed: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Upload failed. Please try again.');
    });
}

// Remove header image
function removeHeaderImage() {
    document.getElementById('headerImageValue').value = '';
    document.getElementById('currentHeaderImage')?.remove();
    document.getElementById('headerImageUpload').style.display = 'block';
    document.getElementById('headerImageInput').value = '';
}
</script>
@endpush
