@extends('layouts.admin')

@section('page-title', 'Sản Phẩm')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Quản Lý Sản Phẩm</h1>
        <p class="admin-page-subtitle">Quản lý và cập nhật danh sách sản phẩm của cửa hàng</p>
    </div>
</div>

{{-- Filters --}}
<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-body" style="padding: 16px 24px;">
        <form method="GET" class="admin-filters">
            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." 
                   value="{{ request('search') }}" class="input-sm">
            <select name="category" class="input-sm">
                <option value="">Tất cả danh mục</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <select name="status" class="input-sm">
                <option value="">Tất cả trạng thái</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Lọc
            </button>
            @if(request()->has('search') || request()->has('category') || request()->has('status'))
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">Xóa lọc</a>
            @endif
        </form>
    </div>
</div>

{{-- Products Table --}}
<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Hình Ảnh</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Danh Mục</th>
                        <th style="width: 130px;">Giá</th>
                        <th style="width: 100px;">Tồn Kho</th>
                        <th style="width: 110px;">Trạng Thái</th>
                        <th style="width: 120px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td data-label="Hình Ảnh">
                                <img src="{{ $product->getPrimaryImageUrl() }}" alt="{{ $product->name }}" class="table-image">
                            </td>
                            <td data-label="Tên Sản Phẩm">
                                <div class="table-product-name">{{ $product->name }}</div>
                                @if($product->is_featured)
                                    <span class="badge badge-accent" style="margin-top: 4px;">Nổi bật</span>
                                @endif
                            </td>
                            <td data-label="Danh Mục">
                                <span style="color: var(--admin-text-secondary);">{{ $product->category->name ?? '-' }}</span>
                            </td>
                            <td data-label="Giá">
                                <span class="text-semibold">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                            </td>
                            <td data-label="Tồn Kho">
                                @if($product->stock == 0)
                                    <span class="badge badge-danger">Hết hàng</span>
                                @elseif($product->stock < 10)
                                    <span class="badge badge-warning">Còn {{ $product->stock }}</span>
                                @else
                                    <span class="badge badge-success">{{ $product->stock }}</span>
                                @endif
                            </td>
                            <td data-label="Trạng Thái">
                                <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $product->is_active ? 'Hoạt động' : 'Tạm ngưng' }}
                                </span>
                            </td>
                            <td data-label="Thao Tác">
                                <div class="table-actions">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn-icon" title="Sửa" aria-label="Sửa sản phẩm">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-danger" title="Xóa" aria-label="Xóa sản phẩm"
                                                onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?\n\nHành động này không thể hoàn tác.')">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <p>Không tìm thấy sản phẩm nào</p>
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
