<?php $__env->startSection('page-title', 'Chỉnh Sửa Banner'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Chỉnh Sửa Banner</h1>
        <p class="admin-page-subtitle"><?php echo e($banner->title ?? 'Banner #' . $banner->id); ?></p>
    </div>
    <div class="admin-page-actions">
        <a href="<?php echo e(route('admin.banners.index')); ?>" class="btn btn-secondary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay lại
        </a>
    </div>
</div>

<?php if($errors->any()): ?>
    <div class="alert alert-danger" style="margin-bottom: 24px;">
        <strong>Có lỗi xảy ra:</strong>
        <ul style="margin: 8px 0 0; padding-left: 20px;">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?php echo e(route('admin.banners.update', $banner)); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        
        
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Thông Tin Banner</h2>
            </div>
            <div class="admin-card-body">
                
                
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label" style="font-weight: 600; margin-bottom: 8px; display: block;">
                        Ảnh Hiện Tại
                    </label>
                    <div style="border-radius: 8px; overflow: hidden; border: 2px solid var(--admin-border); margin-bottom: 12px;">
                        <img src="<?php echo e($banner->image_url); ?>" alt="<?php echo e($banner->title ?? 'Banner'); ?>" style="width: 100%; height: auto; display: block;">
                    </div>
                    
                    <label class="form-label" style="font-weight: 600; margin-bottom: 8px; display: block;">
                        Thay Đổi Ảnh <span style="color: var(--admin-text-muted); font-weight: 400; font-size: 13px;">(tùy chọn)</span>
                    </label>
                    <input type="file" 
                           name="image" 
                           accept="image/*" 
                           class="form-input"
                           id="bannerImageInput"
                           style="width: 100%;">
                    <small style="display: block; margin-top: 6px; color: var(--admin-text-muted); font-size: 12px;">
                        Để trống nếu không muốn thay đổi. Khuyến nghị: 1920×800px. Tối đa 4MB.
                    </small>
                    
                    
                    <div id="imagePreview" style="margin-top: 16px; display: none;">
                        <p style="font-size: 13px; font-weight: 600; margin-bottom: 8px;">Ảnh mới:</p>
                        <img id="previewImg" src="" alt="Preview" style="max-width: 100%; border-radius: 8px; border: 2px solid var(--admin-border);">
                    </div>
                </div>

                
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label" style="font-weight: 600; margin-bottom: 8px; display: block;">
                        Tiêu Đề <span style="color: var(--admin-text-muted); font-weight: 400; font-size: 13px;">(tùy chọn)</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           value="<?php echo e(old('title', $banner->title)); ?>"
                           class="form-input"
                           placeholder="VD: Hoa Tươi Cao Cấp"
                           style="width: 100%;">
                    <small style="display: block; margin-top: 6px; color: var(--admin-text-muted); font-size: 12px;">
                        Để trống nếu ảnh banner đã có text.
                    </small>
                </div>

                
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label" style="font-weight: 600; margin-bottom: 8px; display: block;">
                        Mô Tả <span style="color: var(--admin-text-muted); font-weight: 400; font-size: 13px;">(tùy chọn)</span>
                    </label>
                    <textarea name="subtitle" 
                              rows="2"
                              class="form-input"
                              placeholder="VD: Khám phá bộ sưu tập hoa nhập khẩu cao cấp"
                              style="width: 100%; resize: vertical;"><?php echo e(old('subtitle', $banner->subtitle)); ?></textarea>
                </div>

                
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label" style="font-weight: 600; margin-bottom: 8px; display: block;">
                        Text Nút <span style="color: var(--admin-text-muted); font-weight: 400; font-size: 13px;">(tùy chọn)</span>
                    </label>
                    <input type="text" 
                           name="button_text" 
                           value="<?php echo e(old('button_text', $banner->button_text)); ?>"
                           class="form-input"
                           placeholder="VD: Khám phá ngay"
                           style="width: 100%;">
                </div>

                
                <div class="form-group">
                    <label class="form-label" style="font-weight: 600; margin-bottom: 8px; display: block;">
                        Link Nút <span style="color: var(--admin-text-muted); font-weight: 400; font-size: 13px;">(tùy chọn)</span>
                    </label>
                    <input type="url" 
                           name="button_link" 
                           value="<?php echo e(old('button_link', $banner->button_link)); ?>"
                           class="form-input"
                           placeholder="VD: <?php echo e(route('products.index')); ?>"
                           style="width: 100%;">
                    <small style="display: block; margin-top: 6px; color: var(--admin-text-muted); font-size: 12px;">
                        Link đầy đủ (bắt đầu bằng http:// hoặc https://)
                    </small>
                </div>

            </div>
        </div>

        
        <div>
            <div class="admin-card" style="margin-bottom: 24px;">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Cài Đặt</h2>
                </div>
                <div class="admin-card-body">
                    
                    
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label class="form-label" style="font-weight: 600; margin-bottom: 8px; display: block;">
                            Thứ Tự
                        </label>
                        <input type="number" 
                               name="sort_order" 
                               value="<?php echo e(old('sort_order', $banner->sort_order)); ?>"
                               min="0"
                               class="form-input"
                               style="width: 100%;">
                        <small style="display: block; margin-top: 6px; color: var(--admin-text-muted); font-size: 12px;">
                            Số nhỏ hơn hiển thị trước.
                        </small>
                    </div>

                    
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="display: flex; align-items: center; cursor: pointer; user-select: none;">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   <?php echo e(old('is_active', $banner->is_active) ? 'checked' : ''); ?>

                                   style="margin-right: 8px; width: 16px; height: 16px;">
                            <span style="font-weight: 600; font-size: 14px;">Hiển thị banner</span>
                        </label>
                        <small style="display: block; margin-top: 6px; color: var(--admin-text-muted); font-size: 12px;">
                            Tắt để ẩn banner khỏi trang chủ.
                        </small>
                    </div>

                    
                    <div class="form-group">
                        <label style="display: flex; align-items: center; cursor: pointer; user-select: none;">
                            <input type="checkbox" 
                                   name="hide_overlay"
                                   value="1"
                                   <?php echo e(old('hide_overlay', !$banner->has_background) ? 'checked' : ''); ?>

                                   style="margin-right: 8px; width: 16px; height: 16px;">
                            <span style="font-weight: 600; font-size: 14px;">Ẩn overlay</span>
                        </label>
                        <small style="display: block; margin-top: 6px; color: var(--admin-text-muted); font-size: 12px;">
                            Bật nếu ảnh banner đã có nền riêng và không cần lớp phủ xám.
                        </small>
                    </div>

                </div>
            </div>

            
            <div class="admin-card">
                <div class="admin-card-body" style="display: flex; flex-direction: column; gap: 12px;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Cập Nhật Banner
                    </button>
                    <a href="<?php echo e(route('admin.banners.index')); ?>" class="btn btn-secondary" style="width: 100%; justify-content: center;">
                        Hủy
                    </a>
                </div>
            </div>
        </div>

    </div>
</form>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('bannerImageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.alert {
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 14px;
}
.alert-danger {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\admin\banners\edit.blade.php ENDPATH**/ ?>