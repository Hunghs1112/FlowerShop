@extends('layouts.admin')

@section('page-title', 'Trang')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Quản Lý Trang</h1>
        <p class="admin-page-subtitle">Quản lý các trang tĩnh của website</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm Trang
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-body" style="padding: 16px 24px;">
        <form method="GET" class="admin-filters">
            <input type="text" name="search" placeholder="Tìm kiếm trang..." 
                   value="{{ request('search') }}" class="input-sm">
            <select name="status" class="input-sm">
                <option value="">Tất cả trạng thái</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
            @if(request()->has('search') || request()->has('status'))
                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary btn-sm">Xóa lọc</a>
            @endif
        </form>
    </div>
</div>

{{-- Pages Table --}}
<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Tiêu Đề</th>
                        <th>Slug</th>
                        <th style="width: 160px;">Cập Nhật</th>
                        <th style="width: 120px;">Trạng Thái</th>
                        <th style="width: 140px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                        <tr>
                            <td>
                                <div class="table-product-name">{{ $page->title }}</div>
                            </td>
                            <td class="text-mono" style="color: var(--admin-text-secondary);">{{ $page->slug }}</td>
                            <td class="text-mono" style="color: var(--admin-text-secondary);">{{ $page->updated_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge {{ $page->is_active ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $page->is_active ? 'Hoạt động' : 'Tạm ngưng' }}
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('policy', $page->slug) }}" class="btn-icon" title="Xem" target="_blank">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn-icon" title="Sửa">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="inline-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-danger" title="Xóa" 
                                                onclick="return confirm('Bạn có chắc muốn xóa trang này?\n\nHành động này không thể hoàn tác.')">
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
                            <td colspan="5">
                                <div class="empty-state-sm">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p>Không tìm thấy trang nào</p>
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
