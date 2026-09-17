@php
$isEdit = isset($isEdit) ? $isEdit : false;
@endphp

<div class="form-container">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h2 class="admin-card-title">Product Information</h2>
                    </div>
                    <div class="admin-card-body">
                        <div class="form-group">
                            <label class="form-label required">Product Name</label>
                            <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" 
                                   class="form-input auto-save-input @error('name') error @enderror"
                                   data-entity="products"
                                   data-id="{{ $product->id ?? '' }}"
                                   required>
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Category</label>
                            <select name="category_id" class="form-input auto-save-select @error('category_id') error @enderror"
                                    data-entity="products"
                                    data-id="{{ $product->id ?? '' }}"
                                    required>
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
                                       class="form-input auto-save-input @error('price') error @enderror"
                                       data-entity="products"
                                       data-id="{{ $product->id ?? '' }}"
                                       required min="0">
                                @error('price')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Stock</label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" 
                                       class="form-input auto-save-input @error('stock') error @enderror"
                                       data-entity="products"
                                       data-id="{{ $product->id ?? '' }}"
                                       required min="0">
                                @error('stock')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Short Description</label>
                            <textarea name="short_description" rows="3" 
                                      class="form-input auto-save-input @error('short_description') error @enderror"
                                      data-entity="products"
                                      data-id="{{ $product->id ?? '' }}">{{ old('short_description', $product->short_description ?? '') }}</textarea>
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
                                   class="form-input auto-save-file"
                                   data-entity="products"
                                   data-id="{{ $product->id ?? '' }}"
                                   data-upload-url="{{ isset($product) ? route('admin.products.uploadFile', $product) : '' }}"
                                   onchange="previewImages(this)">
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
                                            @else
                                                <button type="button" class="btn btn-xs" onclick="setPrimaryProductImage({{ $product->id }}, {{ $image->id }}, this)">Đặt chính</button>
                                            @endif
                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteProductImage({{ $product->id }}, {{ $image->id }}, this)">Xóa</button>
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
                                    {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}
                                    class="auto-save-checkbox"
                                    data-entity="products"
                                    data-id="{{ $product->id ?? '' }}">
                                <span>Kích hoạt</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" name="is_featured" value="1" 
                                    {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}
                                    class="auto-save-checkbox"
                                    data-entity="products"
                                    data-id="{{ $product->id ?? '' }}">
                                <span>Sản phẩm nổi bật</span>
                            </label>
                        </div>
                    </div>
                </div>

                @if(!$isEdit)
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ isset($product) ? 'Cập Nhật Sản Phẩm' : 'Tạo Sản Phẩm' }}
                    </button>
                </div>
                @endif
            </div>

@if($isEdit)
@push('scripts')
<script src="{{ asset('js/admin-auto-save.js') }}"></script>
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

// Set primary image
window.setPrimaryProductImage = async function(productId, imageId, button) {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    try {
        const response = await fetch(`/admin/products/${productId}/images/${imageId}/set-primary`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (response.ok) {
            Toast.success('Đã đặt làm ảnh chính');
            setTimeout(() => location.reload(), 500);
        } else {
            Toast.error('Lỗi khi đặt ảnh chính');
        }
    } catch (err) {
        console.error(err);
        Toast.error('Lỗi kết nối');
    }
};
</script>
@endpush
@endif
