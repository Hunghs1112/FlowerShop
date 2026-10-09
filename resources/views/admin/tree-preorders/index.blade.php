@extends('layouts.admin')

@section('page-title', 'Đặt Trước Cây Thông')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Đặt Trước Cây Thông</h1>
        <p class="admin-page-subtitle">Quản lý đơn đặt trước cây thông và phụ kiện</p>
    </div>
</div>

{{-- Filters --}}
<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-body" style="padding: 16px 24px;">
        <form method="GET" class="admin-filters">
            <select name="status" class="input-sm" onchange="this.form.submit()">
                <option value="">Tất cả trạng thái</option>
                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>🆕 Mới</option>
                <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>📞 Đã liên hệ</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>✅ Hoàn thành</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Đã hủy</option>
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm tên, SĐT..." class="input-sm">
            <button type="submit" class="btn btn-secondary btn-sm">Tìm</button>
            @if(request('status') || request('search'))
                <a href="{{ route('admin.tree-preorders.index') }}" class="btn btn-secondary btn-sm">Xóa lọc</a>
            @endif
        </form>
    </div>
</div>

{{-- Stats --}}
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">
    <div class="admin-card">
        <div class="admin-card-body" style="text-align: center;">
            <div style="font-size: 32px; font-weight: 700; color: var(--admin-primary);">{{ $statusCounts['all'] }}</div>
            <div style="color: var(--admin-text-muted); font-size: 13px;">Tổng đơn</div>
        </div>
    </div>
    <div class="admin-card">
        <div class="admin-card-body" style="text-align: center;">
            <div style="font-size: 32px; font-weight: 700; color: #f59e0b;">{{ $statusCounts['new'] }}</div>
            <div style="color: var(--admin-text-muted); font-size: 13px;">Mới</div>
        </div>
    </div>
    <div class="admin-card">
        <div class="admin-card-body" style="text-align: center;">
            <div style="font-size: 32px; font-weight: 700; color: #3b82f6;">{{ $statusCounts['contacted'] }}</div>
            <div style="color: var(--admin-text-muted); font-size: 13px;">Đã liên hệ</div>
        </div>
    </div>
    <div class="admin-card">
        <div class="admin-card-body" style="text-align: center;">
            <div style="font-size: 32px; font-weight: 700; color: #22c55e;">{{ $statusCounts['completed'] }}</div>
            <div style="color: var(--admin-text-muted); font-size: 13px;">Hoàn thành</div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Khách Hàng</th>
                        <th>Cây Thông</th>
                        <th>Phụ Kiện</th>
                        <th style="width: 120px;">Trạng Thái</th>
                        <th style="width: 140px;">Ngày</th>
                        <th style="width: 80px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($preorders as $preorder)
                        <tr>
                            <td><span class="text-mono">#{{ $preorder->id }}</span></td>
                            <td>
                                <div style="font-weight: 600;">{{ $preorder->name }}</div>
                                <div class="text-mono" style="color: var(--admin-text-secondary); font-size: 13px;">{{ $preorder->phone }}</div>
                            </td>
                            <td>
                                @if($preorder->order_data)
                                    <span class="badge badge-primary">{{ $preorder->order_data['size'] ?? '-' }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($preorder->order_data && !empty($preorder->order_data['accessory_quantities']))
                                    {{ count($preorder->order_data['accessory_quantities']) }} phụ kiện
                                @elseif($preorder->order_data && !empty($preorder->order_data['accessories']))
                                    {{ count($preorder->order_data['accessories']) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.tree-preorders.updateStatus', $preorder) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="input-sm" onchange="this.form.submit()" style="width: auto; min-width: 120px;">
                                        <option value="new" {{ $preorder->status == 'new' ? 'selected' : '' }}>🆕 Mới</option>
                                        <option value="contacted" {{ $preorder->status == 'contacted' ? 'selected' : '' }}>📞 Đã liên hệ</option>
                                        <option value="completed" {{ $preorder->status == 'completed' ? 'selected' : '' }}>✅ Hoàn thành</option>
                                        <option value="cancelled" {{ $preorder->status == 'cancelled' ? 'selected' : '' }}>❌ Hủy</option>
                                    </select>
                                </form>
                            </td>
                            <td class="text-mono" style="color: var(--admin-text-secondary);">{{ $preorder->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.tree-preorders.show', $preorder) }}" class="btn-icon" title="Xem chi tiết">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state-sm">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p>Chưa có đơn đặt trước nào</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
