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
                            <label class="form-label required">Danh Mục Chính</label>
                            <select name="category_id" id="categorySelect" class="form-input auto-save-select @error('category_id') error @enderror"
                                    data-entity="products"
                                    data-id="{{ $product->id ?? '' }}"
                                    required>
                                <option value="">-- Chọn danh mục chính --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Danh Mục Phụ <span style="font-weight: 400; color: var(--admin-text-muted);">(không bắt buộc)</span></label>
                            <select name="subcategory_id" id="subcategorySelect" class="form-input auto-save-select @error('subcategory_id') error @enderror"
                                    data-entity="products"
                                    data-id="{{ $product->id ?? '' }}"
                                    >
                                <option value="">-- Không có danh mục phụ --</option>
                                @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" 
                                        data-category-id="{{ $subcategory->category_id }}"
                                        {{ old('subcategory_id', $product->subcategory_id ?? '') == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->category->name }} → {{ $subcategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-help">Có thể để trống nếu sản phẩm chỉ thuộc danh mục chính.</small>
                            @error('subcategory_id')
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

                        <div class="form-group">
                            <label class="form-label">Full Description</label>
                            <textarea name="description" rows="6"
                                      class="form-input auto-save-input @error('description') error @enderror"
                                      data-entity="products"
                                      data-id="{{ $product->id ?? '' }}">{{ old('description', $product->description ?? '') }}</textarea>
                            @error('description')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Chính Sách Đổi Trả</label>
                            <textarea name="return_policy" rows="6"
                                      class="form-input auto-save-input @error('return_policy') error @enderror"
                                      data-entity="products"
                                      data-id="{{ $product->id ?? '' }}"
                                      placeholder="Nhập chính sách đổi trả (hỗ trợ Markdown)">{{ old('return_policy', $product->return_policy ?? '') }}</textarea>
                            <small class="form-help">Hỗ trợ Markdown: **bold**, *italic*, - list, > quote</small>
                            @error('return_policy')
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
                                   data-field="images"
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
                                            <img src="{{ $image->image_url }}" alt="Sản phẩm">
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
                        <h2 class="admin-card-title">Product Videos</h2>
                    </div>
                    <div class="admin-card-body">
                        <div class="form-group">
                            <label class="form-label">Upload Videos</label>
                            <input type="file" name="videos[]" multiple accept="video/mp4,video/webm,video/quicktime" 
                                   class="form-input"
                                   id="videoUploadInput"
                                   data-entity="products"
                                   data-id="{{ $product->id ?? '' }}"
                                   data-field="videos"
                                   data-upload-url="{{ isset($product) ? route('admin.products.uploadFile', $product) : '' }}"
                                   onchange="uploadVideos(this)">
                            <small class="form-help">Upload video files (MP4, WebM, MOV). Maximum 50MB per file, up to 5 videos.</small>
                        </div>

                        <div id="videoUploadProgress" class="upload-progress" style="display: none;">
                            <div class="progress-bar" style="width: 100%; height: 24px; background: #e5e7eb; border-radius: 12px; overflow: hidden; margin: 12px 0;">
                                <div class="progress-fill" id="videoProgressFill" style="height: 100%; background: linear-gradient(90deg, #38BDF8, #22D3EE); width: 0%; transition: width 0.3s;"></div>
                            </div>
                            <p class="progress-text" id="videoProgressText" style="text-align: center; font-size: 14px; color: #6b7280;">Uploading...</p>
                        </div>

                        @if(isset($product) && $product->productImages()->videos()->count() > 0)
                            <div class="existing-videos">
                                <h3 class="form-label">Videos Hiện Tại</h3>
                                <div class="video-preview-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; margin-top: 16px;">
                                    @foreach($product->productImages()->videos()->get() as $video)
                                        <div class="video-preview-item" data-video-id="{{ $video->id }}" style="background: var(--color-surface-elevated); border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px;">
                                            <video controls style="width: 100%; max-height: 200px; border-radius: 8px; background: #000;">
                                <source src="{{ $video->image_url }}" type="{{ $video->mime_type }}">
                                                Your browser does not support video.
                                            </video>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteProductVideo({{ $product->id }}, {{ $video->id }}, this)" style="margin-top: 8px; width: 100%;">Xóa Video</button>
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

                        <div class="form-group">
                            <label class="form-label">Hiển thị trong trang</label>
                            <select name="season_id" class="form-input auto-save-select"
                                    data-entity="products"
                                    data-id="{{ $product->id ?? '' }}">
                                <option value="">-- Không hiển thị --</option>
                                <option value="thu" {{ old('season_id', $product->season_id ?? '') == 'thu' ? 'selected' : '' }}>🍂 Hội Mùa Thu</option>
                                <option value="halloween" {{ old('season_id', $product->season_id ?? '') == 'halloween' ? 'selected' : '' }}>🎃 Halloween</option>
                                <option value="thong" {{ old('season_id', $product->season_id ?? '') == 'thong' ? 'selected' : '' }}>🎄 Cây Thông Đan Mạch</option>
                            </select>
                            <small class="form-help">Chọn trang lễ hội để hiển thị sản phẩm này</small>
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

// Upload videos
window.uploadVideos = async function(input) {
    if (!input.files || input.files.length === 0) return;
    
    const productId = input.dataset.id;
    const uploadUrl = input.dataset.uploadUrl;
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    const progressDiv = document.getElementById('videoUploadProgress');
    const progressFill = document.getElementById('videoProgressFill');
    const progressText = document.getElementById('videoProgressText');
    
    progressDiv.style.display = 'block';
    
    const files = Array.from(input.files);
    let completed = 0;
    
    for (const file of files) {
        try {
            // Check file size (50MB = 52428800 bytes)
            if (file.size > 52428800) {
                Toast.error(`File ${file.name} quá lớn (tối đa 50MB)`);
                continue;
            }
            
            progressText.textContent = `Uploading ${file.name}...`;
            
            const formData = new FormData();
            formData.append('file', file);
            formData.append('field', 'videos');
            
            const response = await fetch(uploadUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            });
            
            const result = await response.json();
            
            if (response.ok && result.success) {
                completed++;
                const percent = Math.round((completed / files.length) * 100);
                progressFill.style.width = percent + '%';
                Toast.success(`Đã upload ${file.name}`);
            } else {
                Toast.error(result.message || `Lỗi upload ${file.name}`);
            }
        } catch (err) {
            console.error(err);
            Toast.error(`Lỗi kết nối khi upload ${file.name}`);
        }
    }
    
    progressDiv.style.display = 'none';
    input.value = '';
    
    if (completed > 0) {
        Toast.success(`Đã upload ${completed} video(s)`);
        setTimeout(() => location.reload(), 1000);
    }
};

// Delete video
window.deleteProductVideo = async function(productId, videoId, button) {
    if (!confirm('Xóa video này?')) return;
    
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    try {
        const response = await fetch(`/admin/products/${productId}/videos/${videoId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (response.ok) {
            Toast.success('Đã xóa video');
            button.closest('.video-preview-item').remove();
        } else {
            Toast.error('Lỗi khi xóa video');
        }
    } catch (err) {
        console.error(err);
        Toast.error('Lỗi kết nối');
    }
};
</script>
@endpush
@endif
