@extends('layouts.admin')

@section('page-title', 'Tạo VIP Level')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Tạo VIP Level</h1>
        <p class="admin-page-subtitle">Thêm cấp độ VIP mới</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.vip-levels.index') }}" class="btn btn-outline">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay lại
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body">
        <form action="{{ route('admin.vip-levels.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label required">Tên VIP Level</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       class="form-input @error('name') form-input-error @enderror" 
                       placeholder="VIP 1, VIP 2, VIP 3..." 
                       required>
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Mô tả</label>
                <textarea id="description" 
                          name="description" 
                          rows="4" 
                          class="form-input form-textarea @error('description') form-input-error @enderror"
                          placeholder="Mô tả về cấp độ VIP này...">{{ old('description') }}</textarea>
                @error('description')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="priority" class="form-label required">Thứ tự ưu tiên</label>
                <input type="number" 
                       id="priority" 
                       name="priority" 
                       value="{{ old('priority', 0) }}" 
                       class="form-input @error('priority') form-input-error @enderror" 
                       min="0" 
                       required>
                <small class="form-help">Số càng nhỏ, thứ tự hiển thị càng cao (0 = cao nhất)</small>
                @error('priority')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <span>Hoạt động</span>
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Tạo VIP Level
                </button>
                <a href="{{ route('admin.vip-levels.index') }}" class="btn btn-outline">Hủy</a>
            </div>
        </form>
    </div>
</div>
@endsection
