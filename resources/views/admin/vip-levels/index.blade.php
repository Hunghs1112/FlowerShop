@extends('layouts.admin')

@section('page-title', 'VIP Levels')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">VIP Levels</h1>
        <p class="admin-page-subtitle">Quản lý các cấp độ VIP</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.vip-levels.create') }}" class="btn btn-primary">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tạo VIP Level
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Thứ tự</th>
                        <th>Tên</th>
                        <th>Mô tả</th>
                        <th style="width: 120px;">Số người dùng</th>
                        <th style="width: 100px;">Trạng thái</th>
                        <th style="width: 150px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vipLevels as $vipLevel)
                        <tr>
                            <td>
                                <span class="badge badge-secondary">{{ $vipLevel->priority }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: var(--color-primary);">
                                    {{ $vipLevel->name }}
                                </div>
                            </td>
                            <td>
                                <div style="max-width: 400px; color: var(--admin-text-secondary);">
                                    {{ $vipLevel->description ?? '-' }}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $vipLevel->users_count }}</span>
                            </td>
                            <td>
                                @if($vipLevel->is_active)
                                    <span class="badge badge-success">Hoạt động</span>
                                @else
                                    <span class="badge badge-secondary">Không hoạt động</span>
                                @endif
                            </td>
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('admin.vip-levels.edit', $vipLevel) }}" 
                                       class="btn-icon" 
                                       title="Chỉnh sửa">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.vip-levels.destroy', $vipLevel) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa VIP level này?')"
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-danger" title="Xóa">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state-sm">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                    <p>Chưa có VIP level nào</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($vipLevels->hasPages())
        <div class="admin-card-footer">
            {{ $vipLevels->links() }}
        </div>
    @endif
</div>
@endsection
