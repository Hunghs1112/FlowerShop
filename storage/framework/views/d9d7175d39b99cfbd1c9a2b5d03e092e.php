<?php $__env->startSection('page-title', 'Sửa Sản Phẩm'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header" style="margin-bottom: 32px;">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Sửa Sản Phẩm</h1>
        <p class="admin-page-subtitle">
            <span style="display: inline-flex; align-items: center; gap: 6px;">
                <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></span>
                Tự động lưu đã bật
            </span>
        </p>
    </div>
    <div class="admin-page-actions">
        <a href="<?php echo e(route('admin.catalog.index', ['tab' => 'products'])); ?>" class="btn btn-secondary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>
</div>

<form id="product-form" data-entity="products" data-id="<?php echo e($product->id); ?>">
    <div style="display: grid; grid-template-columns: 1fr 320px; gap: 24px;">
        
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">
                        <div class="admin-card-title-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        Thông Tin Sản Phẩm
                    </h2>
                </div>
                <div class="admin-card-body">
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Tên Sản Phẩm <span style="color: var(--admin-error);">*</span></label>
                            <input type="text" 
                                   name="name" 
                                   value="<?php echo e(old('name', $product->name)); ?>" 
                                   class="auto-save-input"
                                   data-entity="products"
                                   data-id="<?php echo e($product->id); ?>"
                                   data-save-url="<?php echo e(route('admin.products.updateField', $product)); ?>"
                                   style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; transition: all 0.2s;" 
                                   required>
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Slug</label>
                            <input type="text" 
                                   name="slug" 
                                   value="<?php echo e(old('slug', $product->slug)); ?>" 
                                   class="auto-save-input"
                                   data-entity="products"
                                   data-id="<?php echo e($product->id); ?>"
                                   data-save-url="<?php echo e(route('admin.products.updateField', $product)); ?>"
                                   style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; font-family: var(--admin-font-mono);">
                            <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Để trống sẽ tự tạo</small>
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Danh Mục Phụ <span style="color: var(--admin-error);">*</span></label>
                            <select name="subcategory_id" 
                                    id="subcategorySelect"
                                    class="auto-save-select"
                                    data-entity="products"
                                    data-id="<?php echo e($product->id); ?>"
                                    data-save-url="<?php echo e(route('admin.products.updateField', $product)); ?>"
                                    style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; background: white;" 
                                    required>
                                <option value="">-- Chọn danh mục phụ --</option>
                                <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($subcategory->id); ?>" <?php echo e(old('subcategory_id', $product->subcategory_id) == $subcategory->id ? 'selected' : ''); ?>>
                                        <?php echo e($subcategory->category->name); ?> → <?php echo e($subcategory->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Chọn danh mục phụ (Danh mục cha sẽ tự động được gán)</small>
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Mô Tả Ngắn</label>
                            <textarea name="short_description" 
                                      rows="3" 
                                      class="auto-save-input"
                                      data-entity="products"
                                      data-id="<?php echo e($product->id); ?>"
                                      data-save-url="<?php echo e(route('admin.products.updateField', $product)); ?>"
                                      style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical;"><?php echo e(old('short_description', $product->short_description)); ?></textarea>
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Mô Tả Chi Tiết</label>
                            <textarea name="description"
                                      rows="6"
                                      class="auto-save-input"
                                      data-entity="products"
                                      data-id="<?php echo e($product->id); ?>"
                                      data-save-url="<?php echo e(route('admin.products.updateField', $product)); ?>"
                                      style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical;"><?php echo e(old('description', $product->description)); ?></textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Chiều Dài</label>
                                <input type="text"
                                       name="length"
                                       value="<?php echo e(old('length', $product->length)); ?>"
                                       class="auto-save-input"
                                       data-entity="products"
                                       data-id="<?php echo e($product->id); ?>"
                                       data-save-url="<?php echo e(route('admin.products.updateField', $product)); ?>"
                                       style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;"
                                       placeholder="VD: 50cm, 60cm">
                            </div>

                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Xuất Xứ</label>
                                <input type="text"
                                       name="origin"
                                       value="<?php echo e(old('origin', $product->origin)); ?>"
                                       class="auto-save-input"
                                       data-entity="products"
                                       data-id="<?php echo e($product->id); ?>"
                                       data-save-url="<?php echo e(route('admin.products.updateField', $product)); ?>"
                                       style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;"
                                       placeholder="VD: Việt Nam, Hà Lan">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Số Lượng Order Tối Thiểu</label>
                                <input type="number"
                                       name="min_order_quantity"
                                       value="<?php echo e(old('min_order_quantity', $product->min_order_quantity ?? 1)); ?>"
                                       class="auto-save-input"
                                       data-entity="products"
                                       data-id="<?php echo e($product->id); ?>"
                                       data-save-url="<?php echo e(route('admin.products.updateField', $product)); ?>"
                                       style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;"
                                       min="1">
                            </div>

                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Quy Cách</label>
                                <input type="text"
                                       name="specification"
                                       value="<?php echo e(old('specification', $product->specification)); ?>"
                                       class="auto-save-input"
                                       data-entity="products"
                                       data-id="<?php echo e($product->id); ?>"
                                       data-save-url="<?php echo e(route('admin.products.updateField', $product)); ?>"
                                       style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;"
                                       placeholder="VD: Bó 10 bông, Hộp 20 cây">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">
                        <div class="admin-card-title-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        Hình Ảnh
                    </h2>
                </div>
                <div class="admin-card-body">
                    <?php if($product->productImages->count() > 0): ?>
                        <div style="margin-bottom: 24px;">
                            <h3 style="font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 12px;">Hình Ảnh Hiện Tại</h3>
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 12px;">
                                <?php $__currentLoopData = $product->productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="existing-image-item" style="position: relative; border-radius: var(--admin-radius-md); overflow: hidden; aspect-ratio: 1; border: 1px solid var(--admin-border);">
                                        <img src="<?php echo e(asset('storage/' . $image->image_path)); ?>" alt="Sản phẩm" style="width: 100%; height: 100%; object-fit: cover;">

                                        <?php if($image->is_primary): ?>
                                            <span style="position: absolute; top: 4px; left: 4px; background: var(--admin-accent); color: white; font-size: 10px; font-weight: 600; padding: 2px 6px; border-radius: 4px;">Chính</span>
                                        <?php else: ?>
                                            <button type="button" 
                                                    class="btn btn-xs"
                                                    onclick="setPrimaryProductImage(<?php echo e($product->id); ?>, <?php echo e($image->id); ?>, this)"
                                                    style="position: absolute; top: 4px; left: 4px; background: rgba(0,0,0,0.6); color: white; font-size: 10px; padding: 2px 6px; border-radius: 4px; border: none; cursor: pointer;">
                                                Đặt chính
                                            </button>
                                        <?php endif; ?>

                                        <button type="button" 
                                                class="delete-image-btn"
                                                onclick="deleteProductImage(<?php echo e($product->id); ?>, <?php echo e($image->id); ?>, this)"
                                                style="position: absolute; bottom: 4px; right: 4px; display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; background: rgba(239, 68, 68, 0.9); color: white; border-radius: 6px; font-size: 14px; border: none; cursor: pointer; transition: all 0.2s ease;"
                                                title="Xóa ảnh">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Thêm Hình Ảnh Mới</label>
                        <input type="file" 
                               name="images[]"
                               accept="image/jpeg,image/png,image/gif,image/webp" 
                               class="auto-save-file"
                               data-entity="products"
                               data-id="<?php echo e($product->id); ?>"
                               data-upload-url="<?php echo e(route('admin.products.uploadFile', $product)); ?>"
                               id="imageInput"
                               multiple
                               style="width: 100%; height: 44px; padding: 8px 14px; border: 2px dashed var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; cursor: pointer;">
                        <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">jpg, png, gif, webp – tối đa <?php echo e($maxImages ?? 10); ?> ảnh, mỗi ảnh &lt; 2 MB.</small>
                    </div>

                    <div id="imagePreview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 12px; margin-top: 16px;"></div>
                </div>
            </div>
        </div>

        
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">
                        <div class="admin-card-title-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        Giá & Tồn Kho
                    </h2>
                </div>
                <div class="admin-card-body">
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Giá (₫) <span style="color: var(--admin-error);">*</span></label>
                            <input type="number" 
                                   name="price" 
                                   value="<?php echo e(old('price', $product->price)); ?>" 
                                   class="auto-save-input"
                                   data-entity="products"
                                   data-id="<?php echo e($product->id); ?>"
                                   data-save-url="<?php echo e(route('admin.products.updateField', $product)); ?>"
                                   style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;" 
                                   required min="0" step="1000">
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Số Lượng <span style="color: var(--admin-error);">*</span></label>
                            <input type="number" 
                                   name="stock" 
                                   value="<?php echo e(old('stock', $product->stock)); ?>" 
                                   class="auto-save-input"
                                   data-entity="products"
                                   data-id="<?php echo e($product->id); ?>"
                                   data-save-url="<?php echo e(route('admin.products.updateField', $product)); ?>"
                                   style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;" 
                                   required min="0">
                        </div>
                    </div>
                </div>
            </div>

            
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
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1" 
                                   <?php echo e(old('is_active', $product->is_active) ? 'checked' : ''); ?>

                                   class="auto-save-checkbox"
                                   data-entity="products"
                                   data-id="<?php echo e($product->id); ?>"
                                   data-save-url="<?php echo e(route('admin.products.updateField', $product)); ?>"
                                   style="width: 20px; height: 20px; accent-color: var(--admin-accent);">
                            <span style="font-size: 14px; font-weight: 500;">Kích hoạt</span>
                        </label>

                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   value="1" 
                                   <?php echo e(old('is_featured', $product->is_featured) ? 'checked' : ''); ?>

                                   class="auto-save-checkbox"
                                   data-entity="products"
                                   data-id="<?php echo e($product->id); ?>"
                                   data-save-url="<?php echo e(route('admin.products.updateField', $product)); ?>"
                                   style="width: 20px; height: 20px; accent-color: var(--admin-accent);">
                            <span style="font-size: 14px; font-weight: 500;">Sản phẩm nổi bật</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/admin-auto-save.js')); ?>"></script>
<script>
function previewImages(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    if (input.files) {
        Array.from(input.files).forEach((file) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.style.cssText = 'position: relative; border-radius: var(--admin-radius-md); overflow: hidden; aspect-ratio: 1;';
                div.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
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
            // Update UI - reload page to reflect changes
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/FlowerShop/resources/views/admin/products/edit.blade.php ENDPATH**/ ?>