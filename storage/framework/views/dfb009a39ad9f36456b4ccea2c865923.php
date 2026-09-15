<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Bảng Điều Khiển'); ?> - Quản Trị</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Styles -->
    <?php
        function adminCssv(string $path): string {
            $full = public_path($path);
            $v = file_exists($full) ? filemtime($full) : time();
            return asset($path) . '?v=' . $v;
        }
    ?>
    <link rel="stylesheet" href="<?php echo e(adminCssv('css/fonts.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(adminCssv('css/theme.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(adminCssv('css/admin.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(adminCssv('css/admin-pages.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(adminCssv('css/admin/sidebar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(adminCssv('css/admin/forms.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(adminCssv('css/components/notification.css')); ?>">
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="admin-layout">
        <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="admin-main">
            <?php echo $__env->make('admin.partials.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="admin-content">
                <?php if(session('success')): ?>
                    <div class="admin-alert success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="admin-alert error">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="admin-alert error">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Mobile sidebar toggle
        const menuToggle = document.querySelector('.admin-menu-toggle');
        const sidebar = document.querySelector('.admin-sidebar');
        
        if (menuToggle && sidebar) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 1024) {
                    if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                        sidebar.classList.remove('active');
                    }
                }
            });
        }

        // Confirm delete actions
        function confirmDelete(formId, itemName = 'mục') {
            if (confirm(`Bạn có chắc chắn muốn xóa ${itemName} này không?`)) {
                document.getElementById(formId).submit();
            }
        }

        // Image preview helper
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Auto-dismiss alerts
        document.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.admin-alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.3s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });

        // Form validation helper
        function validateForm(formId) {
            const form = document.getElementById(formId);
            if (!form) return false;

            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = 'var(--color-accent-error)';
                    isValid = false;
                } else {
                    field.style.borderColor = '';
                }
            });

            return isValid;
        }
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop\resources\views/layouts/admin.blade.php ENDPATH**/ ?>