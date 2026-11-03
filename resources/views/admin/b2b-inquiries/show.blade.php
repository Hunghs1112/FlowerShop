@extends('layouts.admin')

@section('page-title', 'Chi tiết đơn B2B')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Đơn B2B #{{ $b2bInquiry->id }}</h1>
        <p class="admin-page-subtitle">Gửi lúc {{ $b2bInquiry->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <div class="admin-page-actions"><a href="{{ route('admin.b2b-inquiries.index') }}" class="btn btn-secondary">Quay lại</a></div>
</div>

<div style="display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:24px">
    <div class="admin-card">
        <div class="admin-card-header"><h2 class="admin-card-title">Thông tin đăng ký</h2></div>
        <div class="admin-card-body" style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px">
            @foreach([
                'Doanh nghiệp' => $b2bInquiry->business_name,
                'Loại hình' => $b2bInquiry->business_type_label,
                'Người liên hệ' => $b2bInquiry->contact_name,
                'Điện thoại' => $b2bInquiry->phone,
                'Email liên hệ' => $b2bInquiry->contact_email ?: '—',
                'Địa chỉ' => $b2bInquiry->address,
                'Số năm hoạt động' => $b2bInquiry->years_in_business,
                'Mạng xã hội' => $b2bInquiry->social_media,
                'Mã số thuế' => $b2bInquiry->tax_code,
                'Email VAT' => $b2bInquiry->vat_email,
                'Giấy phép kinh doanh' => $b2bInquiry->business_license,
            ] as $label => $value)
                <div><div style="font-size:12px;color:var(--admin-text-muted);margin-bottom:4px">{{ $label }}</div><div style="font-weight:600;overflow-wrap:anywhere">{{ $value }}</div></div>
            @endforeach
        </div>
    </div>

    <div class="admin-card" style="align-self:start">
        <div class="admin-card-header"><h2 class="admin-card-title">Trạng thái</h2></div>
        <div class="admin-card-body">
            <form action="{{ route('admin.b2b-inquiries.updateStatus', $b2bInquiry) }}" method="POST">
                @csrf @method('PATCH')
                <select name="status" style="width:100%;margin-bottom:12px">
                    @foreach(['new' => 'Mới', 'contacted' => 'Đã liên hệ', 'completed' => 'Hoàn thành'] as $value => $label)
                        <option value="{{ $value }}" @selected($b2bInquiry->status === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary" style="width:100%">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection
