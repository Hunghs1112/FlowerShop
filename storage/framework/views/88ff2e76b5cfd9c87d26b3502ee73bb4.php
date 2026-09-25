<?php
$isEdit = isset($isEdit) ? $isEdit : false;
?>

<div style="display: grid; grid-template-columns: 1fr 320px; gap: 24px;">
    
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    Thông Tin Danh Mục
                </h2>
            </div>
            <div class="admin-card-body">
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Tên Danh Mục <span style="color: var(--admin-error);">*</span></label>
                        <input type="text" 
                               name="name" 
                               value="<?php echo e(old('name', $category->name ?? '')); ?>" 
                               class="auto-save-input"
                               data-entity="categories"
                               data-id="<?php echo e($category->id ?? ''); ?>"
                               style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; transition: all 0.2s;" 
                               required>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Slug</label>
                        <input type="text" 
                               name="slug" 
                               value="<?php echo e(old('slug', $category->slug ?? '')); ?>" 
                               id="slugInput"
                               class="auto-save-input"
                               data-entity="categories"
                               data-id="<?php echo e($category->id ?? ''); ?>"
                               style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; font-family: var(--admin-font-mono);">
                        <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Để trống sẽ tự động tạo từ tên</small>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Mô Tả</label>
                        <textarea name="description" 
                                  rows="4" 
                                  class="auto-save-input"
                                  data-entity="categories"
                                  data-id="<?php echo e($category->id ?? ''); ?>"
                                  style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical;"><?php echo e(old('description', $category->description ?? '')); ?></textarea>
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
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 8px;">Hình Ảnh Chính</label>
                        
                        <?php if(isset($category) && $category->image): ?>
                            <div class="category-image-container" style="margin-bottom: 12px; position: relative; display: inline-block;">
                                <div style="width: 120px; height: 120px; border-radius: var(--admin-radius-md); overflow: hidden; border: 1px solid var(--admin-border);">
                                    <img src="<?php echo e($category->image_url); ?>" alt="<?php echo e($category->name); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <button type="button" 
                                        onclick="deleteCategoryImage(<?php echo e($category->id); ?>, this)"
                                        style="position: absolute; top: -8px; right: -8px; width: 28px; height: 28px; background: rgba(239, 68, 68, 0.9); color: white; border-radius: 50%; border: 2px solid white; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                        title="Xóa ảnh">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        <?php endif; ?>

                        <input type="file" 
                               name="image" 
                               accept="image/*" 
                               id="imageInput" 
                               class="auto-save-file"
                               data-entity="categories"
                               data-id="<?php echo e($category->id ?? ''); ?>"
                               data-field="image"
                               data-upload-url="<?php echo e(isset($category) ? route('admin.categories.uploadImage', $category) : ''); ?>"
                               onchange="previewImage(this, 'imagePreview')"
                               style="width: 100%; height: 44px; padding: 8px 14px; border: 2px dashed var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; cursor: pointer;">
                        <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Kích thước đề xuất: 800x800px</small>
                        
                        <div id="imagePreview" style="margin-top: 12px;"></div>
                    </div>

                    
                    <div style="padding-top: 20px; border-top: 1px solid var(--admin-border);">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 8px;">Hình Ảnh Hover <span style="font-size: 12px; font-weight: 400; color: var(--admin-text-muted);">(Tùy chọn)</span></label>
                        
                        <?php if(isset($category) && $category->hover_image): ?>
                            <div class="category-hover-image-container" style="margin-bottom: 12px; position: relative; display: inline-block;">
                                <div style="width: 120px; height: 120px; border-radius: var(--admin-radius-md); overflow: hidden; border: 1px solid var(--admin-border);">
                                    <img src="<?php echo e($category->hover_image_url); ?>" alt="<?php echo e($category->name); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <button type="button" 
                                        onclick="deleteCategoryHoverImage(<?php echo e($category->id); ?>, this)"
                                        style="position: absolute; top: -8px; right: -8px; width: 28px; height: 28px; background: rgba(239, 68, 68, 0.9); color: white; border-radius: 50%; border: 2px solid white; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                        title="Xóa ảnh hover">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        <?php endif; ?>

                        <input type="file" 
                               name="hover_image" 
                               accept="image/*" 
                               id="hoverImageInput" 
                               class="auto-save-file"
                               data-entity="categories"
                               data-id="<?php echo e($category->id ?? ''); ?>"
                               data-field="hover_image"
                               data-upload-url="<?php echo e(isset($category) ? route('admin.categories.uploadHoverImage', $category) : ''); ?>"
                               onchange="previewImage(this, 'hoverImagePreview')"
                               style="width: 100%; height: 44px; padding: 8px 14px; border: 2px dashed var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; cursor: pointer;">
                        <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Hiển thị khi hover. Kích thước đề xuất: 800x800px</small>
                        
                        <div id="hoverImagePreview" style="margin-top: 12px;"></div>
                    </div>

                    
                    <div style="padding-top: 20px; border-top: 1px solid var(--admin-border);">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 8px;">Ảnh Banner <span style="font-size: 12px; font-weight: 400; color: var(--admin-text-muted);">(Tùy chọn)</span></label>
                        
                        <?php if(isset($category) && $category->banner_image): ?>
                            <div class="category-banner-image-container" style="margin-bottom: 12px; position: relative; display: inline-block;">
                                <div style="width: 240px; height: 120px; border-radius: var(--admin-radius-md); overflow: hidden; border: 1px solid var(--admin-border);">
                                    <img src="<?php echo e($category->banner_image_url); ?>" alt="<?php echo e($category->name); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <button type="button" 
                                        onclick="deleteCategoryBannerImage(<?php echo e($category->id); ?>, this)"
                                        style="position: absolute; top: -8px; right: -8px; width: 28px; height: 28px; background: rgba(239, 68, 68, 0.9); color: white; border-radius: 50%; border: 2px solid white; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                        title="Xóa ảnh banner">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        <?php endif; ?>

                        <input type="file" 
                               name="banner_image" 
                               accept="image/*" 
                               id="bannerImageInput" 
                               class="auto-save-file"
                               data-entity="categories"
                               data-id="<?php echo e($category->id ?? ''); ?>"
                               data-field="banner_image"
                               data-upload-url="<?php echo e(isset($category) ? route('admin.categories.uploadBannerImage', $category) : ''); ?>"
                               onchange="previewImage(this, 'bannerImagePreview')"
                               style="width: 100%; height: 44px; padding: 8px 14px; border: 2px dashed var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; cursor: pointer;">
                        <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Hiển thị ở trang danh mục. Kích thước đề xuất: 1920x600px</small>
                        
                        <div id="bannerImagePreview" style="margin-top: 12px;"></div>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    Trạng Thái
                </h2>
            </div>
            <div class="admin-card-body">
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               <?php echo e(old('is_active', $category->is_active ?? true) ? 'checked' : ''); ?>

                               class="auto-save-checkbox"
                               data-entity="categories"
                               data-id="<?php echo e($category->id ?? ''); ?>"
                               style="width: 20px; height: 20px; accent-color: var(--admin-accent);">
                        <span style="font-size: 14px; font-weight: 500;">Kích hoạt</span>
                    </label>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Thứ Tự Hiển Thị</label>
                        <input type="number" 
                               name="sort_order" 
                               value="<?php echo e(old('sort_order', $category->sort_order ?? 0)); ?>" 
                               class="auto-save-input"
                               data-entity="categories"
                               data-id="<?php echo e($category->id ?? ''); ?>"
                               style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;" 
                               min="0">
                        <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Số nhỏ hơn hiển thị trước</small>
                    </div>
                </div>
            </div>
        </div>

        <?php if(!isset($category) || !$category->id): ?>
        
        <div class="admin-card">
            <div class="admin-card-body">
                <button type="submit" class="btn btn-primary" style="width: 100%; height: 44px; font-size: 15px; font-weight: 600;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 8px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Tạo Danh Mục
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.style.cssText = 'width: 120px; height: 120px; border-radius: var(--admin-radius-md); overflow: hidden; border: 1px solid var(--admin-border);';
            div.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
            preview.appendChild(div);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function deleteCategoryImage(categoryId, button) {
    if (!confirm('Bạn có chắc muốn xóa ảnh này?')) return;
    
    fetch(`/admin/categories/${categoryId}/image`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            button.closest('.category-image-container').remove();
            if (window.Toast) {
                Toast.success(data.message);
            }
        } else {
            if (window.Toast) {
                Toast.error(data.message || 'Có lỗi xảy ra');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (window.Toast) {
            Toast.error('Có lỗi xảy ra khi xóa ảnh');
        }
    });
}

