<?php $__env->startSection('page-title', 'Người Dùng'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Quản Lý Người Dùng</h1>
        <p class="admin-page-subtitle">Quản lý tài khoản người dùng trong hệ thống</p>
    </div>
    <div class="admin-page-actions">
        <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm Người Dùng
        </a>
    </div>
</div>


<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-body" style="padding: 16px 24px;">
        <form method="GET" class="admin-filters">
            <input type="text" name="search" placeholder="Tìm kiếm người dùng..." 
                   value="<?php echo e(request('search')); ?>" class="input-sm">
            <select name="role" class="input-sm">
                <option value="">Tất cả vai trò</option>
                <option value="admin" <?php echo e(request('role') == 'admin' ? 'selected' : ''); ?>>Quản trị viên</option>
                <option value="customer" <?php echo e(request('role') == 'customer' ? 'selected' : ''); ?>>Khách hàng</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
            <?php if(request()->has('search') || request()->has('role')): ?>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary btn-sm">Xóa lọc</a>
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
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Điện Thoại</th>
                        <th style="width: 120px;">VIP Level</th>
                        <th style="width: 140px;">Vai Trò</th>
                        <th style="width: 140px;">Ngày Tham Gia</th>
                        <th style="width: 120px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div class="admin-user-avatar" style="width: 40px; height: 40px; font-size: 14px;">
                                        <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                    </div>
                                    <div>
                                        <div class="table-product-name"><?php echo e($user->name); ?></div>
                                        <?php if($user->id === auth()->id()): ?>
                                            <span class="badge badge-accent" style="margin-top: 4px;">Bạn</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td style="color: var(--admin-text-secondary);"><?php echo e($user->email); ?></td>
                            <td class="text-mono" style="color: var(--admin-text-secondary);"><?php echo e($user->phone ?? '-'); ?></td>
                            <td>
                                <?php if($user->vipLevel): ?>
                                    <span class="badge badge-primary"><?php echo e($user->vipLevel->name); ?></span>
                                <?php else: ?>
                                    <span style="color: var(--admin-text-tertiary); font-size: 14px;">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge <?php echo e($user->role === 'admin' ? 'badge-accent' : 'badge-secondary'); ?>">
                                    <?php echo e($user->role === 'admin' ? 'Quản trị viên' : 'Khách hàng'); ?>

                                </span>
                            </td>
                            <td class="text-mono" style="color: var(--admin-text-secondary);"><?php echo e($user->created_at->format('d/m/Y')); ?></td>
                            <td>
                                <div class="table-actions">
                                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn-icon" title="Sửa">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <?php if($user->id !== auth()->id()): ?>
                                        <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" class="inline-form">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn-icon btn-icon-danger" title="Xóa" 
                                                    onclick="return confirm('Bạn có chắc muốn xóa người dùng này?\n\nHành động này không thể hoàn tác.')">
                                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state-sm">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    <p>Không tìm thấy người dùng nào</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\admin\users\index.blade.php ENDPATH**/ ?>