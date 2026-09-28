<?php
$isEdit = isset($isEdit) ? $isEdit : false;
?>

<div class="form-container">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h2 class="admin-card-title">Product Information</h2>
                    </div>
                    <div class="admin-card-body">
                        <div class="form-group">
                            <label class="form-label required">Product Name</label>
                            <input type="text" name="name" value="<?php echo e(old('name', $product->name ?? '')); ?>" 
                                   class="form-input auto-save-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   data-entity="products"
                                   data-id="<?php echo e($product->id ?? ''); ?>"
                                   required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="form-error"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Danh Mục Phụ</label>
                            <select name="subcategory_id" id="subcategorySelect" class="form-input auto-save-select <?php $__errorArgs = ['subcategory_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    data-entity="products"
                                    data-id="<?php echo e($product->id ?? ''); ?>"
                                    required>
                                <option value="">-- Chọn danh mục phụ --</option>
                                <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($subcategory->id); ?>" 
                                        data-category-id="<?php echo e($subcategory->category_id); ?>"
                                        <?php echo e(old('subcategory_id', $product->subcategory_id ?? '') == $subcategory->id ? 'selected' : ''); ?>>
                                        <?php echo e($subcategory->category->name); ?> → <?php echo e($subcategory->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small class="form-help">Chọn danh mục phụ (Danh mục cha sẽ tự động được gán)</small>
                            <?php $__errorArgs = ['subcategory_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="form-error"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label required">Price (₫)</label>
                                <input type="number" name="price" value="<?php echo e(old('price', $product->price ?? '')); ?>" 
                                       class="form-input auto-save-input <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       data-entity="products"
                                       data-id="<?php echo e($product->id ?? ''); ?>"
                                       required min="0">
                                <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="form-error"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Stock</label>
                                <input type="number" name="stock" value="<?php echo e(old('stock', $product->stock ?? 0)); ?>" 
                                       class="form-input auto-save-input <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       data-entity="products"
                                       data-id="<?php echo e($product->id ?? ''); ?>"
                                       required min="0">
                                <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="form-error"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Short Description</label>
                            <textarea name="short_description" rows="3" 
                                      class="form-input auto-save-input <?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      data-entity="products"
                                      data-id="<?php echo e($product->id ?? ''); ?>"><?php echo e(old('short_description', $product->short_description ?? '')); ?></textarea>
                            <?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="form-error"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Full Description</label>
                            <textarea name="description" rows="6"
                                      class="form-input auto-save-input <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      data-entity="products"
                                      data-id="<?php echo e($product->id ?? ''); ?>"><?php echo e(old('description', $product->description ?? '')); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="form-error"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Chính Sách Đổi Trả</label>
                            <textarea name="return_policy" rows="6"
                                      class="form-input auto-save-input <?php $__errorArgs = ['return_policy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      data-entity="products"
                                      data-id="<?php echo e($product->id ?? ''); ?>"
                                      placeholder="Nhập chính sách đổi trả (hỗ trợ Markdown)"><?php echo e(old('return_policy', $product->return_policy ?? '')); ?></textarea>
                            <small class="form-help">Hỗ trợ Markdown: **bold**, *italic*, - list, > quote</small>
                            <?php $__errorArgs = ['return_policy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="form-error"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                   data-id="<?php echo e($product->id ?? ''); ?>"
                                   data-field="images"
                                   data-upload-url="<?php echo e(isset($product) ? route('admin.products.uploadFile', $product) : ''); ?>"
                                   onchange="previewImages(this)">
                            <small class="form-help">Upload multiple images. First image will be primary.</small>
                        </div>

                        <div id="imagePreview" class="image-preview-grid"></div>

                        <?php if(isset($product) && $product->productImages->count() > 0): ?>
                            <div class="existing-images">
                                <h3 class="form-label">Hình Ảnh Hiện Tại</h3>
                                <div class="image-preview-grid">
                                    <?php $__currentLoopData = $product->productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="image-preview-item">
                                            <img src="<?php echo e($image->image_url); ?>" alt="Sản phẩm">
                                            <?php if($image->is_primary): ?>
                                                <span class="image-badge">Ảnh chính</span>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-xs" onclick="setPrimaryProductImage(<?php echo e($product->id); ?>, <?php echo e($image->id); ?>, this)">Đặt chính</button>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteProductImage(<?php echo e($product->id); ?>, <?php echo e($image->id); ?>, this)">Xóa</button>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
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
                                   data-id="<?php echo e($product->id ?? ''); ?>"
                                   data-field="videos"
                                   data-upload-url="<?php echo e(isset($product) ? route('admin.products.uploadFile', $product) : ''); ?>"
                                   onchange="uploadVideos(this)">
                            <small class="form-help">Upload video files (MP4, WebM, MOV). Maximum 50MB per file, up to 5 videos.</small>
                        </div>

                        <div id="videoUploadProgress" class="upload-progress" style="display: none;">
                            <div class="progress-bar" style="width: 100%; height: 24px; background: #e5e7eb; border-radius: 12px; overflow: hidden; margin: 12px 0;">
                                <div class="progress-fill" id="videoProgressFill" style="height: 100%; background: linear-gradient(90deg, #38BDF8, #22D3EE); width: 0%; transition: width 0.3s;"></div>
                            </div>
                            <p class="progress-text" id="videoProgressText" style="text-align: center; font-size: 14px; color: #6b7280;">Uploading...</p>
                        </div>

                        <?php if(isset($product) && $product->productImages()->videos()->count() > 0): ?>
                            <div class="existing-videos">
                                <h3 class="form-label">Videos Hiện Tại</h3>
                                <div class="video-preview-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; margin-top: 16px;">
                                    <?php $__currentLoopData = $product->productImages()->videos()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="video-preview-item" data-video-id="<?php echo e($video->id); ?>" style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px;">
                                            <video controls style="width: 100%; max-height: 200px; border-radius: 8px; background: #000;">
                                <source src="<?php echo e($video->image_url); ?>" type="<?php echo e($video->mime_type); ?>">
                                                Your browser does not support video.
                                            </video>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteProductVideo(<?php echo e($product->id); ?>, <?php echo e($video->id); ?>, this)" style="margin-top: 8px; width: 100%;">Xóa Video</button>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
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
                                    <?php echo e(old('is_active', $product->is_active ?? true) ? 'checked' : ''); ?>

                                    class="auto-save-checkbox"
                                    data-entity="products"
                                    data-id="<?php echo e($product->id ?? ''); ?>">
                                <span>Kích hoạt</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" name="is_featured" value="1" 
                                    <?php echo e(old('is_featured', $product->is_featured ?? false) ? 'checked' : ''); ?>

                                    class="auto-save-checkbox"
                                    data-entity="products"
                                    data-id="<?php echo e($product->id ?? ''); ?>">
                                <span>Sản phẩm nổi bật</span>
                            </label>
                        </div>
                    </div>
                </div>

                <?php if(!$isEdit): ?>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-block">
                        <?php echo e(isset($product) ? 'Cập Nhật Sản Phẩm' : 'Tạo Sản Phẩm'); ?>

                    </button>
                </div>
                <?php endif; ?>
            </div>

<?php if($isEdit): ?>
<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /root/FlowerShop/resources/views/admin/products/form.blade.php ENDPATH**/ ?>