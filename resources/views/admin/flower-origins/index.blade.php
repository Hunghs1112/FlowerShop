@extends('layouts.admin')

@section('title', 'Bản đồ nguồn gốc hoa')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Bản đồ nguồn gốc hoa</h1>
        <p class="admin-page-subtitle">Quản lý các điểm hoa hiển thị tại trang Giới thiệu</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.flower-origins.create') }}" class="btn btn-primary">+ Thêm loài hoa</a>
    </div>
</div>

<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-body">
        <form method="GET" style="display:flex;gap:12px;">
            <input name="search" value="{{ request('search') }}" placeholder="Tìm theo quốc gia hoặc loài hoa" style="flex:1;height:44px;padding:0 14px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md);">
            <button class="btn btn-secondary" type="submit">Tìm</button>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body" style="padding:0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead><tr><th>Ảnh</th><th>Quốc gia</th><th>Loài hoa</th><th>Vùng trồng</th><th>Thứ tự</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td><img src="{{ $item->image_url }}" alt="{{ $item->flower }}" class="table-image" style="object-fit:cover;"></td>
                        <td>{{ $item->country }}</td>
                        <td><strong>{{ $item->flower }}</strong><br><small>{{ $item->latin }}</small></td>
                        <td>{{ $item->region }}</td>
                        <td>{{ $item->sort_order }}</td>
                        <td><span class="badge {{ $item->is_active ? 'badge-success' : 'badge-secondary' }}">{{ $item->is_active ? 'Hiển thị' : 'Ẩn' }}</span></td>
                        <td><div class="table-actions">
                            <a href="{{ route('admin.flower-origins.edit', $item) }}" class="btn-icon" title="Sửa">✎</a>
                            <form action="{{ route('admin.flower-origins.destroy', $item) }}" method="POST" class="inline-form" onsubmit="return confirm('Xóa điểm hoa này?')">
                                @csrf @method('DELETE')
                                <button class="btn-icon btn-icon-danger" title="Xóa">×</button>
                            </form>
                        </div></td>
                    </tr>
                @empty
                    <tr><td colspan="7">Chưa có dữ liệu.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div style="margin-top:16px;">{{ $items->links() }}</div>
@endsection
