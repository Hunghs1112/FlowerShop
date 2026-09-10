@extends('layouts.admin')

@section('page-title', 'Người Dùng')

@section('content')
<div class="admin-content">
    <div class="admin-header">
        <h1 class="admin-title">Quản Lý Người Dùng</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm Người Dùng
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="admin-card">
        <div class="admin-card-header">
            <form method="GET" class="admin-filters">
                <input type="text" name="search" placeholder="Tìm kiếm người dùng..." 
                       value="{{ request('search') }}" class="input-sm">
                <select name="role" class="input-sm">
                    <option value="">Tất cả vai trò</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                    <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary">Lọc</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline">Xóa lọc</a>
            </form>
        </div>
        <div class="admin-card-body">
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th>Vai trò</th>
                            <th>Ngày tham gia</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <div class="table-product-name">{{ $user->name }}</div>
                                </td>
                                <td class="text-secondary">{{ $user->email }}</td>
                                <td class="text-secondary">{{ $user->phone ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ $user->role === 'admin' ? 'accent' : 'secondary' }}">
                                        {{ $user->role === 'admin' ? 'Quản trị viên' : 'Khách hàng' }}
                                    </span>
                                </td>
                                <td class="text-secondary">{{ $user->created_at->format('d/m/Y') }}</td>
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
                                                    onclick="return confirm('Xóa người dùng này?')">
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
                                <td colspan="6" class="text-center text-secondary">Không tìm thấy người dùng nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
            <div class="admin-card-footer">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

@endsection
