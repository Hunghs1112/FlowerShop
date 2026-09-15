@extends('layouts.admin')

@section('page-title', 'Liên Hệ')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Quản Lý Liên Hệ</h1>
        <p class="admin-page-subtitle">Xem và xử lý các liên hệ từ khách hàng</p>
    </div>
</div>

{{-- Filters --}}
<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-body" style="padding: 16px 24px;">
        <form method="GET" class="admin-filters">
            <select name="status" class="input-sm" onchange="this.form.submit()">
                <option value="">Tất cả trạng thái</option>
                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Mới</option>
                <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Đã liên hệ</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
            </select>
            @if(request('status'))
                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary btn-sm">Xóa lọc</a>
            @endif
        </form>
    </div>
</div>

{{-- Inquiries Table --}}
<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Khách Hàng</th>
                        <th>Liên Hệ</th>
                        <th style="width: 100px;">Sản Phẩm</th>
                        <th style="width: 180px;">Trạng Thái</th>
                        <th style="width: 140px;">Ngày</th>
                        <th style="width: 80px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $inquiry)
                        <tr>
                            <td><span class="text-mono">#{{ $inquiry->id }}</span></td>
                            <td>
                                <div style="font-weight: 600;">{{ $inquiry->name }}</div>
                                @if($inquiry->user)
                                    <span class="badge badge-secondary" style="margin-top: 4px;">Thành viên</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-mono" style="color: var(--admin-text-primary);">{{ $inquiry->phone }}</div>
                                @if($inquiry->zalo_id)
                                    <small style="color: var(--admin-text-muted);">Zalo: {{ $inquiry->zalo_id }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ count($inquiry->product_ids ?? []) }}</span>
                            </td>
                            <td>
                                <form action="{{ route('admin.inquiries.updateStatus', $inquiry) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="input-sm" onchange="this.form.submit()" style="width: auto; min-width: 140px;">
                                        <option value="new" {{ $inquiry->status == 'new' ? 'selected' : '' }}>Mới</option>
                                        <option value="contacted" {{ $inquiry->status == 'contacted' ? 'selected' : '' }}>Đã liên hệ</option>
                                        <option value="completed" {{ $inquiry->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                    </select>
                                </form>
                            </td>
                            <td class="text-mono" style="color: var(--admin-text-secondary);">{{ $inquiry->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn-icon" title="Xem chi tiết">
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
                                    <p>Không tìm thấy liên hệ nào</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($inquiries->hasPages())
        <div class="admin-card-footer" style="display: flex; justify-content: center; padding: 16px;">
            {{ $inquiries->links() }}
        </div>
    @endif
</div>
@endsection
