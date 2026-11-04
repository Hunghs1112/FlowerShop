@extends('layouts.admin')

@section('page-title', 'Nhóm ưu đãi')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Nhóm ưu đãi</h1>
        <p class="admin-page-subtitle">Quản lý các nhóm giảm giá áp dụng cho sản phẩm</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.discount-groups.create') }}" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm nhóm ưu đãi
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        @if($groups->isEmpty())
            <div style="padding: 40px; text-align: center; color: var(--admin-text-muted);">
                Chưa có nhóm ưu đãi nào. Nhấn "Thêm nhóm ưu đãi" để tạo nhóm đầu tiên.
            </div>
        @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Tên nhóm</th>
                    <th style="width: 120px;">Mức giảm</th>
                    <th style="width: 80px;">Số SP</th>
                    <th style="width: 80px;">Trạng thái</th>
                    <th style="width: 100px;">Thứ tự</th>
                    <th style="width: 120px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($groups as $g)
                <tr>
                    <td>
                        <a href="{{ route('admin.discount-groups.edit', $g) }}" style="font-weight: 600; color: inherit; text-decoration: none;">{{ $g->name }}</a>
                    </td>
                    <td>
                        <span style="color:#dc2626; font-weight:600;">-{{ $g->discount_percent }}%</span>
                    </td>
                    <td>{{ $g->products_count }}</td>
                    <td>
                        @if($g->is_active)
                            <span style="color:#10b981; font-size:12px; font-weight:600;">● Hiển thị</span>
                        @else
                            <span style="color: var(--admin-text-muted); font-size:12px;">○ Ẩn</span>
                        @endif
                    </td>
                    <td>{{ $g->sort_order }}</td>
                    <td>
                        <a href="{{ route('admin.discount-groups.edit', $g) }}" class="btn btn-secondary" style="padding: 6px 10px;">Sửa</a>
                        <form method="POST" action="{{ route('admin.discount-groups.destroy', $g) }}" style="display: inline;" onsubmit="return confirm('Xóa nhóm ưu đãi này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary" style="padding: 6px 10px; color: #dc2626;">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
