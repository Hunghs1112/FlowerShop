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
            <!-- Notifications -->
        <div class="admin-topbar-actions">
            <button type="button" class="admin-topbar-btn theme-toggle" data-theme-toggle aria-label="Chuyển giao diện">
                <svg class="theme-icon-light" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3V2m0 20v-1m9-9h1M2 12h1m15.36-6.36.71-.71M4.93 19.07l.71-.71m12.72 0 .71.71M4.93 4.93l.71.71M17 12a5 5 0 11-10 0 5 5 0 0110 0z"/>
                </svg>
                <svg class="theme-icon-dark" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
            </button>
            <button class="admin-topbar-btn" title="Thông Báo">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="badge"></span>
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
