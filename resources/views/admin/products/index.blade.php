@extends('layouts.admin')

@section('page-title', 'Sản Phẩm')

@section('content')
<div class="admin-content">
    <div class="admin-header">
        <h1 class="admin-title">Quản Lý Sản Phẩm</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm Sản Phẩm
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="admin-card">
        <div class="admin-card-header">
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
                <button type="submit" class="btn btn-sm btn-primary">Lọc</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline">Xóa lọc</a>
            </form>
        </div>
        <div class="admin-card-body">
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <img src="{{ $product->getPrimaryImage() }}" alt="{{ $product->name }}" class="table-image">
                                </td>
                                <td>
                                    <div class="table-product-name">{{ $product->name }}</div>
                                    @if($product->is_featured)
                                        <span class="badge badge-accent">Nổi bật</span>
                                    @endif
                                </td>
                                <td>{{ $product->category->name ?? '-' }}</td>
                                <td class="text-semibold">{{ number_format($product->price, 0, ',', '.') }}₫</td>
                                <td>
                                    <span class="badge badge-{{ $product->stock == 0 ? 'danger' : ($product->stock < 10 ? 'warning' : 'success') }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $product->is_active ? 'success' : 'secondary' }}">
                                        {{ $product->is_active ? 'Hoạt động' : 'Tạm ngưng' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn-icon" title="Sửa">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-icon-danger" title="Xóa" 
                                                    onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
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
                                <td colspan="7" class="text-center text-secondary">Không tìm thấy sản phẩm nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($products->hasPages())
            <div class="admin-card-footer">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

@endsection
