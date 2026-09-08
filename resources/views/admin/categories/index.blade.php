@extends('layouts.admin')

@section('page-title', 'Danh Mục')

@section('content')
<div class="admin-content">
    <div class="admin-header">
        <h1 class="admin-title">Quản Lý Danh Mục</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm Danh Mục
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="admin-card">
        <div class="admin-card-header">
            <form method="GET" class="admin-filters">
                <input type="text" name="search" placeholder="Tìm kiếm danh mục..." 
                       value="{{ request('search') }}" class="input-sm">
                <select name="status" class="input-sm">
                    <option value="">Tất cả trạng thái</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary">Lọc</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline">Xóa lọc</a>
            </form>
        </div>
        <div class="admin-card-body">
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên danh mục</th>
                            <th>Slug</th>
                            <th>Danh mục cha</th>
                            <th>Sản phẩm</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="table-image">
                                    @else
                                        <div class="table-image-placeholder">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="table-product-name">{{ $category->name }}</div>
                                </td>
                                <td class="text-secondary">{{ $category->slug }}</td>
                                <td>{{ $category->parent->name ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-secondary">{{ $category->products_count ?? 0 }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $category->is_active ? 'success' : 'secondary' }}">
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
                                                    onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">
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
                                <td colspan="7" class="text-center text-secondary">Không tìm thấy danh mục nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($categories->hasPages())
            <div class="admin-card-footer">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-6);
    }
    
    .admin-title {
        font-size: var(--font-size-2xl);
        font-weight: var(--font-bold);
    }
    
    .admin-filters {
        display: flex;
        gap: var(--space-3);
        flex-wrap: wrap;
    }
    
    .table-image {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-md);
        object-fit: cover;
    }

    .table-image-placeholder {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-md);
        background: var(--color-bg-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-text-tertiary);
    }
    
    .table-product-name {
        font-weight: var(--font-semibold);
        margin-bottom: var(--space-1);
    }
    
    .table-actions {
        display: flex;
        gap: var(--space-2);
    }
    
    .inline-form {
        display: inline;
    }
    
    .text-center {
        text-align: center;
    }
    
    .text-secondary {
        color: var(--color-text-secondary);
    }
</style>
@endpush
@endsection
