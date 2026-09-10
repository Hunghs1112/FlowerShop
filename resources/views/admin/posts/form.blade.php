<div class="form-container">
    <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Thông Tin Bài Viết</h2>
            </div>
            <div class="admin-card-body">
                <div class="form-group">
                    <label class="form-label required">Tiêu Đề</label>
                    <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}" 
                           class="form-input @error('title') error @enderror" required>
                    @error('title')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label required">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $post->slug ?? '') }}" 
                           class="form-input @error('slug') error @enderror" required>
                    <small class="form-help">Tên thân thiện với URL (tự động tạo từ tiêu đề nếu để trống)</small>
                    @error('slug')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Trích Dẫn</label>
                    <textarea name="excerpt" rows="3" 
                              class="form-input @error('excerpt') error @enderror">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                    <small class="form-help">Tóm tắt ngắn gọn của bài viết</small>
                    @error('excerpt')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label required">Nội Dung</label>
                    <textarea name="content" rows="15" 
                              class="form-input @error('content') error @enderror" required>{{ old('content', $post->content ?? '') }}</textarea>
                    @error('content')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Hình Ảnh Nổi Bật</label>
                    <input type="file" name="featured_image" accept="image/*" 
                           class="form-input" onchange="previewImage(this)">
                    <small class="form-help">Kích thước đề xuất: 1200x630px</small>
                    @error('featured_image')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div id="imagePreview" class="image-preview"></div>

                @if(isset($post) && $post->featured_image)
                    <div class="existing-image">
                        <h3 class="form-label">Hình Ảnh Nổi Bật Hiện Tại</h3>
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="post-thumbnail">
                    </div>
                @endif
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Xuất Bản</h2>
            </div>
            <div class="admin-card-body">
                <div class="form-group">
                    <label class="form-label required">Trạng Thái</label>
                    <select name="status" class="form-input @error('status') error @enderror" required>
                        <option value="draft" {{ old('status', $post->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Nháp</option>
                        <option value="published" {{ old('status', $post->status ?? '') === 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                    </select>
                    @error('status')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Ngày Xuất Bản</label>
                    <input type="datetime-local" name="published_at" 
                           value="{{ old('published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d\TH:i') : '') }}" 
                           class="form-input @error('published_at') error @enderror">
                    <small class="form-help">Để trống để xuất bản ngay lập tức</small>
                    @error('published_at')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">SEO</h2>
            </div>
            <div class="admin-card-body">
                <div class="form-group">
                    <label class="form-label">Tiêu Đề Meta</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title ?? '') }}" 
                           class="form-input @error('meta_title') error @enderror">
                    @error('meta_title')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Mô Tả Meta</label>
                    <textarea name="meta_description" rows="3" 
                              class="form-input @error('meta_description') error @enderror">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                    @error('meta_description')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-block">
                {{ isset($post) ? 'Cập Nhật' : 'Tạo Bài Viết' }}
            </button>
        </div>
</div>


@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            preview.appendChild(img);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

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
