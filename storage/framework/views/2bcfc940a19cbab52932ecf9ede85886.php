<div style="display: grid; grid-template-columns: 1fr 320px; gap: 24px;">
    
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    Thông Tin Trang
                </h2>
            </div>
            <div class="admin-card-body">
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Tiêu Đề <span style="color: var(--admin-error);">*</span></label>
                        <input type="text" name="title" value="<?php echo e(old('title', $page->title ?? '')); ?>" 
                               id="titleInput"
                               class="auto-save-input"
                               data-entity="pages"
                               data-id="<?php echo e($page->id); ?>"
                               style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; transition: all 0.2s;" 
                               required>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Slug <span style="color: var(--admin-error);">*</span></label>
                        <input type="text" name="slug" value="<?php echo e(old('slug', $page->slug ?? '')); ?>" 
                               id="slugInput"
                               class="auto-save-input"
                               data-entity="pages"
                               data-id="<?php echo e($page->id); ?>"
                               style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; font-family: var(--admin-font-mono);">
                        <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Ví dụ: chinh-sach-bao-mat, dieu-khoan-dich-vu</small>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Nội Dung <span style="color: var(--admin-error);">*</span></label>
                        <textarea name="content" rows="15" 
                                  id="contentEditor"
                                  class="auto-save-input"
                                  data-entity="pages"
                                  data-id="<?php echo e($page->id); ?>"
                                  style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical; font-family: inherit; line-height: 1.6;" 
                                  required><?php echo e(old('content', $page->content ?? '')); ?></textarea>
                        <small style="display: block; margin-top: 4px; color: var(--admin-text-muted);">Ctrl+Enter để lưu ngay</small>
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
                        <input type="checkbox" name="is_active" value="1" 
                               <?php echo e(old('is_active', $page->is_active ?? true) ? 'checked' : ''); ?>

                               class="auto-save-checkbox"
                               data-entity="pages"
                               data-id="<?php echo e($page->id); ?>"
                               style="width: 20px; height: 20px; accent-color: var(--admin-accent);">
                        <span style="font-size: 14px; font-weight: 500;">Kích hoạt</span>
                    </label>
                </div>
            </div>
        </div>

        
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    SEO
                </h2>
            </div>
            <div class="admin-card-body">
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Tiêu Đề Meta</label>
                        <input type="text" name="meta_title" value="<?php echo e(old('meta_title', $page->meta_title ?? '')); ?>" 
                               class="auto-save-input"
                               data-entity="pages"
                               data-id="<?php echo e($page->id); ?>"
                               style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">Mô Tả Meta</label>
                        <textarea name="meta_description" rows="3" 
                                  class="auto-save-input"
                                  data-entity="pages"
                                  data-id="<?php echo e($page->id); ?>"
                                  style="width: 100%; padding: 12px; border: 1px solid var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; resize: vertical;"><?php echo e(old('meta_description', $page->meta_description ?? '')); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <?php if(!isset($isEdit) || !$isEdit): ?>
        
        <button type="submit" class="btn btn-primary" style="width: 100%; height: 48px; font-size: 15px;">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <?php echo e(isset($page) ? 'Cập Nhật' : 'Tạo Trang'); ?>

        </button>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Auto-generate slug from title
document.getElementById('titleInput')?.addEventListener('input', function(e) {
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
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /root/FlowerShop/resources/views/admin/pages/form.blade.php ENDPATH**/ ?>