@extends('layouts.admin')

@section('page-title', 'Import Sản Phẩm')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Import Sản Phẩm Từ CSV</h1>
        <p class="admin-page-subtitle">Nhập sản phẩm hàng loạt từ file CSV</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.products.template') }}" class="btn btn-secondary" target="_blank">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Tải Template
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-error" style="margin-bottom: 24px;">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <strong>Có lỗi xảy ra:</strong>
            <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error" style="margin-bottom: 24px;">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <strong>Lỗi:</strong>
            <p style="margin: 8px 0 0 0;">{{ session('error') }}</p>
        </div>
    </div>
@endif

<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">
            <div class="admin-card-title-icon">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
            </div>
            Upload File CSV
        </h2>
    </div>
    <div class="admin-card-body">
        <form action="{{ route('admin.products.processImport') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 6px;">
                    Chọn File CSV <span style="color: var(--admin-error);">*</span>
                </label>
                <input type="file" name="file" accept=".csv"
                       style="width: 100%; height: 56px; padding: 12px 16px; border: 2px dashed var(--admin-border); border-radius: var(--admin-radius-md); font-size: 14px; cursor: pointer;">
                <small style="display: block; margin-top: 8px; color: var(--admin-text-muted);">
                    Định dạng hỗ trợ: .xlsx, .xls, .csv
                </small>
            </div>

            <div style="padding: 16px; background: var(--admin-bg-secondary); border-radius: var(--admin-radius-md); margin-bottom: 24px;">
                <h4 style="font-size: 14px; font-weight: 600; color: var(--admin-text-primary); margin-bottom: 12px;">
                    Cấu trúc file CSV:
                </h4>
                <div style="font-size: 13px; color: var(--admin-text-secondary); line-height: 1.8;">
                    <p><strong>Các trường bắt buộc:</strong></p>
                    <ul style="margin-left: 20px; margin-bottom: 12px;">
                        <li>ten_san_pham - Tên sản phẩm</li>
                        <li>danh_muc - Tên danh mục con (subcategory)</li>
                        <li>gia - Giá sản phẩm</li>
                        <li>ton_kho - Số lượng tồn kho</li>
                    </ul>
                    <p><strong>Các trường tùy chọn:</strong></p>
                    <ul style="margin-left: 20px;">
                        <li>slug - Đường dẫn SEO (để trống sẽ tự tạo)</li>
                        <li>sku - Mã sản phẩm</li>
                        <li>mo_ta_ngan - Mô tả ngắn</li>
                        <li>mo_ta - Mô tả chi tiết</li>
                        <li>chieu_dai - Chiều dài (VD: 50cm)</li>
                        <li>sl_toi_thieu - Số lượng order tối thiểu</li>
                        <li>xuat_xu - Xuất xứ (VD: Việt Nam)</li>
                        <li>quy_cach - Quy cách (VD: Bó 10 bông)</li>
                        <li>don_vi - Đơn vị tính (VD: bông, chiếc, chai, thùng)</li>
                    </ul>
                </div>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn btn-primary" style="height: 48px; padding: 0 32px;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Import Sản Phẩm
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary" style="height: 48px; padding: 0 24px;">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</div>

<div class="admin-card" style="margin-top: 24px;">
    <div class="admin-card-header">
        <h2 class="admin-card-title">
            <div class="admin-card-title-icon">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            Lưu Ý
        </h2>
    </div>
    <div class="admin-card-body">
        <ul style="font-size: 13px; color: var(--admin-text-secondary); line-height: 1.8; margin: 0; padding-left: 20px;">
            <li>Tên danh mục (danh_muc) phải khớp chính xác với tên danh mục con trong hệ thống</li>
            <li>Sản phẩm trùng lặp (theo slug) sẽ được thêm hậu tố thời gian</li>
            <li>Sản phẩm import sẽ được kích hoạt mặc định</li>
            <li>Ảnh sản phẩm cần upload riêng sau khi import</li>
        </ul>
    </div>
</div>
@endsection
