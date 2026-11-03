@extends('layouts.admin')

@section('page-title', 'Đơn đăng ký B2B')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Đơn đăng ký B2B</h1>
        <p class="admin-page-subtitle">Thông tin doanh nghiệp gửi từ trang B2B.</p>
    </div>
</div>

<div class="admin-card" style="margin-bottom:24px">
    <div class="admin-card-body" style="padding:16px 24px">
        <form method="GET" class="admin-filters">
            <input type="search" name="search" value="{{ request('search') }}" class="input-sm" placeholder="Tên doanh nghiệp, người liên hệ, email, SĐT">
            <select name="status" class="input-sm">
                <option value="">Tất cả trạng thái</option>
                <option value="new" @selected(request('status') === 'new')>Mới</option>
                <option value="contacted" @selected(request('status') === 'contacted')>Đã liên hệ</option>
                <option value="completed" @selected(request('status') === 'completed')>Hoàn thành</option>
            </select>
            <button class="btn btn-secondary btn-sm">Lọc</button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.b2b-inquiries.index') }}" class="btn btn-secondary btn-sm">Xóa lọc</a>
            @endif
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body" style="padding:0">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead><tr><th>ID</th><th>Doanh nghiệp</th><th>Người liên hệ</th><th>Loại hình</th><th>Trạng thái</th><th>Ngày gửi</th><th></th></tr></thead>
                <tbody>
                @forelse($inquiries as $inquiry)
                    <tr>
                        <td class="text-mono">#{{ $inquiry->id }}</td>
                        <td><strong>{{ $inquiry->business_name }}</strong><br><small>{{ $inquiry->tax_code }}</small></td>
                        <td>{{ $inquiry->contact_name }}<br><a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a></td>
                        <td>{{ $inquiry->business_type_label }}</td>
                        <td>
                            <form action="{{ route('admin.b2b-inquiries.updateStatus', $inquiry) }}" method="POST">
                                @csrf @method('PATCH')
                                <select name="status" class="input-sm" onchange="this.form.submit()">
                                    @foreach(['new' => 'Mới', 'contacted' => 'Đã liên hệ', 'completed' => 'Hoàn thành'] as $value => $label)
                                        <option value="{{ $value }}" @selected($inquiry->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>{{ $inquiry->created_at->format('d/m/Y H:i') }}</td>
                        <td><a href="{{ route('admin.b2b-inquiries.show', $inquiry) }}" class="btn btn-secondary btn-sm">Chi tiết</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7"><div class="empty-state-sm"><p>Chưa có đơn đăng ký B2B.</p></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div style="margin-top:20px">{{ $inquiries->links() }}</div>
@endsection
