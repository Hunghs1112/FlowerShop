<div class="form-container">
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Thông Tin Danh Mục</h2>
            </div>
            <div class="admin-card-body">
                <div class="form-group">
                    <label class="form-label required">Tên Danh Mục</label>
                    <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" 
                           class="form-input @error('name') error @enderror" required>
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label required">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" 
                           class="form-input @error('slug') error @enderror" required>
                    <small class="form-help">Để trống sẽ tự động tạo từ tên danh mục</small>
                    @error('slug')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Danh Mục Cha</label>
                    <select name="parent_id" class="form-input @error('parent_id') error @enderror">
                        <option value="">Không có (Danh mục gốc)</option>
                        @foreach($categories ?? [] as $cat)
                            @if(!isset($category) || $cat->id !== $category->id)
                                <option value="{{ $cat->id }}" 
                                    {{ old('parent_id', $category->parent_id ?? '') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('parent_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Mô Tả</label>
                    <textarea name="description" rows="4" 
                              class="form-input @error('description') error @enderror">{{ old('description', $category->description ?? '') }}</textarea>
                    @error('description')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Hình Ảnh Danh Mục</label>
                    <input type="file" name="image" accept="image/*" 
                           class="form-input" onchange="previewImage(this)">
                    <small class="form-help">Kích thước đề xuất: 800x800px</small>
                    @error('image')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div id="imagePreview" class="image-preview"></div>

                @if(isset($category) && $category->image)
                    <div class="existing-image">
                        <h3 class="form-label">Hình Ảnh Hiện Tại</h3>
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                    </div>
                @endif

                <div class="form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_active" value="1" 
                            {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                        <span>Kích hoạt</span>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-label">Thứ Tự Hiển Thị</label>
                    <input type="number" name="order" value="{{ old('order', $category->order ?? 0) }}" 
                           class="form-input" min="0">
                    <small class="form-help">Số nhỏ hơn sẽ hiển thị trước</small>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-block">
                {{ isset($category) ? 'Cập Nhật' : 'Tạo Danh Mục' }}
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

// Auto-generate slug from name
document.querySelector('input[name="name"]')?.addEventListener('input', function(e) {
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
