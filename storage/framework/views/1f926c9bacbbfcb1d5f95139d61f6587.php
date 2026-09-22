<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Bảng Điều Khiển'); ?> - Quản Trị</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/admin/sidebar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/admin/dashboard.css')); ?>">
    
    <!-- Tailwind CSS for utility classes -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        slate: {
                            900: '#0f172a',
                            800: '#1e293b',
                            700: '#334155',
                            600: '#475569',
                            500: '#64748b',
                            400: '#94a3b8',
                            300: '#cbd5e1',
                            200: '#e2e8f0',
                            100: '#f1f5f9'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="dark bg-slate-900">
    <div class="admin-layout min-h-screen bg-slate-900">
        
        <div class="admin-sidebar-overlay" id="adminSidebarOverlay" aria-hidden="true"></div>

        <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="admin-main bg-slate-900 text-slate-100">
            <?php echo $__env->make('admin.partials.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="admin-content bg-slate-900">
                <?php if(session('success')): ?>
                    <div class="admin-alert success mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-lg backdrop-blur-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <p class="text-emerald-400"><?php echo e(session('success')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="admin-alert error mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-lg backdrop-blur-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <p class="text-red-400"><?php echo e(session('error')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="admin-alert error mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-lg backdrop-blur-sm">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <span class="text-red-400 font-medium">Có lỗi xảy ra:</span>
                        </div>
                        <ul class="text-red-300 list-disc list-inside space-y-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="text-sm"><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/admin-auto-save.js')); ?>"></script>
    <script>
        // ======================================================================
        // Mobile sidebar toggle (responsive)
        // ======================================================================
        (function() {
            const menuToggle = document.querySelector('.admin-menu-toggle');
            const sidebar = document.querySelector('.admin-sidebar');
            const overlay = document.querySelector('.admin-sidebar-overlay');
            const sidebarClose = document.querySelector('.admin-sidebar-close');
            const mqDesktop = window.matchMedia('(min-width: 1024px)');

            function openSidebar() {
                if (!sidebar) return;
                sidebar.classList.add('active');
                if (overlay) overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
                if (menuToggle) menuToggle.setAttribute('aria-expanded', 'true');
            }

            function closeSidebar() {
                if (!sidebar) return;
                sidebar.classList.remove('active');
                if (overlay) overlay.classList.remove('active');
                document.body.style.overflow = '';
                if (menuToggle) menuToggle.setAttribute('aria-expanded', 'false');
            }

            function toggleSidebar() {
                if (!sidebar) return;
                if (sidebar.classList.contains('active')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            }

            if (menuToggle) {
                menuToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }

            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }

            // Close on ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar && sidebar.classList.contains('active')) {
                    closeSidebar();
                }
            });

            // Close sidebar when navigating to a new page on mobile
            if (sidebar) {
                sidebar.querySelectorAll('a').forEach(function(link) {
                    link.addEventListener('click', function() {
                        if (!mqDesktop.matches) {
                            // small delay so navigation feels responsive
                            setTimeout(closeSidebar, 100);
                        }
                    });
                });
            }

            // Reset state when crossing breakpoint
            function handleBreakpoint(e) {
                if (e.matches && sidebar && sidebar.classList.contains('active')) {
                    closeSidebar();
                }
            }

            if (mqDesktop.addEventListener) {
                mqDesktop.addEventListener('change', handleBreakpoint);
            } else if (mqDesktop.addListener) {
                mqDesktop.addListener(handleBreakpoint);
            }
        })();

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
<?php /**PATH /root/FlowerShop/resources/views/layouts/admin.blade.php ENDPATH**/ ?>