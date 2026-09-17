@extends('layouts.admin')

@section('page-title', 'Sửa Danh Mục')

@section('content')
<div class="admin-content">
    <div class="admin-header" style="margin-bottom: 32px;">
        <div>
            <h1 class="admin-title">Sửa Danh Mục</h1>
            <p style="color: var(--admin-text-secondary); font-size: 14px; margin-top: 4px;">
                <span style="display: inline-flex; align-items: center; gap: 6px;">
                    <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></span>
                    Tự động lưu đã bật
                </span>
            </p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>

    <div id="category-form" data-entity="categories" data-id="{{ $category->id }}">
        @include('admin.categories.form', ['isEdit' => true])
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin-auto-save.js') }}"></script>
@endpush
