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
        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">
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
                                        <img src="<?php echo e($image->image_url); ?>" alt="Sản phẩm" style="width: 100%; height: 100%; object-fit: cover;">

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
                               data-field="images"
                               data-upload-url="<?php echo e(route('admin.products.uploadFile', $product)); ?>"
                               data-max-images="<?php echo e($maxImages ?? 10); ?>"
                               id="imageInput"
                               multiple
                               style="width: 100%; height: 44px; padding: 8px 14px; border: 2px dashed var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; cursor: pointer;">
                        <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">jpg, png, gif, webp – tối đa <?php echo e($maxImages ?? 10); ?> ảnh, mỗi ảnh &lt; 2 MB.</small>
                    </div>

                    <div id="imagePreview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 12px; margin-top: 16px;"></div>
                </div>
            </div>

            
            <div class="admin-card">
                <div class="admin-card-header">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <h2 class="admin-card-title">
                            <div class="admin-card-title-icon">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            Variants / SKU
                        </h2>
                        <button type="button" onclick="openVariantModal()" class="btn btn-sm btn-primary">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Thêm Variant
                        </button>
                    </div>
                </div>
                <div class="admin-card-body">
                    <div id="variantsList" style="display: flex; flex-direction: column; gap: 12px;">
                        <div style="text-align: center; padding: 24px; color: var(--admin-text-muted);">
                            <p>Đang tải...</p>
                        </div>
                    </div>
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
<script>
const productId = <?php echo e($product->id); ?>;
let currentVariants = [];

// Load variants on page load
document.addEventListener('DOMContentLoaded', function() {
    loadVariants();
});

