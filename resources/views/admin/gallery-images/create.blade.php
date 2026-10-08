@extends('layouts.admin')
@section('title', 'Thêm ảnh Gallery')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Thêm ảnh Gallery</h1>
        <a href="{{ route('admin.gallery-images.index') }}" class="admin-back-link">← Quay lại danh sách</a>
    </div>
</div>
<form action="{{ route('admin.gallery-images.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.gallery-images.form')
</form>
@endsection