function deleteCategoryHoverImage(categoryId, button) {
    if (!confirm('Bạn có chắc muốn xóa ảnh hover này?')) return;
    
    fetch(`/admin/categories/${categoryId}/hover-image`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            button.closest('.category-hover-image-container').remove();
            if (window.Toast) {
                Toast.success(data.message);
            }
        } else {
            if (window.Toast) {
                Toast.error(data.message || 'Có lỗi xảy ra');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (window.Toast) {
            Toast.error('Có lỗi xảy ra khi xóa ảnh hover');
        }
    });
}

function deleteCategoryBannerImage(categoryId, button) {
    if (!confirm('Bạn có chắc muốn xóa ảnh banner này?')) return;
    
    fetch(`/admin/categories/${categoryId}/banner-image`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            button.closest('.category-banner-image-container').remove();
            if (window.Toast) {
                Toast.success(data.message);
            }
        } else {
            if (window.Toast) {
                Toast.error(data.message || 'Có lỗi xảy ra');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (window.Toast) {
            Toast.error('Có lỗi xảy ra khi xóa ảnh banner');
        }
    });
}

// Auto-generate slug from name (only for edit mode without manual slug)
<?php if(isset($category) && $category->id): ?>
document.querySelector('input[name="name"]')?.addEventListener('input', function(e) {
    const slugInput = document.getElementById('slugInput');
    if (!slugInput.dataset.manual) {
        slugInput.value = e.target.value
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
});

document.getElementById('slugInput')?.addEventListener('input', function() {
    this.dataset.manual = 'true';
});
<?php else: ?>
// For create page, auto-generate slug
document.querySelector('input[name="name"]')?.addEventListener('input', function(e) {
    const slugInput = document.getElementById('slugInput');
    if (!slugInput.dataset.manual) {
        slugInput.value = e.target.value
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
});

document.getElementById('slugInput')?.addEventListener('input', function() {
    this.dataset.manual = 'true';
});
<?php endif; ?>
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /root/FlowerShop/resources/views/admin/categories/form.blade.php ENDPATH**/ ?>