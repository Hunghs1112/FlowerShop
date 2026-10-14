@extends('layouts.admin')

@section('page-title', 'Sửa Popup')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Sửa Popup: {{ $popup->title }}</h1>
        <p class="admin-page-subtitle">Cập nhật thông tin popup mùa lễ</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.popups.index') }}" class="btn btn-secondary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>
</div>

<form action="{{ route('admin.popups.update', $popup) }}" method="POST" class="admin-form">
    @csrf
    @method('PUT')

    <div class="admin-grid-2">
        {{-- Left Column --}}
        <div class="admin-column">
            {{-- Basic Info --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Thông Tin Cơ Bản</h3>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label for="id_key">Mã Popup <span class="required">*</span></label>
                        <input type="text" id="id_key" name="id_key" class="form-control" required
                               value="{{ old('id_key', $popup->id_key ?? '') }}"
                               placeholder="Ví dụ: 20-10, cay-thong, tet-2025">
                        <small class="form-text">Mã duy nhất, không trùng. Dùng cho URL preview.</small>
                        @error('id_key')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="title">Tiêu Đề <span class="required">*</span></label>
                        <input type="text" id="title" name="title" class="form-control" required
                               value="{{ old('title', $popup->title ?? '') }}"
                               placeholder="Ví dụ: Đặt trước cây thông Đan Mạch">
                        @error('title')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="theme">Theme</label>
                        <select id="theme" name="theme" class="form-control">
                            <option value="cream" {{ old('theme', $popup->theme ?? '') === 'cream' ? 'selected' : '' }}>Cream</option>
                            <option value="nordic" {{ old('theme', $popup->theme ?? '') === 'nordic' ? 'selected' : '' }}>Nordic (Giáng Sinh)</option>
                            <option value="rose" {{ old('theme', $popup->theme ?? '') === 'rose' ? 'selected' : '' }}>Rose (20/10)</option>
                            <option value="autumn" {{ old('theme', $popup->theme ?? '') === 'autumn' ? 'selected' : '' }}>Autumn (Mùa Thu)</option>
                            <option value="night" {{ old('theme', $popup->theme ?? '') === 'night' ? 'selected' : '' }}>Night</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_active" value="1"
                                   {{ old('is_active', $popup->is_active ?? false) ? 'checked' : '' }}>
                            Kích hoạt popup
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="sort_order">Thứ Tự Ưu Tiên</label>
                        <input type="number" id="sort_order" name="sort_order" class="form-control"
                               value="{{ old('sort_order', $popup->sort_order ?? 0) }}" min="0">
                        <small class="form-text">Số nhỏ hơn = ưu tiên cao hơn</small>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Nội Dung</h3>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label for="eyebrow">Eyebrow (Banner trên)</label>
                        <input type="text" id="eyebrow" name="eyebrow" class="form-control"
                               value="{{ old('eyebrow', $popup->eyebrow ?? '') }}"
                               placeholder="Ví dụ: 20/10 · NGÀY PHỤ NỮ VIỆT NAM">
                    </div>

                    <div class="form-group">
                        <label for="route">Route</label>
                        <input type="text" id="route" name="route" class="form-control"
                               value="{{ old('route', $popup->route ?? '') }}"
                               placeholder="Ví dụ: LNT → HAN">
                    </div>

                    <div class="form-group">
                        <label for="text">Mô Tả</label>
                        <textarea id="text" name="text" class="form-control" rows="3"
                                  placeholder="Mô tả ngắn về popup">{{ old('text', $popup->text ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Bullet Points</label>
                        @for($i = 0; $i < 4; $i++)
                            <input type="text" name="bullets[]" class="form-control"
                                   value="{{ old('bullets.' . $i, $popup->bullets[$i] ?? '') }}"
                                   placeholder="Bullet {{ $i + 1 }}">
                        @endfor
                    </div>

                    <div class="form-group">
                        <label for="note">Ghi Chú (Footer)</label>
                        <input type="text" id="note" name="note" class="form-control"
                               value="{{ old('note', $popup->note ?? '') }}"
                               placeholder="Ví dụ: Số lượng mỗi mẫu có hạn.">
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="admin-column">
            {{-- Dates --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Thời Gian Hiển Thị</h3>
                </div>
                <div class="admin-card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="start_date">Ngày Bắt Đầu <span class="required">*</span></label>
                            <input type="date" id="start_date" name="start_date" class="form-control" required
                                   value="{{ old('start_date', isset($popup) ? $popup->start_date->format('Y-m-d') : '') }}">
                            @error('start_date')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="end_date">Ngày Kết Thúc <span class="required">*</span></label>
                            <input type="date" id="end_date" name="end_date" class="form-control" required
                                   value="{{ old('end_date', isset($popup) ? $popup->end_date->format('Y-m-d') : '') }}">
                            @error('end_date')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="countdown">Ngày Đếm Ngược</label>
                            <input type="datetime-local" id="countdown" name="countdown" class="form-control"
                                   value="{{ old('countdown', $popup->countdown?->format('Y-m-d\TH:i') ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="countdown_label">Label Đếm Ngược</label>
                            <input type="text" id="countdown_label" name="countdown_label" class="form-control"
                                   value="{{ old('countdown_label', $popup->countdown_label ?? 'CÒN') }}"
                                   placeholder="CÒN hoặc ĐẾN GIÁNG SINH">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Image --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Hình Ảnh & Stamp</h3>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label for="image">URL Hình Ảnh</label>
                        <input type="url" id="image" name="image" class="form-control"
                               value="{{ old('image', $popup->image ?? '') }}"
                               placeholder="https://example.com/image.jpg">
                        <small class="form-text">Để trống sẽ hiển thị hình vẽ theo theme</small>
                    </div>

                    <div class="form-group">
                        <label for="image_alt">Alt Text</label>
                        <input type="text" id="image_alt" name="image_alt" class="form-control"
                               value="{{ old('image_alt', $popup->image_alt ?? '') }}">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="stamp">Stamp Text</label>
                            <input type="text" id="stamp" name="stamp" class="form-control"
                                   value="{{ old('stamp', $popup->stamp ?? '') }}"
                                   placeholder="20/10, XMAS, TET">
                        </div>
                        <div class="form-group">
                            <label for="stamp_sub">Stamp Subtitle</label>
                            <input type="text" id="stamp_sub" name="stamp_sub" class="form-control"
                                   value="{{ old('stamp_sub', $popup->stamp_sub ?? '') }}"
                                   placeholder="PRE-ORDER">
                        </div>
                    </div>
                </div>
            </div>

            {{-- CTA Buttons --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Nút Bấm</h3>
                </div>
                <div class="admin-card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cta_label">Nhãn Nút Chính</label>
                            <input type="text" id="cta_label" name="cta_label" class="form-control"
                                   value="{{ old('cta_label', $popup->cta_label ?? '') }}"
                                   placeholder="Đặt trước cây thông">
                        </div>
                        <div class="form-group">
                            <label for="cta_link">Link Nút Chính</label>
                            <input type="text" id="cta_link" name="cta_link" class="form-control"
                                   value="{{ old('cta_link', $popup->cta_link ?? '') }}"
                                   placeholder="/mua-le-hoi#thong">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cta2">Loại Nút Phụ</label>
                        <select id="cta2" name="cta2" class="form-control">
                            <option value="">Không hiển thị</option>
                            <option value="zalo" {{ old('cta2', $popup->cta2 ?? '') === 'zalo' ? 'selected' : '' }}>Zalo</option>
                            <option value="custom" {{ old('cta2', $popup->cta2 ?? '') === 'custom' ? 'selected' : '' }}>Tùy chỉnh</option>
                        </select>
                    </div>

                    <div class="form-row" id="custom-cta2" style="{{ old('cta2', $popup->cta2 ?? '') === 'custom' ? '' : 'display: none;' }}">
                        <div class="form-group">
                            <label for="cta2_label">Nhãn Nút Phụ</label>
                            <input type="text" id="cta2_label" name="cta2_label" class="form-control"
                                   value="{{ old('cta2_label', $popup->cta2_label ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="cta2_link">Link Nút Phụ</label>
                            <input type="text" id="cta2_link" name="cta2_link" class="form-control"
                                   value="{{ old('cta2_link', $popup->cta2_link ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Teaser --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Nút Nhắc Nhở</h3>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label for="teaser">Teaser Button</label>
                        <input type="text" id="teaser" name="teaser" class="form-control"
                               value="{{ old('teaser', $popup->teaser ?? '') }}"
                               placeholder="🎄 Đặt trước cây thông">
                        <small class="form-text">Nút hiện ở góc trái dưới sau khi đóng popup</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.popups.index') }}" class="btn btn-secondary">Hủy</a>
        <button type="submit" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Lưu Popup
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cta2Select = document.getElementById('cta2');
    const customCta2 = document.getElementById('custom-cta2');

    cta2Select.addEventListener('change', function() {
        customCta2.style.display = this.value === 'custom' ? '' : 'none';
    });
});
</script>
@endpush
