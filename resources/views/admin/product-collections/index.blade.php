@extends('layouts.admin')

@section('page-title', 'Bộ sưu tập gợi ý')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Bộ sưu tập gợi ý</h1>
        <p class="admin-page-subtitle">Tạo các bộ sưu tập (thường theo màu) hiển thị trên trang sản phẩm</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.product-collections.create') }}" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm bộ sưu tập
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        @if($collections->isEmpty())
            <div style="padding: 40px; text-align: center; color: var(--admin-text-muted);">
                Chưa có bộ sưu tập nào. Nhấn "Thêm bộ sưu tập" để tạo bộ đầu tiên.
            </div>
        @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 36px;"></th>
                    <th>Tên bộ sưu tập</th>
                    <th>Tiêu chí</th>
                    <th style="width: 80px;">Số SP</th>
                    <th style="width: 80px;">Trạng thái</th>
                    <th style="width: 100px;">Thứ tự</th>
                    <th style="width: 120px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($collections as $c)
                <tr>
                    <td><span style="display:inline-block; width:18px; height:18px; border-radius:4px; background:{{ $c->accent_color }}; border:1px solid var(--admin-border);"></span></td>
                    <td>
                        <a href="{{ route('admin.product-collections.edit', $c) }}" style="font-weight: 600; color: inherit; text-decoration: none;">{{ $c->name }}</a>
                    </td>
                    <td style="color: var(--admin-text-muted);">{{ \Illuminate\Support\Str::limit($c->criterion, 60) }}</td>
                    <td>{{ $c->products_count }}</td>
                    <td>
                        @if($c->is_active)
                            <span style="color:#10b981; font-size:12px; font-weight:600;">● Hiển thị</span>
                        @else
                            <span style="color: var(--admin-text-muted); font-size:12px;">○ Ẩn</span>
                        @endif
                    </td>
                    <td>{{ $c->sort_order }}</td>
                    <td>
                        <a href="{{ route('admin.product-collections.edit', $c) }}" class="btn btn-secondary" style="padding: 6px 10px;">Sửa</a>
                        <form method="POST" action="{{ route('admin.product-collections.destroy', $c) }}" style="display: inline;" onsubmit="return confirm('Xóa bộ sưu tập này?');">
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
