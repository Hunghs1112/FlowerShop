@extends('layouts.admin')
@section('title', 'Sửa ảnh Gallery')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Sửa ảnh Gallery</h1>
        <a href="{{ route('admin.gallery-images.index') }}" class="admin-back-link">← Quay lại danh sách</a>
    </div>
</div>
<form action="{{ route('admin.gallery-images.update', $item) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.gallery-images.form')
</form>
@endsection
