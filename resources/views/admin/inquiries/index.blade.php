@extends('layouts.admin')

@section('page-title', 'Liên Hệ')

@section('content')
<div class="admin-content">
    <div class="admin-header">
        <h1 class="admin-title">Quản Lý Liên Hệ</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="admin-card">
        <div class="admin-card-header">
            <form method="GET" class="admin-filters">
                <select name="status" class="input-sm" onchange="this.form.submit()">
                    <option value="">Tất cả trạng thái</option>
                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Mới</option>
                    <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Đã liên hệ</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                </select>
            </form>
        </div>
        <div class="admin-card-body">
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Khách Hàng</th>
                            <th>Liên Hệ</th>
                            <th>Sản Phẩm</th>
                            <th>Trạng Thái</th>
                            <th>Ngày</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inquiries as $inquiry)
                            <tr>
                                <td><span class="text-mono">#{{ $inquiry->id }}</span></td>
                                <td>
                                    <div class="table-user-name">{{ $inquiry->name }}</div>
                                    @if($inquiry->user)
                                        <span class="badge badge-sm badge-secondary">Thành viên</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $inquiry->phone }}</div>
                                    @if($inquiry->zalo_id)
                                        <small class="text-secondary">Zalo: {{ $inquiry->zalo_id }}</small>
                                    @endif
                                </td>
                                <td>{{ count($inquiry->product_ids ?? []) }} sản phẩm</td>
                                <td>
                                    <form action="{{ route('admin.inquiries.updateStatus', $inquiry) }}" method="POST" class="status-form">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="badge-select badge-{{ $inquiry->status }}" onchange="this.form.submit()">
                                            <option value="new" {{ $inquiry->status == 'new' ? 'selected' : '' }}>Mới</option>
                                            <option value="contacted" {{ $inquiry->status == 'contacted' ? 'selected' : '' }}>Đã liên hệ</option>
                                            <option value="completed" {{ $inquiry->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                        </select>
                                    </form>
                                </td>
                                <td>{{ $inquiry->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn-icon" title="Xem">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-secondary">Không tìm thấy liên hệ nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($inquiries->hasPages())
            <div class="admin-card-footer">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .table-user-name {
        font-weight: var(--font-semibold);
        margin-bottom: var(--space-1);
    }
    
    .badge-sm {
        font-size: var(--font-size-xs);
        padding: 2px var(--space-2);
    }
    
    .status-form {
        display: inline;
    }
    
    .badge-select {
        padding: var(--space-1) var(--space-2);
        border: none;
        border-radius: var(--radius-sm);
        font-size: var(--font-size-xs);
        font-weight: var(--font-semibold);
        cursor: pointer;
        color: white;
    }
    
    .badge-select.badge-new {
        background-color: var(--color-accent-cool);
    }
    
    .badge-select.badge-contacted {
        background-color: var(--color-accent-warm);
    }
    
    .badge-select.badge-completed {
        background-color: var(--color-success);
    }
</style>
@endpush
@endsection
