@extends('layouts.admin')

@section('page-title', 'Người Dùng')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Quản Lý Người Dùng</h1>
        <p class="admin-page-subtitle">Quản lý tài khoản người dùng trong hệ thống</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm Người Dùng
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-body" style="padding: 16px 24px;">
        <form method="GET" class="admin-filters">
            <input type="text" name="search" placeholder="Tìm kiếm người dùng..." 
                   value="{{ request('search') }}" class="input-sm">
            <select name="role" class="input-sm">
                <option value="">Tất cả vai trò</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Khách hàng</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
            @if(request()->has('search') || request()->has('role'))
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Xóa lọc</a>
            @endif
        </form>
    </div>
</div>

{{-- Users Table --}}
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
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div class="admin-user-avatar" style="width: 40px; height: 40px; font-size: 14px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="table-product-name">{{ $user->name }}</div>
                                        @if($user->id === auth()->id())
                                            <span class="badge badge-accent" style="margin-top: 4px;">Bạn</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="color: var(--admin-text-secondary);">{{ $user->email }}</td>
                            <td class="text-mono" style="color: var(--admin-text-secondary);">{{ $user->phone ?? '-' }}</td>
                            <td>
                                @if($user->vipLevel)
                                    <span class="badge badge-primary">{{ $user->vipLevel->name }}</span>
                                @else
                                    <span style="color: var(--admin-text-tertiary); font-size: 14px;">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $user->role === 'admin' ? 'badge-accent' : 'badge-secondary' }}">
                                    {{ $user->role === 'admin' ? 'Quản trị viên' : 'Khách hàng' }}
                                </span>
                            </td>
                            <td class="text-mono" style="color: var(--admin-text-secondary);">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn-icon" title="Sửa">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-icon-danger" title="Xóa" 
                                                    onclick="return confirm('Bạn có chắc muốn xóa người dùng này?\n\nHành động này không thể hoàn tác.')">
                                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
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
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    </div>
</div>
@endsection
