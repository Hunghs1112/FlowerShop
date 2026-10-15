@php
    $editing = isset($popup) && $popup;
    $value = fn (string $key, $default = '') => old($key, $editing ? ($popup->{$key} ?? $default) : $default);
    $startDate = old('start_date', $editing ? $popup->start_date?->format('Y-m-d') : '');
    $endDate = old('end_date', $editing ? $popup->end_date?->format('Y-m-d') : '');
    $countdown = old('countdown', $editing ? $popup->countdown?->format('Y-m-d\TH:i') : '');
    $bullets = old('bullets', $editing ? ($popup->bullets ?? []) : []);
    $popupDelay = old('popup_delay', $popupSettings['delay']);
    $popupFrequency = old('popup_frequency', $popupSettings['frequency']);
    $popupZalo = old('popup_zalo', $popupSettings['zalo']);
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/popup-builder.css') }}">
@endpush

<div class="popup-builder-head">
    <div>
        <span>LÂM NHIÊN THẢO</span>
        <h1>{{ $editing ? 'Sửa popup mùa lễ' : 'Tạo popup mùa lễ' }}</h1>
    </div>
    <div class="popup-builder-actions">
        <a href="{{ route('admin.popups.index') }}" class="popup-button popup-button-ghost">Quay lại</a>
        <button type="button" class="popup-button popup-button-ghost" id="preview-popup-button">Xem dạng popup ▸</button>
        <button type="submit" form="popup-form" class="popup-button">{{ $editing ? 'Lưu thay đổi' : 'Tạo popup' }}</button>
    </div>
</div>

