<div class="admin-topbar">
    <div class="admin-topbar-left">
        <button class="admin-menu-toggle" id="adminMenuToggle" aria-label="Toggle Menu">
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
            <button class="admin-topbar-btn" title="Thông Báo">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="badge"></span>
            </button>
        </div>

        <!-- Quick Add -->
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm" title="Thêm Sản Phẩm">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Thêm Sản Phẩm</span>
        </a>

        <!-- User Menu -->
        <div class="admin-user-menu">
            <div class="admin-user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="admin-user-info">
                <span class="admin-user-name">{{ auth()->user()->name }}</span>
                <span class="admin-user-role">Quản trị viên</span>
            </div>
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
