@extends('layouts.admin')

@section('page-title', 'Thêm Danh Mục Phụ')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Thêm Danh Mục Phụ</h1>
        <p class="admin-page-subtitle">Tạo danh mục phụ mới cho cửa hàng</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.catalog.index', ['tab' => 'subcategories']) }}" class="btn btn-secondary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>
</div>

<form action="{{ route('admin.subcategories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.subcategories.form', ['isEdit' => false])

    <div style="margin-top: 24px; display: flex; gap: 12px; justify-content: flex-end;">
        <a href="{{ route('admin.catalog.index', ['tab' => 'subcategories']) }}" class="btn btn-secondary">Hủy</a>
        <button type="submit" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Lưu Danh Mục Phụ
        </button>
    </div>
</form>
@endsection
