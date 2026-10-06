<?php $__env->startSection('page-title', 'Mystery Box Requests'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Mystery Box Requests</h1>
        <p class="admin-page-subtitle">Quản lý các yêu cầu hộp hoa bí ẩn</p>
    </div>
</div>


<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-body" style="padding: 16px 24px;">
        <form method="GET" class="admin-filters" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <select name="status" class="input-sm" onchange="this.form.submit()">
                <option value="">Tất cả trạng thái (<?php echo e($statusCounts['all']); ?>)</option>
                <option value="new" <?php echo e(request('status') == 'new' ? 'selected' : ''); ?>>Mới (<?php echo e($statusCounts['new']); ?>)</option>
                <option value="reviewing" <?php echo e(request('status') == 'reviewing' ? 'selected' : ''); ?>>Đang xem xét (<?php echo e($statusCounts['reviewing']); ?>)</option>
                <option value="confirmed" <?php echo e(request('status') == 'confirmed' ? 'selected' : ''); ?>>Đã xác nhận (<?php echo e($statusCounts['confirmed']); ?>)</option>
                <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Hoàn thành (<?php echo e($statusCounts['completed']); ?>)</option>
                <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Đã hủy (<?php echo e($statusCounts['cancelled']); ?>)</option>
            </select>

            <input type="text" name="search" placeholder="Tìm theo tên, SĐT, email, mã..." 
                   value="<?php echo e(request('search')); ?>" class="input-sm" style="min-width: 250px;">

            <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" class="input-sm" placeholder="Từ ngày">
            <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" class="input-sm" placeholder="Đến ngày">

            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
            
            <?php if(request()->hasAny(['status', 'search', 'date_from', 'date_to'])): ?>
                <a href="<?php echo e(route('admin.mystery-boxes.index')); ?>" class="btn btn-secondary btn-sm">Xóa lọc</a>
            <?php endif; ?>
        </form>
    </div>
</div>


<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 120px;">Mã Yêu Cầu</th>
                        <th>Khách Hàng</th>
                        <th>Liên Hệ</th>
                        <th>Ngân Sách</th>
                        <th>Phong Cách</th>
                        <th style="width: 140px;">Ngày Tạo</th>
                        <th style="width: 160px;">Trạng Thái</th>
                        <th style="width: 80px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $mysteryBoxRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mbr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <span class="text-mono" style="font-weight: 600; color: var(--color-primary);">
                                    <?php echo e($mbr->request_id); ?>

                                </span>
                            </td>
                            <td>
                                <div style="font-weight: 600;"><?php echo e($mbr->name); ?></div>
                                <?php if($mbr->user): ?>
                                    <span class="badge badge-secondary" style="margin-top: 4px;">Thành viên</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="text-mono" style="color: var(--color-text);"><?php echo e($mbr->phone); ?></div>
                                <?php if($mbr->email): ?>
                                    <small style="color: var(--color-text-light);"><?php echo e($mbr->email); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge badge-info"><?php echo e($mbr->budget_range); ?></span>
                            </td>
                            <td><?php echo e($mbr->style); ?></td>
                            <td class="text-mono" style="color: var(--color-text-light);">
                                <?php echo e($mbr->created_at->format('d/m/Y H:i')); ?>

                            </td>
                            <td>
                                <form action="<?php echo e(route('admin.mystery-boxes.updateStatus', $mbr)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <select name="status" class="input-sm" onchange="this.form.submit()" 
                                            style="width: auto; min-width: 140px;">
                                        <option value="new" <?php echo e($mbr->status == 'new' ? 'selected' : ''); ?>>Mới</option>
                                        <option value="reviewing" <?php echo e($mbr->status == 'reviewing' ? 'selected' : ''); ?>>Đang xem xét</option>
                                        <option value="confirmed" <?php echo e($mbr->status == 'confirmed' ? 'selected' : ''); ?>>Đã xác nhận</option>
                                        <option value="completed" <?php echo e($mbr->status == 'completed' ? 'selected' : ''); ?>>Hoàn thành</option>
                                        <option value="cancelled" <?php echo e($mbr->status == 'cancelled' ? 'selected' : ''); ?>>Đã hủy</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.mystery-boxes.show', $mbr)); ?>" class="btn-icon" title="Xem chi tiết">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state-sm">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p>Không tìm thấy yêu cầu nào</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>


</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\admin\mystery-boxes\index.blade.php ENDPATH**/ ?>