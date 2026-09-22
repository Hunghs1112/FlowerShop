<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Bảng Điều Khiển') - Quản Trị</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/chat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/variants.css') }}">
</head>
<body>
    <div class="admin-layout">
        {{-- Sidebar overlay (mobile only) --}}
        <div class="admin-sidebar-overlay" id="adminSidebarOverlay" aria-hidden="true"></div>

        @include('admin.partials.sidebar')

        <div class="admin-main">
            @include('admin.partials.topbar')

            <div class="admin-content">
                @if(session('success'))
                    <div class="admin-alert success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="admin-alert error">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="admin-alert error">
                        <strong>Có lỗi xảy ra:</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/admin-auto-save.js') }}"></script>
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
                    field.style.borderColor = 'var(--color-error)';
                    isValid = false;
                } else {
                    field.style.borderColor = '';
                }
            });

            return isValid;
        }
    </script>

    @stack('scripts')
</body>
</html>
