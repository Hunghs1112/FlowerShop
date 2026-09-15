@extends('layouts.admin')

@section('page-title', 'Thêm Trang')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Thêm Trang Mới</h1>
        <p class="admin-page-subtitle">Tạo trang mới cho website</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>
</div>

<form action="{{ route('admin.pages.store') }}" method="POST">
    @csrf
    @include('admin.pages.form')
</form>
@endsection
