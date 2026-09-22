@extends('layouts.admin')

@section('page-title', 'Mystery Box Requests')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Mystery Box Requests</h1>
        <p class="admin-page-subtitle">Quản lý các yêu cầu hộp hoa bí ẩn</p>
    </div>
</div>

{{-- Filters --}}
<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-body" style="padding: 16px 24px;">
        <form method="GET" class="admin-filters" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <select name="status" class="input-sm" onchange="this.form.submit()">
                <option value="">Tất cả trạng thái ({{ $statusCounts['all'] }})</option>
                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Mới ({{ $statusCounts['new'] }})</option>
                <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>Đang xem xét ({{ $statusCounts['reviewing'] }})</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận ({{ $statusCounts['confirmed'] }})</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành ({{ $statusCounts['completed'] }})</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy ({{ $statusCounts['cancelled'] }})</option>
            </select>

            <input type="text" name="search" placeholder="Tìm theo tên, SĐT, email, mã..." 
                   value="{{ request('search') }}" class="input-sm" style="min-width: 250px;">

            <input type="date" name="date_from" value="{{ request('date_from') }}" class="input-sm" placeholder="Từ ngày">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="input-sm" placeholder="Đến ngày">

            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
            
            @if(request()->hasAny(['status', 'search', 'date_from', 'date_to']))
                <a href="{{ route('admin.mystery-boxes.index') }}" class="btn btn-secondary btn-sm">Xóa lọc</a>
            @endif
        </form>
    </div>
</div>

{{-- Mystery Box Requests Table --}}
<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 120px;">Mã Yêu Cầu</th>
                        <th>Khách Hàng</th>
                        <th>Liên Hệ</th>
                        <th>Ngân Sách</th>
                        <th>Phong Cách</th>
                        <th style="width: 140px;">Ngày Tạo</th>
                        <th style="width: 160px;">Trạng Thái</th>
                        <th style="width: 80px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mysteryBoxRequests as $mbr)
                        <tr>
                            <td>
                                <span class="text-mono" style="font-weight: 600; color: var(--color-primary);">
                                    {{ $mbr->request_id }}
                                </span>
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $mbr->name }}</div>
                                @if($mbr->user)
                                    <span class="badge badge-secondary" style="margin-top: 4px;">Thành viên</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-mono" style="color: var(--color-text);">{{ $mbr->phone }}</div>
                                @if($mbr->email)
                                    <small style="color: var(--color-text-light);">{{ $mbr->email }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $mbr->budget_range }}</span>
                            </td>
                            <td>{{ $mbr->style }}</td>
                            <td class="text-mono" style="color: var(--color-text-light);">
                                {{ $mbr->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <form action="{{ route('admin.mystery-boxes.updateStatus', $mbr) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="input-sm" onchange="this.form.submit()" 
                                            style="width: auto; min-width: 140px;">
                                        <option value="new" {{ $mbr->status == 'new' ? 'selected' : '' }}>Mới</option>
                                        <option value="reviewing" {{ $mbr->status == 'reviewing' ? 'selected' : '' }}>Đang xem xét</option>
                                        <option value="confirmed" {{ $mbr->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                        <option value="completed" {{ $mbr->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                        <option value="cancelled" {{ $mbr->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('admin.mystery-boxes.show', $mbr) }}" class="btn-icon" title="Xem chi tiết">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state-sm">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p>Không tìm thấy yêu cầu nào</p>
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
