@extends('layouts.app')

@section('title', 'Hộp Hoa Bí Ẩn')

@section('content')
<x-page-hero 
    title="Hộp Hoa Bí Ẩn"
    description="Để LNT chọn hoa, bạn giữ lại niềm vui bất ngờ"
    :breadcrumbs="[
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Hộp Hoa Bí Ẩn']
    ]"
    :image="$siteBanners['mystery-box'] ?? null"
    height="350px"
/>

<div class="container page-wrapper">
    <div class="mystery-box-container">
        <div class="mystery-box-content">
            <div class="mystery-box-intro">
                <h2>Khám Phá Điều Bất Ngờ</h2>
                <p>Bạn không chọn sản phẩm cụ thể. Chỉ cần cung cấp nhu cầu của mình, và LNT sẽ lựa chọn những bông hoa đẹp nhất dành riêng cho bạn.</p>
            </div>

            <form id="mysteryBoxForm" action="{{ route('mystery-box.store') }}" method="POST">
                @csrf

                <!-- Step Indicator -->
                <div class="step-indicator">
                    <div class="step-item active" data-step="1">
                        <div class="step-number">1</div>
                        <div class="step-label">Phong cách</div>
                    </div>
                    <div class="step-item" data-step="2">
                        <div class="step-number">2</div>
                        <div class="step-label">Màu sắc</div>
                    </div>
                    <div class="step-item" data-step="3">
                        <div class="step-number">3</div>
                        <div class="step-label">Sở thích</div>
                    </div>
                    <div class="step-item" data-step="4">
                        <div class="step-number">4</div>
                        <div class="step-label">Ngân sách</div>
                    </div>
                    <div class="step-item" data-step="5">
                        <div class="step-number">5</div>
                        <div class="step-label">Mức độ bất ngờ</div>
                    </div>
                    <div class="step-item" data-step="6">
                        <div class="step-number">6</div>
                        <div class="step-label">Ghi chú</div>
                    </div>
                    <div class="step-item" data-step="7">
                        <div class="step-number">7</div>
                        <div class="step-label">Xác nhận</div>
                    </div>
                </div>

                <!-- Step 1: Style -->
                <div class="step-content active" data-step="1">
                    <h3 class="step-title">Chọn Phong Cách</h3>
                    <div class="selection-grid">
                        @foreach(['Thanh lịch', 'Lãng mạn', 'Tự nhiên', 'Tối giản', 'Sang trọng'] as $style)
                        <label class="selection-card">
                            <input type="radio" name="style" value="{{ $style }}" {{ old('style') == $style ? 'checked' : '' }} required>
                            <div class="card-content">
                                <div class="card-icon">
                                    @if($style == 'Thanh lịch')
                                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                    @elseif($style == 'Lãng mạn')
                                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    @elseif($style == 'Tự nhiên')
                                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    @elseif($style == 'Tối giản')
                                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    @else
                                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                    @endif
                                </div>
                                <div class="card-title">{{ $style }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('style')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Step 2: Colors -->
                <div class="step-content" data-step="2">
                    <h3 class="step-title">Chọn Màu Sắc (có thể chọn nhiều)</h3>
                    <div class="selection-grid">
                        @foreach(['Trắng', 'Kem', 'Hồng', 'Xanh', 'Đỏ', 'Pastel', 'Không giới hạn'] as $color)
                        <label class="selection-card">
                            <input type="checkbox" name="colors[]" value="{{ $color }}" {{ is_array(old('colors')) && in_array($color, old('colors')) ? 'checked' : '' }}>
                            <div class="card-content">
                                <div class="color-preview" style="background-color: {{ 
                                    $color == 'Trắng' ? '#FFFFFF' : 
                                    ($color == 'Kem' ? '#FFF8DC' : 
                                    ($color == 'Hồng' ? '#FFB6C1' : 
                                    ($color == 'Xanh' ? '#87CEEB' : 
                                    ($color == 'Đỏ' ? '#DC143C' : 
                                    ($color == 'Pastel' ? 'linear-gradient(135deg, #FFB6C1 0%, #87CEEB 100%)' : '#E5E7EB'))))) 
                                }}; {{ $color == 'Không giới hạn' ? 'background: linear-gradient(135deg, #FFB6C1 0%, #87CEEB 50%, #FFF8DC 100%);' : '' }}"></div>
                                <div class="card-title">{{ $color }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('colors')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Step 3: Preferences -->
                <div class="step-content" data-step="3">
                    <h3 class="step-title">Sở Thích (có thể chọn nhiều)</h3>
                    <div class="selection-grid">
                        @foreach(['Nhiều hoa', 'Ít hoa', 'Nhiều lá', 'Nhẹ nhàng', 'Nổi bật', 'Tự nhiên'] as $pref)
                        <label class="selection-card">
                            <input type="checkbox" name="preferences[]" value="{{ $pref }}" {{ is_array(old('preferences')) && in_array($pref, old('preferences')) ? 'checked' : '' }}>
                            <div class="card-content">
                                <div class="card-title">{{ $pref }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('preferences')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Step 4: Budget -->
                <div class="step-content" data-step="4">
                    <h3 class="step-title">Ngân Sách</h3>
                    <div class="selection-grid">
                        @foreach(['500k-1M' => '500.000đ - 1.000.000đ', '1M-2M' => '1.000.000đ - 2.000.000đ', '2M-5M' => '2.000.000đ - 5.000.000đ', '5M+' => '5.000.000đ+'] as $value => $label)
                        <label class="selection-card">
                            <input type="radio" name="budget_range" value="{{ $value }}" {{ old('budget_range') == $value ? 'checked' : '' }} required>
                            <div class="card-content">
                                <div class="card-title">{{ $label }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('budget_range')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Step 5: Surprise Level -->
                <div class="step-content" data-step="5">
                    <h3 class="step-title">Mức Độ Bất Ngờ</h3>
                    <div class="selection-grid">
                        @foreach(['Bất ngờ hoàn toàn', 'Bất ngờ một phần', 'Muốn giữ một vài yêu cầu'] as $level)
                        <label class="selection-card">
                            <input type="radio" name="surprise_level" value="{{ $level }}" {{ old('surprise_level') == $level ? 'checked' : '' }} required>
                            <div class="card-content">
                                <div class="card-title">{{ $level }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('surprise_level')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Step 6: Note -->
                <div class="step-content" data-step="6">
                    <h3 class="step-title">Ghi Chú</h3>
                    <div class="form-group">
                        <label for="name" class="form-label required">Họ và tên</label>
                        <input type="text" id="name" name="name" 
                               value="{{ $user ? $user->name : old('name') }}" 
                               class="form-input @error('name') form-input-error @enderror" required>
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label required">Số điện thoại</label>
                        <input type="tel" id="phone" name="phone" 
                               value="{{ $user ? $user->phone : old('phone') }}" 
                               class="form-input @error('phone') form-input-error @enderror" required>
                        @error('phone')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email (tùy chọn)</label>
                        <input type="email" id="email" name="email" 
                               value="{{ $user ? $user->email : old('email') }}" 
                               class="form-input @error('email') form-input-error @enderror">
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="note" class="form-label">Yêu cầu riêng</label>
                        <textarea id="note" name="note" rows="4" 
                                  class="form-input form-textarea @error('note') form-input-error @enderror"
                                  placeholder="Ví dụ: Không dùng hoa đỏ">{{ old('note') }}</textarea>
                        @error('note')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Step 7: Confirmation -->
                <div class="step-content" data-step="7">
                    <h3 class="step-title">Xác Nhận Mystery Box</h3>
                    
                    <div class="summary-box">
                        <div class="summary-section">
                            <h4>Thông Tin Đã Chọn</h4>
                            <div class="summary-item">
                                <span class="summary-label">Phong cách:</span>
                                <span class="summary-value" id="summary-style">-</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Bảng màu:</span>
                                <span class="summary-value" id="summary-colors">-</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Sở thích:</span>
                                <span class="summary-value" id="summary-preferences">-</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Ngân sách:</span>
                                <span class="summary-value" id="summary-budget">-</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Mức độ bất ngờ:</span>
                                <span class="summary-value" id="summary-surprise">-</span>
                            </div>
                        </div>

                        <div class="disclaimer">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p>Mystery Box được LNT tuyển chọn dựa trên hoa sẵn có, mùa hoa và chất lượng tại thời điểm chuẩn bị. Một số loại hoa có thể được thay thế bằng lựa chọn tương đương nếu cần.</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="step-navigation">
                    <button type="button" class="btn btn-outline btn-lg" id="prevBtn" style="display: none;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Quay lại
                    </button>
                    <button type="button" class="btn btn-primary btn-lg" id="nextBtn">
                        Tiếp theo
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" style="display: none;">
                        Xác nhận yêu cầu
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/mystery-box.css') }}">
<script src="{{ asset('js/mystery-box.js') }}"></script>
@endsection
