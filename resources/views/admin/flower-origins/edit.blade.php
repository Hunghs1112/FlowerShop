@extends('layouts.admin')
@section('title', 'Sửa loài hoa')
@section('content')
<div class="admin-page-header"><div class="admin-page-header-left"><h1 class="admin-page-title">Sửa loài hoa</h1></div><a href="{{ route('admin.flower-origins.index') }}" class="btn btn-secondary">Quay lại</a></div>
<form action="{{ route('admin.flower-origins.update', $item) }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT') @include('admin.flower-origins.form', ['item' => $item])</form>
@endsection
