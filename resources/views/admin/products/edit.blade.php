@extends('layouts.admin')

@section('page-title', 'Sửa Sản Phẩm')

@section('content')
<div class="admin-content">
    <div class="admin-header">
        <h1 class="admin-title">Sửa Sản Phẩm</h1>
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

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-container">
            <div class="admin-card">
                    <div class="admin-card-header">
                        <h2 class="admin-card-title">Thông Tin Sản Phẩm</h2>
                    </div>
                    <div class="admin-card-body">
                        <div class="form-group">
                            <label class="form-label required">Tên Sản Phẩm</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                                   class="form-input @error('name') error @enderror" required autofocus>
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" 
                                   class="form-input @error('slug') error @enderror">
                            @error('slug')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                            <small class="form-help">Để trống sẽ tự động tạo từ tên sản phẩm</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mã SKU</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" 
                                   class="form-input @error('sku') error @enderror">
                            @error('sku')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Danh Mục</label>
                            <select name="category_id" class="form-input @error('category_id') error @enderror" required>
                                <option value="">Chọn danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                <input type="number" name="price" value="{{ old('price', $product->price) }}" 
                                       class="form-input @error('price') error @enderror" required min="0" step="1000">
                                @error('price')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Số Lượng</label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" 
                                       class="form-input @error('stock') error @enderror" required min="0">
                                @error('stock')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mô Tả Ngắn</label>
                            <textarea name="short_description" rows="3" 
                                      class="form-input @error('short_description') error @enderror">{{ old('short_description', $product->short_description) }}</textarea>
                            @error('short_description')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mô Tả Chi Tiết</label>
                            <textarea name="description" rows="8" 
                                      class="form-input @error('description') error @enderror">{{ old('description', $product->description) }}</textarea>
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
                        @if($product->productImages->count() > 0)
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

                        <div class="form-group {{ $product->productImages->count() > 0 ? 'form-group--has-images' : 'form-group--no-images' }}">
                            <label class="form-label">Thêm Hình Ảnh Mới</label>
                            <input type="file" name="images[]" multiple accept="image/*" 
                                   class="form-input" onchange="previewImages(this)">
                            <small class="form-help">Có thể tải lên nhiều ảnh</small>
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
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <span>Kích hoạt</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
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
                        Cập Nhật
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-block">Hủy</a>
                </div>
        </div>
    </form>
</div>


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
                const existingCount = {{ $product->productImages->count() }};
                if (index === 0 && existingCount === 0) {
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
