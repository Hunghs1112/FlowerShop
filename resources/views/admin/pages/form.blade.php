<div class="form-container">
    <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Thông Tin Trang</h2>
            </div>
            <div class="admin-card-body">
                <div class="form-group">
                    <label class="form-label required">Tiêu Đề Trang</label>
                    <input type="text" name="title" value="{{ old('title', $page->title ?? '') }}" 
                           class="form-input @error('title') error @enderror" required>
                    @error('title')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label required">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $page->slug ?? '') }}" 
                           class="form-input @error('slug') error @enderror" required>
                    <small class="form-help">Ví dụ: chinh-sach-bao-mat, dieu-khoan-dich-vu</small>
                    @error('slug')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label required">Nội Dung</label>
                    <textarea name="content" rows="20" 
                              class="form-input @error('content') error @enderror" required>{{ old('content', $page->content ?? '') }}</textarea>
                    @error('content')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_active" value="1" 
                            {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }}>
                        <span>Kích hoạt</span>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-label">Tiêu Đề Meta</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title ?? '') }}" 
                           class="form-input @error('meta_title') error @enderror">
                    @error('meta_title')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Mô Tả Meta</label>
                    <textarea name="meta_description" rows="3" 
                              class="form-input @error('meta_description') error @enderror">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                    @error('meta_description')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ isset($page) ? 'Cập Nhật' : 'Tạo Trang' }}
                    </button>
                </div>
            </div>
        </div>
</div>

@push('styles')
<style>
    .form-help {
        display: block;
        margin-top: var(--space-2);
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
    }
</style>
@endpush

@push('scripts')
<script>
// Auto-generate slug from title
document.querySelector('input[name="title"]')?.addEventListener('input', function(e) {
    const slugInput = document.querySelector('input[name="slug"]');
    if (!slugInput.dataset.manual) {
        slugInput.value = e.target.value
            .toLowerCase()
            .replace(/[àáạảãâầấậẩẫăằắặẳẵ]/g, 'a')
            .replace(/[èéẹẻẽêềếệểễ]/g, 'e')
            .replace(/[ìíịỉĩ]/g, 'i')
            .replace(/[òóọỏõôồốộổỗơờớợởỡ]/g, 'o')
            .replace(/[ùúụủũưừứựửữ]/g, 'u')
            .replace(/[ỳýỵỷỹ]/g, 'y')
            .replace(/đ/g, 'd')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
});

document.querySelector('input[name="slug"]')?.addEventListener('input', function() {
    this.dataset.manual = 'true';
});
</script>
@endpush
