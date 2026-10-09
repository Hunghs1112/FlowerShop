@extends('layouts.admin')

@section('page-title', 'Chi Tiết Đặt Trước')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Đặt Trước #{{ $inquiry->id }}</h1>
        <p class="admin-page-subtitle">
            @if($inquiry->source_slug)
                Nguồn: {{ $inquiry->source_slug }}
            @endif
            · Ngày tạo: {{ $inquiry->created_at->format('d/m/Y H:i') }}
        </p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.tree-preorders.index') }}" class="btn btn-secondary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 380px; gap: 24px;">
    {{-- Main Content --}}
    <div style="display: flex; flex-direction: column; gap: 24px;">
        {{-- Tree Order Details --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    Chi Tiết Đơn Đặt
                </h2>
            </div>
            <div class="admin-card-body">
                @if($inquiry->order_data)
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                        {{-- Size --}}
                        <div>
                            <div style="font-size: 12px; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Cỡ Cây</div>
                            <div style="font-weight: 700; font-size: 20px; color: var(--admin-primary);">{{ $inquiry->order_data['size'] ?? '-' }}</div>
                        </div>

                        {{-- Address --}}
                        <div>
                            <div style="font-size: 12px; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Địa Chỉ Giao</div>
                            <div style="font-weight: 600;">{{ $inquiry->order_data['address'] ?? '-' }}</div>
                        </div>

                        {{-- Delivery Date --}}
                        <div>
                            <div style="font-size: 12px; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Ngày Nhận Mong Muốn</div>
                            <div style="font-weight: 600;">
                                @if($inquiry->order_data['delivery_date'])
                                    {{ \Carbon\Carbon::parse($inquiry->order_data['delivery_date'])->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        {{-- Addons --}}
                        <div>
                            <div style="font-size: 12px; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Dịch Vụ Đi Kèm</div>
                            <div>
                                @if(!empty($inquiry->order_data['addons']))
                                    @foreach($inquiry->order_data['addons'] as $addon)
                                        <span class="badge badge-secondary" style="margin-right: 4px; margin-bottom: 4px;">{{ $addon }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Notes --}}
                    @if(!empty($inquiry->order_data['notes']))
                        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--admin-border);">
                            <div style="font-size: 12px; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Ghi Chú</div>
                            <div style="background: var(--admin-bg-content); padding: 16px; border-radius: var(--admin-radius-md); font-size: 14px; line-height: 1.6;">
                                {{ $inquiry->order_data['notes'] }}
                            </div>
                        </div>
                    @endif
                @else
                    <div style="text-align: center; color: var(--admin-text-muted); padding: 40px;">
                        Không có dữ liệu đơn đặt
                    </div>
                @endif
            </div>
        </div>

        {{-- Accessories --}}
        @if($inquiry->order_data && (!empty($inquiry->order_data['accessories']) || !empty($inquiry->order_data['accessory_quantities'])))
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">
                        <div class="admin-card-title-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        Phụ Kiện & Đồ Trang Trí
                    </h2>
                </div>
                <div class="admin-card-body">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Tên Phụ Kiện</th>
                                <th style="width: 100px; text-align: center;">Số Lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($inquiry->order_data['accessory_quantities']))
                                @foreach($inquiry->order_data['accessory_quantities'] as $item)
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td style="text-align: center;"><span class="badge badge-primary">×{{ $item['quantity'] }}</span></td>
                                    </tr>
                                @endforeach
                            @elseif(!empty($inquiry->order_data['accessories']))
                                @foreach($inquiry->order_data['accessories'] as $accessory)
                                    <tr>
                                        <td>{{ $accessory }}</td>
                                        <td style="text-align: center;">1</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div style="display: flex; flex-direction: column; gap: 24px;">
        {{-- Status --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    Trạng Thái
                </h2>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.tree-preorders.updateStatus', $inquiry) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group" style="margin-bottom: 16px;">
                        <select name="status" class="input-sm" style="width: 100%;">
                            <option value="new" {{ $inquiry->status == 'new' ? 'selected' : '' }}>🆕 Mới</option>
                            <option value="contacted" {{ $inquiry->status == 'contacted' ? 'selected' : '' }}>📞 Đã liên hệ</option>
                            <option value="completed" {{ $inquiry->status == 'completed' ? 'selected' : '' }}>✅ Hoàn thành</option>
                            <option value="cancelled" {{ $inquiry->status == 'cancelled' ? 'selected' : '' }}>❌ Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Cập Nhật
                    </button>
                </form>
            </div>
        </div>

        {{-- Customer Info --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <div class="admin-card-title-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    Thông Tin Khách Hàng
                </h2>
            </div>
            <div class="admin-card-body">
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <div style="font-size: 12px; color: var(--admin-text-muted); margin-bottom: 4px;">Tên</div>
                        <div style="font-weight: 600;">{{ $inquiry->name }}</div>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: var(--admin-text-muted); margin-bottom: 4px;">Số Điện Thoại</div>
                        <div style="font-weight: 600; font-family: var(--admin-font-mono);">
                            <a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a>
                        </div>
                    </div>
                    <div>
                        <a href="https://zalo.me/{{ $inquiry->phone }}" target="_blank" class="btn btn-secondary" style="width: 100%;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                            </svg>
                            Nhắn Zalo
                        </a>
                    </div>
                    @if($inquiry->user)
                        <div style="margin-top: 8px;">
                            <span class="badge badge-info">Thành viên</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Message --}}
        @if($inquiry->message)
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">
                        <div class="admin-card-title-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        Tin Nhắn Gốc
                    </h2>
                </div>
                <div class="admin-card-body">
                    <div style="background: var(--admin-bg-content); padding: 16px; border-radius: var(--admin-radius-md); font-size: 13px; line-height: 1.6; white-space: pre-wrap;">{{ $inquiry->message }}</div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
