@extends('layouts.admin')

@section('page-title', 'Sửa Bài Viết')

@section('content')
<div class="admin-content">
    <div class="admin-header">
        <h1 class="admin-title">Sửa Bài Viết</h1>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.posts.form')
    </form>
</div>
@endsection
