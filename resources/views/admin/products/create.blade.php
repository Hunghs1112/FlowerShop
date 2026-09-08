@extends('layouts.admin')

@section('page-title', 'Thêm Sản Phẩm')

@section('content')
<div class="admin-content">
    <div class="admin-header">
        <h1 class="admin-title">Thêm Sản Phẩm Mới</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-container">
            <div class="admin-card">
                    <div class="admin-card-header">
                        <h2 class="admin-card-title">Thông Tin Sản Phẩm</h2>
                    </div>
                    <div class="admin-card-body">
                        <div class="form-group">
                            <label class="form-label required">Tên Sản Phẩm</label>
                            <input type="text" name="name" value="{{ old('name') }}" 
                                   class="form-input @error('name') error @enderror" required autofocus>
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Slug (Tự động tạo nếu để trống)</label>
                            <input type="text" name="slug" value="{{ old('slug') }}" 
                                   class="form-input @error('slug') error @enderror" placeholder="vd: hoa-hong-do">
                            @error('slug')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                            <small class="form-help">Để trống sẽ tự động tạo từ tên sản phẩm</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mã SKU</label>
                            <input type="text" name="sku" value="{{ old('sku') }}" 
                                   class="form-input @error('sku') error @enderror" placeholder="vd: PROD001">
                            @error('sku')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Danh Mục</label>
                            <select name="category_id" class="form-input @error('category_id') error @enderror" required>
                                <option value="">Chọn danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label required">Giá (₫)</label>
                                <input type="number" name="price" value="{{ old('price') }}" 
                                       class="form-input @error('price') error @enderror" required min="0" step="1000">
                                @error('price')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Số Lượng</label>
                                <input type="number" name="stock" value="{{ old('stock', 0) }}" 
                                       class="form-input @error('stock') error @enderror" required min="0">
                                @error('stock')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mô Tả Ngắn</label>
                            <textarea name="short_description" rows="3" 
                                      class="form-input @error('short_description') error @enderror" 
                                      placeholder="Mô tả ngắn gọn về sản phẩm...">{{ old('short_description') }}</textarea>
                            @error('short_description')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mô Tả Chi Tiết</label>
                            <textarea name="description" rows="8" 
                                      class="form-input @error('description') error @enderror" 
                                      placeholder="Mô tả chi tiết về sản phẩm...">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="admin-card-header">
                        <h2 class="admin-card-title">Hình Ảnh Sản Phẩm</h2>
                    </div>
                    <div class="admin-card-body">
                        <div class="form-group">
                            <label class="form-label">Tải Lên Hình Ảnh</label>
                            <input type="file" name="images[]" multiple accept="image/*" 
                                   class="form-input" onchange="previewImages(this)">
                            <small class="form-help">Có thể tải lên nhiều ảnh. Ảnh đầu tiên sẽ là ảnh chính.</small>
                        </div>

                        <div id="imagePreview" class="image-preview-grid"></div>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="admin-card-header">
                        <h2 class="admin-card-title">Trạng Thái</h2>
                    </div>
                    <div class="admin-card-body">
                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span>Kích hoạt</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <span>Sản phẩm nổi bật</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-block">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Tạo Sản Phẩm
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-block">Hủy</a>
                </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-6);
    }
    
    .admin-title {
        font-size: var(--font-size-2xl);
        font-weight: var(--font-bold);
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-4);
    }
    
    @media (max-width: 640px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .image-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: var(--space-3);
        margin-top: var(--space-4);
    }
    
    .image-preview-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 2px solid var(--color-border);
        background-color: var(--color-bg-secondary);
    }
    
    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .image-badge {
        position: absolute;
        top: var(--space-2);
        left: var(--space-2);
        padding: var(--space-1) var(--space-2);
        background-color: var(--color-accent-cool);
        color: white;
        font-size: var(--font-size-xs);
        font-weight: var(--font-semibold);
        border-radius: var(--radius-sm);
    }
    
    .form-help {
        display: block;
        margin-top: var(--space-2);
        font-size: var(--font-size-sm);
        color: var(--color-text-secondary);
    }
    
    .alert {
        padding: var(--space-4);
        border-radius: var(--radius-md);
        margin-bottom: var(--space-6);
    }
    
    .alert-danger {
        background-color: #fee;
        border: 1px solid #fcc;
        color: #c00;
    }
    
    .alert ul {
        margin: 0;
        padding-left: var(--space-5);
    }
    
    .alert li {
        margin: var(--space-1) 0;
    }
</style>
@endpush

@push('scripts')
<script>
function previewImages(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'image-preview-item';
                const img = document.createElement('img');
                img.src = e.target.result;
                div.appendChild(img);
                if (index === 0) {
                    const badge = document.createElement('span');
                    badge.className = 'image-badge';
                    badge.textContent = 'Ảnh chính';
                    div.appendChild(badge);
                }
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endpush
@endsection
