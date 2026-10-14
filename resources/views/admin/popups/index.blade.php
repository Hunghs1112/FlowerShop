@extends('layouts.admin')

@section('page-title', 'Quản Lý Popup')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Quản Lý Popup Mùa Lễ</h1>
        <p class="admin-page-subtitle">Cấu hình popup hiển thị theo mùa lễ (20/10, Giáng Sinh, Tết...)</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.popups.create') }}" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Thêm Popup Mới
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="admin-card" style="margin-bottom: 24px;">
    <div class="admin-card-body" style="padding: 16px 24px;">
        <form method="GET" class="admin-filters">
            <input type="text" name="search" placeholder="Tìm kiếm popup..."
                   value="{{ request('search') }}" class="input-sm">
            <select name="status" class="input-sm">
                <option value="">Tất cả trạng thái</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
            @if(request()->has('search') || request()->has('status'))
                <a href="{{ route('admin.popups.index') }}" class="btn btn-secondary btn-sm">Xóa lọc</a>
            @endif
        </form>
    </div>
</div>

{{-- Popup List --}}
<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Mã</th>
                        <th>Tiêu Đề</th>
                        <th style="width: 120px;">Theme</th>
                        <th style="width: 150px;">Thời Gian</th>
                        <th style="width: 100px;">Trạng Thái</th>
                        <th style="width: 140px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($popups as $popup)
                        <tr>
                            <td>
                                <span class="text-mono text-muted">{{ $popup->sort_order }}</span>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $popup->id_key }}</span>
                            </td>
                            <td>
                                <div class="table-product-name">{{ $popup->title }}</div>
                                @if($popup->is_active)
                                    <small class="text-muted">
                                        {{ $popup->start_date->format('d/m/Y') }} - {{ $popup->end_date->format('d/m/Y') }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $popup->theme }}</span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $popup->start_date->format('d/m/Y') }}<br>
                                    {{ $popup->end_date->format('d/m/Y') }}
                                </small>
                            </td>
                            <td>
                                <button type="button"
                                        class="btn-toggle-status {{ $popup->is_active ? 'active' : '' }}"
                                        data-id="{{ $popup->id }}"
                                        data-status="{{ $popup->is_active ? '1' : '0' }}"
                                        title="{{ $popup->is_active ? 'Đang kích hoạt - Click để tắt' : 'Đang tắt - Click để bật' }}">
                                    <span class="toggle-track">
                                        <span class="toggle-thumb"></span>
                                    </span>
                                    <span class="toggle-label">{{ $popup->is_active ? 'Bật' : 'Tắt' }}</span>
                                </button>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.popups.edit', $popup) }}" class="btn-icon" title="Sửa">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.popups.destroy', $popup) }}" method="POST" class="inline-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-danger" title="Xóa"
                                                onclick="return confirm('Bạn có chắc muốn xóa popup này?\n\nHành động này không thể hoàn tác.')">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                                    </svg>
                                    <p>Chưa có popup nào. Tạo popup đầu tiên!</p>
                                    <a href="{{ route('admin.popups.create') }}" class="btn btn-primary btn-sm">Thêm Popup</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($popups->hasPages())
    <div class="admin-card-footer">
        {{ $popups->links() }}
    </div>
    @endif
</div>

<style>
.btn-toggle-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 4px 12px;
    border: 1px solid var(--admin-border);
    border-radius: 20px;
    background: var(--admin-bg-content);
    cursor: pointer;
    font-size: 12px;
    color: var(--admin-text-secondary);
    transition: all 0.2s;
}
.btn-toggle-status:hover {
    border-color: var(--admin-primary);
}
.btn-toggle-status.active {
    background: rgba(34, 197, 94, 0.1);
    border-color: #22c55e;
    color: #22c55e;
}
.toggle-track {
    width: 32px;
    height: 18px;
    background: var(--admin-border);
    border-radius: 9px;
    position: relative;
    transition: background 0.2s;
}
.btn-toggle-status.active .toggle-track {
    background: #22c55e;
}
.toggle-thumb {
    position: absolute;
    top: 2px;
    left: 2px;
    width: 14px;
    height: 14px;
    background: white;
    border-radius: 50%;
    transition: left 0.2s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}
.btn-toggle-status.active .toggle-thumb {
    left: 16px;
}
.toggle-label {
    font-weight: 500;
}
</style>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-toggle-status').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const currentStatus = this.dataset.status === '1';

            fetch('/admin/popups/' + id + '/toggle', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const newStatus = data.is_active;
                    this.dataset.status = newStatus ? '1' : '0';
                    this.classList.toggle('active', newStatus);
                    this.querySelector('.toggle-label').textContent = newStatus ? 'Bật' : 'Tắt';
                }
            })
            .catch(err => console.error('Error:', err));
        });
    });
});
</script>
@endpush
