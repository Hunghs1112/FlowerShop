@extends('layouts.admin')

@section('page-title', 'Sửa bộ sưu tập')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ route('admin.product-collections.index') }}" class="btn btn-secondary" style="padding: 8px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="admin-page-title">Sửa: {{ $productCollection->name }}</h1>
                <p class="admin-page-subtitle">Cập nhật thông tin và sản phẩm trong bộ</p>
            </div>
        </div>
    </div>
</div>

@include('admin.product-collections.form')
@endsection
