@extends('layouts.admin')

@section('page-title', isset($product) ? 'Edit Product' : 'Create Product')

@section('content')
<div class="admin-content">
    <div class="admin-header">
        <h1 class="admin-title">{{ isset($product) ? 'Edit Product' : 'Create Product' }}</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back
        </a>
    </div>

    <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" 
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

<div class="form-container">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h2 class="admin-card-title">Product Information</h2>
                    </div>
                    <div class="admin-card-body">
                        <div class="form-group">
                            <label class="form-label required">Product Name</label>
                            <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" 
                                   class="form-input @error('name') error @enderror" required>
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Category</label>
                            <select name="category_id" class="form-input @error('category_id') error @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
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
                                <label class="form-label required">Price (₫)</label>
                                <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" 
                                       class="form-input @error('price') error @enderror" required min="0">
                                @error('price')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Stock</label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" 
                                       class="form-input @error('stock') error @enderror" required min="0">
                                @error('stock')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Short Description</label>
                            <textarea name="short_description" rows="3" 
                                      class="form-input @error('short_description') error @enderror">{{ old('short_description', $product->short_description ?? '') }}</textarea>
                            @error('short_description')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="admin-card-header">
                        <h2 class="admin-card-title">Product Images</h2>
                    </div>
                    <div class="admin-card-body">
                        <div class="form-group">
                            <label class="form-label">Upload Images</label>
                            <input type="file" name="images[]" multiple accept="image/*" 
                                   class="form-input" onchange="previewImages(this)">
                            <small class="form-help">Upload multiple images. First image will be primary.</small>
                        </div>

                        <div id="imagePreview" class="image-preview-grid"></div>

                        @if(isset($product) && $product->productImages->count() > 0)
                            <div class="existing-images">
                                <h3 class="form-label">Hình Ảnh Hiện Tại</h3>
                                <div class="image-preview-grid">
                                    @foreach($product->productImages as $image)
                                        <div class="image-preview-item">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Sản phẩm">
                                            @if($image->is_primary)
                                                <span class="image-badge">Ảnh chính</span>
                                            @endif
                                            <label class="image-delete">
                                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}">
                                                <span>Xóa</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="admin-card">
                    <div class="admin-card-header">
                        <h2 class="admin-card-title">Trạng Thái</h2>
                    </div>
                    <div class="admin-card-body">
                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" name="is_active" value="1" 
                                    {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                                <span>Kích hoạt</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" name="is_featured" value="1" 
                                    {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                                <span>Sản phẩm nổi bật</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ isset($product) ? 'Cập Nhật Sản Phẩm' : 'Tạo Sản Phẩm' }}
                    </button>
                </div>
            </div>
    </form>
</div>

@push('styles')
<style>
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-4);
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
        border: 1px solid var(--color-border);
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
    
    .image-delete {
        position: absolute;
        bottom: var(--space-2);
        right: var(--space-2);
        padding: var(--space-1) var(--space-2);
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        font-size: var(--font-size-xs);
        border-radius: var(--radius-sm);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: var(--space-1);
    }
    
    .existing-images {
        margin-top: var(--space-6);
        padding-top: var(--space-6);
        border-top: 1px solid var(--color-border);
    }
    
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
                    badge.textContent = 'Primary';
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
