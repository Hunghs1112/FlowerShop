@extends('layouts.admin')

@section('page-title', 'Nội dung Mystery Box')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Nội Dung Mystery Box</h1>
        <p class="admin-page-subtitle">Chỉnh sửa toàn bộ chữ hiển thị ở trang Hộp Hoa Bí Ẩn.</p>
    </div>
    <a href="{{ route('mystery-box.index') }}" target="_blank" class="btn btn-secondary">Xem trang</a>
</div>

@if(session('success'))
    <div class="alert alert-success" style="margin-bottom: 20px;">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger" style="margin-bottom: 20px;">{{ $errors->first() }}</div>
@endif

@php
    $text = fn ($key) => old($key, $content[$key] ?? '');
    $lines = fn ($key) => old($key . '_text', implode("\n", $content[$key] ?? []));
    $budgetLines = old('budgets_text', collect($content['budgets'] ?? [])->map(fn ($budget) => $budget['value'] . '|' . $budget['label'])->implode("\n"));
@endphp

<form method="POST" action="{{ route('admin.mystery-box-content.update') }}">
    @csrf
    @method('PUT')

    <div class="admin-card" style="margin-bottom: 20px;">
        <div class="admin-card-header"><h2 class="admin-card-title">Phần đầu trang</h2></div>
        <div class="admin-card-body" style="display:grid; gap:16px;">
            <div><label>Tiêu đề</label><input name="hero_title" value="{{ $text('hero_title') }}" style="width:100%;"></div>
            <div><label>Mô tả</label><textarea name="hero_description" rows="2" style="width:100%;">{{ $text('hero_description') }}</textarea></div>
            <div><label>Tiêu đề giới thiệu</label><input name="intro_title" value="{{ $text('intro_title') }}" style="width:100%;"></div>
            <div><label>Nội dung giới thiệu</label><textarea name="intro_description" rows="3" style="width:100%;">{{ $text('intro_description') }}</textarea></div>
        </div>
    </div>

    <div class="admin-card" style="margin-bottom: 20px;">
        <div class="admin-card-header"><h2 class="admin-card-title">Các bước và lựa chọn</h2></div>
        <div class="admin-card-body" style="display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:16px;">
            <div><label>Tên 7 bước (mỗi dòng một bước)</label><textarea name="step_labels_text" rows="7" style="width:100%;">{{ $lines('step_labels') }}</textarea></div>
            <div><label>Tiêu đề phong cách</label><input name="style_title" value="{{ $text('style_title') }}" style="width:100%;"><label style="margin-top:12px;">Phong cách (mỗi dòng một lựa chọn)</label><textarea name="styles_text" rows="5" style="width:100%;">{{ $lines('styles') }}</textarea></div>
            <div><label>Tiêu đề màu sắc</label><input name="color_title" value="{{ $text('color_title') }}" style="width:100%;"><label style="margin-top:12px;">Màu sắc (mỗi dòng một lựa chọn)</label><textarea name="colors_text" rows="7" style="width:100%;">{{ $lines('colors') }}</textarea></div>
            <div><label>Tiêu đề sở thích</label><input name="preference_title" value="{{ $text('preference_title') }}" style="width:100%;"><label style="margin-top:12px;">Sở thích (mỗi dòng một lựa chọn)</label><textarea name="preferences_text" rows="6" style="width:100%;">{{ $lines('preferences') }}</textarea></div>
            <div><label>Tiêu đề ngân sách</label><input name="budget_title" value="{{ $text('budget_title') }}" style="width:100%;"><label style="margin-top:12px;">Ngân sách: mã|chữ hiển thị (mỗi dòng)</label><textarea name="budgets_text" rows="4" style="width:100%;">{{ $budgetLines }}</textarea></div>
            <div><label>Tiêu đề mức độ bất ngờ</label><input name="surprise_title" value="{{ $text('surprise_title') }}" style="width:100%;"><label style="margin-top:12px;">Mức độ bất ngờ (mỗi dòng một lựa chọn)</label><textarea name="surprise_levels_text" rows="3" style="width:100%;">{{ $lines('surprise_levels') }}</textarea></div>
        </div>
    </div>

    <div class="admin-card" style="margin-bottom:20px;">
        <div class="admin-card-header"><h2 class="admin-card-title">Thông tin khách và xác nhận</h2></div>
        <div class="admin-card-body" style="display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:16px;">
            @foreach(['breadcrumb_home' => 'Nhãn breadcrumb trang chủ', 'breadcrumb_mystery' => 'Nhãn breadcrumb Mystery Box', 'note_title' => 'Tiêu đề ghi chú', 'name_label' => 'Nhãn họ tên', 'phone_label' => 'Nhãn số điện thoại', 'email_label' => 'Nhãn email', 'request_label' => 'Nhãn yêu cầu riêng', 'request_placeholder' => 'Gợi ý yêu cầu riêng', 'confirm_title' => 'Tiêu đề xác nhận', 'selected_info_title' => 'Tiêu đề thông tin đã chọn', 'style_summary_label' => 'Nhãn phong cách', 'color_summary_label' => 'Nhãn bảng màu', 'preference_summary_label' => 'Nhãn sở thích', 'budget_summary_label' => 'Nhãn ngân sách', 'surprise_summary_label' => 'Nhãn mức độ bất ngờ'] as $key => $label)
                <div><label>{{ $label }}</label><input name="{{ $key }}" value="{{ $text($key) }}" style="width:100%;"></div>
            @endforeach
            <div style="grid-column:1/-1;"><label>Lưu ý dưới phần xác nhận</label><textarea name="disclaimer" rows="3" style="width:100%;">{{ $text('disclaimer') }}</textarea></div>
        </div>
    </div>

    <div class="admin-card" style="margin-bottom:20px;">
        <div class="admin-card-header"><h2 class="admin-card-title">Trang gửi yêu cầu thành công</h2></div>
        <div class="admin-card-body" style="display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:16px;">
            @foreach(['success_page_title' => 'Tiêu đề header trang', 'success_page_description' => 'Mô tả header trang', 'success_title' => 'Tiêu đề thành công', 'success_request_id_label' => 'Nhãn mã yêu cầu', 'success_message' => 'Lời nhắn thành công', 'success_contact_message' => 'Lời nhắn liên hệ', 'success_summary_title' => 'Tiêu đề thông tin yêu cầu', 'success_style_label' => 'Nhãn phong cách', 'success_color_label' => 'Nhãn bảng màu', 'success_preference_label' => 'Nhãn sở thích', 'success_budget_label' => 'Nhãn ngân sách', 'success_surprise_label' => 'Nhãn mức độ bất ngờ', 'success_note_label' => 'Nhãn ghi chú', 'success_home_label' => 'Nhãn nút về trang chủ', 'previous_label' => 'Nhãn nút quay lại', 'next_label' => 'Nhãn nút tiếp theo', 'submit_label' => 'Nhãn nút xác nhận yêu cầu'] as $key => $label)
                <div><label>{{ $label }}</label><input name="{{ $key }}" value="{{ $text($key) }}" style="width:100%;"></div>
            @endforeach
        </div>
    </div>

    <button class="btn btn-primary" type="submit">Lưu nội dung Mystery Box</button>
</form>
@endsection
