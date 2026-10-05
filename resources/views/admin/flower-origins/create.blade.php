@extends('layouts.admin')
@section('title', 'Thêm loài hoa')
@section('content')
<div class="admin-page-header"><div class="admin-page-header-left"><h1 class="admin-page-title">Thêm loài hoa</h1></div><a href="{{ route('admin.flower-origins.index') }}" class="btn btn-secondary">Quay lại</a></div>
<form action="{{ route('admin.flower-origins.store') }}" method="POST" enctype="multipart/form-data">@csrf @include('admin.flower-origins.form')</form>
@endsection
