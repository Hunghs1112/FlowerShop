@extends('layouts.admin')

@section('page-title', 'Dịch dữ liệu sang tiếng Anh')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Dịch dữ liệu sang tiếng Anh</h1>
        <p class="admin-page-subtitle">Dịch các trường tiếng Anh còn trống bằng LibreTranslate. Có thể chạy lại sau khi thêm dữ liệu mới.</p>
    </div>
</div>

@if(session()->has('backfill_output'))
    <div class="admin-card" style="margin-bottom: 24px;">
        <div class="admin-card-body">
            <h2>{{ session('backfill_success') ? 'Đã chạy xong' : 'Có một số bản dịch chưa hoàn tất' }}</h2>
            <pre style="white-space: pre-wrap; margin: 12px 0 0;">{{ session('backfill_output') }}</pre>
        </div>
    </div>
@endif

<div class="admin-card">
    <div class="admin-card-body">
        <p>Tiếng Việt hiện có được giữ nguyên. Các bản dịch tiếng Anh đã có sẽ không bị ghi đè.</p>
        <form method="POST" action="{{ route('admin.translations.backfill') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Dịch dữ liệu còn thiếu</button>
        </form>
    </div>
</div>
@endsection
