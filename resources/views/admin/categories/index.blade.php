@extends('layouts.admin')

@section('page-title', 'Danh Mục')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Quản Lý Danh Mục</h1>
        <p class="admin-page-subtitle">Quản lý các danh mục sản phẩm của cửa hàng</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm Danh Mục
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-body" style="padding: 16px 24px;">
        <form method="GET" class="admin-filters">
            <input type="text" name="search" placeholder="Tìm kiếm danh mục..." 
                   value="{{ request('search') }}" class="input-sm">
            <select name="status" class="input-sm">
                <option value="">Tất cả trạng thái</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
            @if(request()->has('search') || request()->has('status'))
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">Xóa lọc</a>
            @endif
        </form>
    </div>
</div>

{{-- Categories Table --}}
<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Hình Ảnh</th>
                        <th>Tên Danh Mục</th>
                        <th>Slug</th>
                        <th>Danh Mục Cha</th>
                        <th style="width: 100px;">Sản Phẩm</th>
                        <th style="width: 120px;">Trạng Thái</th>
                        <th style="width: 120px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="table-image">
                                @else
                                    <div class="table-image" style="width: 56px; height: 56px; background: var(--admin-bg-content); display: flex; align-items: center; justify-content: center; border-radius: var(--admin-radius-md);">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24" style="color: var(--admin-text-muted);">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="table-product-name">{{ $category->name }}</div>
                            </td>
                            <td class="text-mono" style="color: var(--admin-text-secondary);">{{ $category->slug }}</td>
                            <td style="color: var(--admin-text-secondary);">{{ $category->parent->name ?? '-' }}</td>
                            <td>
                                <span class="badge badge-secondary">{{ $category->products_count ?? 0 }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $category->is_active ? 'Hoạt động' : 'Tạm ngưng' }}
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn-icon" title="Sửa">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-danger" title="Xóa" 
                                                onclick="return confirm('Bạn có chắc muốn xóa danh mục này?\n\nHành động này không thể hoàn tác.')">
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
                            <td colspan="7">
                                <div class="empty-state-sm">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <p>Không tìm thấy danh mục nào</p>
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
