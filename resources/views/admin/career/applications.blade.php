@extends('layouts.admin')

@section('page-title', 'Hồ sơ ứng tuyển')

@section('content')
<div class="admin-page-header" style="margin-bottom:24px">
    <div class="admin-page-header-left"><h1 class="admin-page-title">Hồ sơ ứng tuyển</h1><p class="admin-page-subtitle">Các phiếu gửi từ trang tuyển dụng.</p></div>
    <div class="admin-page-actions"><a href="{{ route('admin.career.edit') }}" class="btn btn-secondary">Sửa nội dung trang</a></div>
</div>
<div class="admin-card" style="margin-bottom:24px"><div class="admin-card-body" style="padding:16px 24px">
    <form method="GET" class="admin-filters"><select name="status" class="input-sm" onchange="this.form.submit()"><option value="">Tất cả trạng thái</option>@foreach(['new'=>'Mới','contacted'=>'Đã liên hệ','completed'=>'Hoàn thành','cancelled'=>'Đã huỷ'] as $value=>$label)<option value="{{ $value }}" @selected(request('status')===$value)>{{ $label }}</option>@endforeach</select></form>
</div></div>
<div class="admin-card"><div class="admin-card-body" style="padding:0"><div class="admin-table-wrapper"><table class="admin-table">
    <thead><tr><th>Ứng viên</th><th>Vị trí</th><th>Năm sinh</th><th>CV</th><th>Lời nhắn</th><th>Trạng thái</th><th>Ngày gửi</th></tr></thead>
    <tbody>@forelse($applications as $application)<tr>
        <td><strong>{{ $application->name }}</strong><br><a href="tel:{{ $application->phone }}">{{ $application->phone }}</a><br><a href="mailto:{{ $application->email }}">{{ $application->email }}</a></td>
        <td>{{ data_get($application->order_data, 'position') }}</td>
        <td>{{ data_get($application->order_data, 'year', '—') ?: '—' }}</td>
        <td>@if(data_get($application->order_data, 'cv'))<a href="{{ data_get($application->order_data, 'cv') }}" target="_blank" rel="noopener">Mở CV ↗</a>@else — @endif</td>
        <td style="max-width:260px;white-space:normal">{{ $application->message ?: '—' }}</td>
        <td><form action="{{ route('admin.inquiries.updateStatus', $application) }}" method="POST">@csrf @method('PATCH')<select name="status" class="input-sm" onchange="this.form.submit()">@foreach(['new'=>'Mới','contacted'=>'Đã liên hệ','completed'=>'Hoàn thành','cancelled'=>'Đã huỷ'] as $value=>$label)<option value="{{ $value }}" @selected($application->status===$value)>{{ $label }}</option>@endforeach</select></form></td>
        <td>{{ $application->created_at->format('d/m/Y H:i') }}</td>
    </tr>@empty<tr><td colspan="7"><div class="empty-state-sm"><p>Chưa có hồ sơ ứng tuyển.</p></div></td></tr>@endforelse</tbody>
</table></div></div></div>
<div style="margin-top:20px">{{ $applications->links() }}</div>
@endsection
