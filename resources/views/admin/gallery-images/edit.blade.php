@extends('layouts.admin')

@section('page-title', 'Sửa Ảnh Gallery')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Sửa Ảnh Gallery</h1>
        <p class="admin-page-subtitle">{{ $item->title ?? $item->alt_text }}</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.gallery-images.index') }}" class="btn btn-secondary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>
</div>

@include('admin.gallery-images.form', ['item' => $item])
@endsection
