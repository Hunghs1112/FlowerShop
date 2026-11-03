<div class="admin-topbar">
    <div class="admin-topbar-left">
        <button class="admin-menu-toggle" id="adminMenuToggle" aria-label="Mở menu" aria-controls="adminSidebar" aria-expanded="false">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div class="admin-breadcrumb">
            <a href="{{ route('admin.dashboard') }}" class="admin-breadcrumb-item">Admin</a>
            <span class="admin-breadcrumb-separator">/</span>
            <span class="admin-breadcrumb-current">@yield('page-title', 'Bảng Điều Khiển')</span>
        </div>
    </div>

        <div class="admin-topbar-right">
        <div class="admin-topbar-actions">
            <button type="button" class="admin-topbar-btn theme-toggle" data-theme-toggle aria-label="Chuyển giao diện">
                <span class="theme-icon-light">☀️</span>
                <span class="theme-icon-dark">🌙</span>
            </button>
        </div>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="admin-topbar-btn" title="Đăng Xuất">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </form>
    </div>
</div>