// Load all variants
async function loadVariants() {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    try {
        const response = await fetch(`/admin/products/${productId}/variants`, {
            headers: {
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (response.ok) {
            const data = await response.json();
            currentVariants = data.variants || [];
            renderVariantsList();
        }
    } catch (err) {
        console.error('Error loading variants:', err);
    }
}

// Render variants list
function renderVariantsList() {
    const container = document.getElementById('variantsList');
    
    if (currentVariants.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 24px; color: var(--admin-text-muted);">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 12px; opacity: 0.3;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <p>Chưa có variant nào</p>
                <small>Nhấn "Thêm Variant" để tạo SKU mới</small>
            </div>
        `;
        return;
    }

    container.innerHTML = currentVariants.map(variant => `
        <div class="variant-item" data-variant-id="${variant.id}" style="padding: 16px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); background: #fafafa;">
            <div style="display: flex; gap: 12px; margin-bottom: 12px;">
                <img src="${variant.primary_image_url}" alt="${variant.sku}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid var(--admin-border);">
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                        <strong style="font-size: 13px; font-family: var(--admin-font-mono); color: var(--admin-accent);">${variant.sku}</strong>
                        ${variant.is_active ? '<span style="font-size: 10px; background: #10b981; color: white; padding: 2px 6px; border-radius: 4px;">Active</span>' : '<span style="font-size: 10px; background: #6b7280; color: white; padding: 2px 6px; border-radius: 4px;">Inactive</span>'}
                    </div>
                    <div style="font-size: 13px; color: var(--admin-text-secondary);">
                        ${variant.name || '<em>Kế thừa tên sản phẩm</em>'}
                    </div>
                    <div style="display: flex; gap: 12px; margin-top: 6px; font-size: 12px; color: var(--admin-text-muted);">
                        ${variant.color ? `<span>🎨 ${variant.color}</span>` : ''}
                        ${variant.size ? `<span>📏 ${variant.size}</span>` : ''}
                        ${variant.price ? `<span>💰 ${new Intl.NumberFormat('vi-VN').format(variant.price)}₫</span>` : ''}
                        ${variant.stock !== null ? `<span>📦 ${variant.stock}</span>` : ''}
                        ${variant.images_count > 0 ? `<span>📸 ${variant.images_count} ảnh</span>` : ''}
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <button type="button" onclick="openVariantModal(${variant.id})" class="btn btn-xs btn-secondary" title="Chỉnh sửa">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <button type="button" onclick="deleteVariant(${variant.id})" class="btn btn-xs btn-danger" title="Xóa">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

// State for variant modal
let variantModalState = {
    mode: 'create', // 'create' or 'edit'
    variantId: null,
    productId: productId
};

// Open variant modal (create or edit)
function openVariantModal(variantId = null) {
    variantModalState.mode = variantId ? 'edit' : 'create';
    variantModalState.variantId = variantId;

    const isEdit = variantId !== null;
    const title = isEdit ? 'Chỉnh Sửa Variant' : 'Thêm Variant Mới';
    const submitLabel = isEdit ? 'Cập Nhật' : 'Tạo Variant';

    const modalHtml = `
        <div id="variantModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 9999; padding: 20px;">
            <div style="background: white; border-radius: 12px; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
                <div style="padding: 24px; border-bottom: 1px solid var(--admin-border);">
                    <h3 style="font-size: 18px; font-weight: 600; margin: 0;">${title}</h3>
                </div>
                <div style="padding: 24px;">
                    <form id="variantForm" style="display: flex; flex-direction: column; gap: 16px;">
                        <input type="hidden" name="variantId" value="${isEdit ? variantId : ''}">
                        
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Tên Variant</label>
                            <input type="text" name="name" style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: 8px;">
                            <small style="color: var(--admin-text-muted);">Để trống để kế thừa tên sản phẩm</small>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Giá (₫)</label>
                                <input type="number" name="price" min="0" step="1000" style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: 8px;">
                                <small style="color: var(--admin-text-muted);">Để trống để dùng giá gốc</small>
                            </div>
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Tồn kho</label>
                                <input type="number" name="stock" min="0" style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: 8px;">
                                <small style="color: var(--admin-text-muted);">Để trống để dùng tồn kho gốc</small>
                            </div>
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Mô tả ngắn</label>
                            <textarea name="description" rows="3" style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: 8px; resize: vertical;"></textarea>
                        </div>

                        <div style="border-top: 1px solid var(--admin-border); padding-top: 16px; margin-top: 8px;">
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 12px;">Hình Ảnh</label>
                            
                            ${isEdit ? `
                            <div id="variantCurrentImages" style="margin-bottom: 16px;">
                                <!-- Ảnh hiện tại sẽ được load tại đây -->
                            </div>
                            ` : ''}
                            
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Thêm Ảnh Mới</label>
                                <input type="file" 
                                       name="variantImages" 
                                       id="variantImageInput"
                                       accept="image/jpeg,image/png,image/gif,image/webp" 
                                       multiple
                                       style="width: 100%; height: 44px; padding: 8px 14px; border: 2px dashed var(--admin-border); border-radius: 8px; font-size: 13px; cursor: pointer;">
                                <small style="color: var(--admin-text-muted);">jpg, png, gif, webp – tối đa 2 MB/ảnh</small>
                            </div>
                            
                            <div id="variantImagePreview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 8px; margin-top: 12px;"></div>
                        </div>
                    </form>
                </div>
                <div style="padding: 16px 24px; border-top: 1px solid var(--admin-border); display: flex; gap: 12px; justify-content: flex-end;">
                    <button type="button" onclick="closeVariantModal()" class="btn btn-secondary">Hủy</button>
                    <button type="button" onclick="saveVariant()" class="btn btn-primary">${submitLabel}</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHtml);

    // Setup file input listener
    const imageInput = document.getElementById('variantImageInput');
    if (imageInput) {
        imageInput.addEventListener('change', previewVariantImages);
    }

    // Nếu là edit mode, load data variant
    if (isEdit) {
        loadVariantDataIntoModal(variantId);
    }
}

// Load variant data into modal for editing
async function loadVariantDataIntoModal(variantId) {
    const variant = currentVariants.find(v => v.id === variantId);
    if (!variant) return;

    const form = document.getElementById('variantForm');
    if (form) {
        form.querySelector('[name="name"]').value = variant.name || '';
        form.querySelector('[name="price"]').value = variant.price || '';
        form.querySelector('[name="stock"]').value = variant.stock || '';
        form.querySelector('[name="description"]').value = variant.description || '';
    }

    // Load hiện tại ảnh
    const imagesContainer = document.getElementById('variantCurrentImages');
    if (imagesContainer && variant.images_count > 0) {
        // Fetch variant images
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        try {
            const response = await fetch(`/admin/products/${productId}/variants/${variantId}`, {
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) return;
            
            // Load ảnh từ API (nếu cần chi tiết hơn)
            // Hiện tại dùng primary_image_url từ list
            imagesContainer.innerHTML = `
                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    <div style="position: relative; width: 80px; height: 80px; border-radius: 8px; overflow: hidden; border: 1px solid var(--admin-border);">
                        <img src="${variant.primary_image_url}" alt="${variant.sku}" style="width: 100%; height: 100%; object-fit: cover;">
                        <span style="position: absolute; top: 2px; right: 2px; background: var(--admin-accent); color: white; font-size: 10px; padding: 2px 4px; border-radius: 3px;">Chính</span>
                    </div>
                    <div style="flex: 1; padding-top: 8px;">
                        <small style="color: var(--admin-text-muted);">
                            ${variant.images_count} ảnh hiện có
                        </small>
                    </div>
                </div>
            `;
        } catch (err) {
            console.error('Error loading variant images:', err);
        }
    }
}

// Preview ảnh variant mới
function previewVariantImages(e) {
    const files = e.target.files;
    const preview = document.getElementById('variantImagePreview');
    preview.innerHTML = '';

    if (files) {
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.style.cssText = `position: relative; border-radius: 8px; overflow: hidden; aspect-ratio: 1; border: 1px solid var(--admin-border);`;
                div.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}

// Close variant modal
function closeVariantModal() {
    const modal = document.getElementById('variantModal');
    if (modal) modal.remove();
    variantModalState.mode = 'create';
    variantModalState.variantId = null;
}

// Save variant (create or update)
async function saveVariant() {
    const form = document.getElementById('variantForm');
    const formData = new FormData(form);
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // Prepare JSON data (không dùng FormData vì cần JSON)
    const data = {
        name: formData.get('name') || null,
        price: formData.get('price') || null,
        stock: formData.get('stock') || null,
        description: formData.get('description') || null,
    };

    try {
        const isEdit = variantModalState.mode === 'edit';
        const method = isEdit ? 'PUT' : 'POST';
        const url = isEdit 
            ? `/admin/products/${productId}/variants/${variantModalState.variantId}`
            : `/admin/products/${productId}/variants`;

        // Step 1: Lưu thông tin variant
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (!response.ok) {
            Toast.error(result.message || (isEdit ? 'Lỗi khi cập nhật variant' : 'Lỗi khi tạo variant'));
            return;
        }

        const variantId = isEdit ? variantModalState.variantId : result.variant.id;

        // Step 2: Upload ảnh (nếu có)
        const imageInput = document.getElementById('variantImageInput');
        if (imageInput && imageInput.files && imageInput.files.length > 0) {
            const imageFormData = new FormData();
            Array.from(imageInput.files).forEach(file => {
                imageFormData.append('images', file);
            });
            imageFormData.append('product_id', productId);
            imageFormData.append('variant_id', variantId);

            const imageResponse = await fetch(`/admin/products/${productId}/variants/${variantId}/upload-images`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: imageFormData
            });

            if (!imageResponse.ok) {
                console.warn('Warning: Ảnh upload có vấn đề nhưng variant đã được lưu');
            }
        }

        Toast.success(result.message || (isEdit ? 'Đã cập nhật variant' : 'Đã tạo variant mới'));
        closeVariantModal();
        loadVariants();
    } catch (err) {
        console.error('Error saving variant:', err);
        Toast.error('Lỗi kết nối');
    }
}

// Delete variant
async function deleteVariant(variantId) {
    if (!confirm('Bạn có chắc muốn xóa variant này? Tất cả ảnh của variant cũng sẽ bị xóa.')) {
        return;
    }

    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    try {
        const response = await fetch(`/admin/products/${productId}/variants/${variantId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (response.ok) {
            Toast.success(result.message || 'Đã xóa variant');
            loadVariants();
        } else {
            Toast.error(result.message || 'Lỗi khi xóa variant');
        }
    } catch (err) {
        console.error('Error deleting variant:', err);
        Toast.error('Lỗi kết nối');
    }
}

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