<form action="{{ $formAction }}" method="POST" id="popup-form" class="popup-builder">
    @csrf
    @if($formMethod !== 'POST')
        @method($formMethod)
    @endif

    <aside class="popup-builder-form" aria-label="Soạn nội dung popup">
        <section class="popup-box">
            <h2>CÀI ĐẶT CHUNG</h2>
            <div class="popup-two">
                <label class="popup-field">
                    <span>Hiện popup sau <small>giây</small></span>
                    <input type="number" name="popup_delay" value="{{ $popupDelay }}" min="0" max="60" required>
                    @error('popup_delay') <em>{{ $message }}</em> @enderror
                </label>
                <label class="popup-field">
                    <span>Tần suất hiện lại</span>
                    <select name="popup_frequency" required>
                        <option value="day" @selected($popupFrequency === 'day')>Mỗi ngày 1 lần</option>
                        <option value="session" @selected($popupFrequency === 'session')>Mỗi lượt truy cập</option>
                        <option value="once" @selected($popupFrequency === 'once')>Chỉ 1 lần</option>
                        <option value="always" @selected($popupFrequency === 'always')>Mỗi lần tải trang</option>
                    </select>
                    @error('popup_frequency') <em>{{ $message }}</em> @enderror
                </label>
            </div>
            <label class="popup-field">
                <span>Số Zalo <small>dùng cho nút “Tư vấn qua Zalo”</small></span>
                <input type="tel" name="popup_zalo" value="{{ $popupZalo }}" placeholder="0869308993" inputmode="tel">
                @error('popup_zalo') <em>{{ $message }}</em> @enderror
            </label>
            <p class="popup-help">Cấu hình này áp dụng cho tất cả popup và được lưu cùng lần bấm “{{ $editing ? 'Lưu thay đổi' : 'Tạo popup' }}”.</p>
        </section>

        <section class="popup-box">
            <h2>CẤU HÌNH ĐỢT LỄ</h2>
            <label class="popup-check">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $editing ? $popup->is_active : false) ? 'checked' : '' }}>
                Bật đợt này
            </label>
            <div class="popup-two">
                <label class="popup-field">
                    <span>Hiện từ ngày <b>*</b></span>
                    <input type="date" name="start_date" value="{{ $startDate }}" required>
                    @error('start_date') <em>{{ $message }}</em> @enderror
                </label>
                <label class="popup-field">
                    <span>Đến hết ngày <b>*</b></span>
                    <input type="date" name="end_date" value="{{ $endDate }}" required>
                    @error('end_date') <em>{{ $message }}</em> @enderror
                </label>
            </div>
            <label class="popup-field">
                <span>Mã đợt <small>dùng cho link xem thử ?popup=mã</small></span>
                <input type="text" name="id_key" value="{{ $value('id_key') }}" placeholder="cay-thong-2026" maxlength="50" required>
                @error('id_key') <em>{{ $message }}</em> @enderror
            </label>
            <div class="popup-two">
                <label class="popup-field">
                    <span>Tông màu</span>
                    <select name="theme">
                        <option value="rose" @selected($value('theme', 'cream') === 'rose')>Hồng (20/10, 8/3, Valentine)</option>
                        <option value="nordic" @selected($value('theme', 'cream') === 'nordic')>Xanh thông (Giáng sinh)</option>
                        <option value="autumn" @selected($value('theme', 'cream') === 'autumn')>Cam thu (Trung thu, mùa thu)</option>
                        <option value="night" @selected($value('theme', 'cream') === 'night')>Đêm (Halloween)</option>
                        <option value="cream" @selected($value('theme', 'cream') === 'cream')>Kem đồng (mặc định LNT)</option>
                    </select>
                </label>
                <label class="popup-field">
                    <span>Thứ tự ưu tiên <small>số nhỏ hiện trước</small></span>
                    <input type="number" name="sort_order" value="{{ $value('sort_order', 0) }}" min="0">
                </label>
            </div>
        </section>

        <section class="popup-box">
            <h2>NỘI DUNG</h2>
            <div class="popup-two">
                <label class="popup-field">
                    <span>Dòng trên dải tiêu đề</span>
                    <input type="text" name="eyebrow" value="{{ $value('eyebrow') }}" placeholder="MỞ ĐẶT TRƯỚC">
                </label>
                <label class="popup-field">
                    <span>Mã chuyến <small>VD: CPH → HAN</small></span>
                    <input type="text" name="route" value="{{ $value('route') }}" placeholder="LNT → HAN">
                </label>
            </div>
            <label class="popup-field">
                <span>Tiêu đề <b>*</b></span>
                <input type="text" name="title" value="{{ $value('title') }}" placeholder="Đặt trước cây thông Đan Mạch" required>
                @error('title') <em>{{ $message }}</em> @enderror
            </label>
            <label class="popup-field">
                <span>Mô tả</span>
                <textarea name="text" rows="3" placeholder="Mô tả ngắn về chương trình">{{ $value('text') }}</textarea>
            </label>
            <label class="popup-field">
                <span>Các ý chính <small>mỗi dòng 1 ý</small></span>
                <textarea id="popup-bullets" rows="4" placeholder="Cây tuyển chọn trực tiếp&#10;Giao tận nơi tại Hà Nội">{{ implode("\n", array_filter($bullets)) }}</textarea>
            </label>
            <div id="popup-bullet-inputs"></div>
            <div class="popup-two">
                <label class="popup-field">
                    <span>Đếm ngược đến</span>
                    <input type="datetime-local" name="countdown" value="{{ $countdown }}">
                </label>
                <label class="popup-field">
                    <span>Chữ trước đồng hồ</span>
                    <input type="text" name="countdown_label" value="{{ $value('countdown_label', 'CÒN') }}" placeholder="CÒN">
                </label>
            </div>
        </section>

        <section class="popup-box">
            <h2>HÌNH ẢNH & CON DẤU</h2>
            <label class="popup-field">
                <span>Link ảnh</span>
                <input type="url" name="image" value="{{ $value('image') }}" placeholder="https://...">
                <small>Để trống để dùng hình vẽ theo tông màu.</small>
            </label>
            <label class="popup-field">
                <span>Mô tả ảnh <small>dành cho trình đọc màn hình</small></span>
                <input type="text" name="image_alt" value="{{ $value('image_alt') }}">
            </label>
            <div class="popup-two">
                <label class="popup-field">
                    <span>Con dấu – chữ lớn</span>
                    <input type="text" name="stamp" value="{{ $value('stamp') }}" placeholder="XMAS">
                </label>
                <label class="popup-field">
                    <span>Con dấu – chữ nhỏ</span>
                    <input type="text" name="stamp_sub" value="{{ $value('stamp_sub') }}" placeholder="PRE-ORDER">
                </label>
            </div>
        </section>

        <section class="popup-box">
            <h2>NÚT BẤM</h2>
            <div class="popup-two">
                <label class="popup-field">
                    <span>Nút chính</span>
                    <input type="text" name="cta_label" value="{{ $value('cta_label') }}" placeholder="Đặt ngay">
                </label>
                <label class="popup-field">
                    <span>Link nút chính</span>
                    <input type="text" name="cta_link" value="{{ $value('cta_link') }}" placeholder="/mua-le-hoi">
                </label>
            </div>
            <label class="popup-field">
                <span>Nút phụ</span>
                <select name="cta2" id="popup-cta2">
                    <option value="zalo" @selected($value('cta2') === 'zalo')>Tư vấn qua Zalo</option>
                    <option value="custom" @selected($value('cta2') === 'custom')>Nút tuỳ chỉnh</option>
                    <option value="" @selected($value('cta2') === '')>Không có</option>
                </select>
            </label>
            <div class="popup-two" id="popup-custom-cta2">
                <label class="popup-field">
                    <span>Chữ nút phụ</span>
                    <input type="text" name="cta2_label" value="{{ $value('cta2_label') }}">
                </label>
                <label class="popup-field">
                    <span>Link nút phụ</span>
                    <input type="text" name="cta2_link" value="{{ $value('cta2_link') }}">
                </label>
            </div>
            <label class="popup-field">
                <span>Ghi chú nhỏ</span>
                <input type="text" name="note" value="{{ $value('note') }}">
            </label>
            <label class="popup-field">
                <span>Nút nhắc nhỏ sau khi đóng</span>
                <input type="text" name="teaser" value="{{ $value('teaser') }}" placeholder="🎄 Đặt trước cây thông">
            </label>
        </section>
    </aside>

    <section class="popup-builder-preview" aria-label="Xem trước popup">
        <div class="popup-preview-bar">
            <span id="popup-status"></span>
            <span>Xem trước — cập nhật khi gõ</span>
        </div>
        <div id="popup-preview"></div>
        <div class="popup-preview-note">
            <strong>Hiển thị thực tế</strong>
            <p>Đây là đúng mẫu popup đang dùng ngoài website. Bấm “Xem dạng popup” để kiểm tra lớp phủ toàn màn hình.</p>
        </div>
    </section>
</form>

@push('scripts')
    <script>window.__LNTP_NOAUTO = true;</script>
    <script src="{{ asset('assets/lnt-popup.js') }}"></script>
    <script src="{{ asset('js/admin/popup-builder.js') }}"></script>
@endpush
