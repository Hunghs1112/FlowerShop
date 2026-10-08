@extends('layouts.admin')
@section('title', 'Quản lý Gallery WINDOW SEAT')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Gallery WINDOW SEAT</h1>
        <p class="admin-page-subtitle">Ảnh hiển thị tại phần "Những nơi tuyệt đẹp" trên trang chủ</p>
    </div>
    <a href="{{ route('admin.gallery-images.create') }}" class="btn btn-primary">+ Thêm ảnh</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width:80px">Ảnh</th>
                <th>Tiêu đề</th>
                <th>Chú thích</th>
                <th>Thứ tự</th>
                <th>Hiển thị</th>
                <th style="width:120px">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td><img src="{{ $item->image_url }}" alt="{{ $item->alt_text ?? $item->title }}" style="width:60px;height:45px;object-fit:cover;border-radius:6px;"></td>
                <td>{{ $item->title ?? '—' }}</td>
                <td>{{ Str::limit($item->caption, 60) ?? '—' }}</td>
                <td>{{ $item->sort_order }}</td>
                <td>
                    @if($item->is_active)
                        <span style="color:var(--color-success);font-weight:600;">Có</span>
                    @else
                        <span style="color:var(--color-text-light);">Không</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.gallery-images.edit', $item) }}" class="btn-icon" title="Sửa">✎</a>
                    <form action="{{ route('admin.gallery-images.destroy', $item) }}" method="POST" class="inline-form" onsubmit="return confirm('Xóa ảnh này?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-icon btn-icon--danger" title="Xóa">✕</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--color-text-light);">Chưa có ảnh nào. <a href="{{ route('admin.gallery-images.create') }}">Thêm ảnh đầu tiên</a></td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $items->withQueryString()->links('vendor.pagination.default') }}
@endsection
