@extends('layouts.admin')

@section('page-title', 'Sửa Người Dùng')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Sửa Người Dùng</h1>
        <p class="admin-page-subtitle">
            <span style="display: inline-flex; align-items: center; gap: 6px;">
                <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></span>
                Tự động lưu đã bật
            </span>
        </p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>
</div>

<div id="user-form" data-entity="users" data-id="{{ $user->id }}">
    @include('admin.users.form', ['isEdit' => true])
</div>
@endsection

@push('scripts')
@endpush
