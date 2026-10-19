@extends('layouts.admin')

@section('title', 'Gắn Logo Ảnh')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;600&family=Lora:ital,wght@0,500;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin/watermark.css') }}?v={{ filemtime(public_path('css/admin/watermark.css')) }}">
@endpush

@section('content')
<section class="watermark-tool" id="watermarkTool" data-logo-src="{{ asset('images/brand/lnt-logo.png') }}">
    <header class="watermark-tool__header">
        <strong>LÂM NHIÊN THẢO</strong>
        <span>Gắn logo tự động cho ảnh</span>
    </header>

    <div class="watermark-tool__layout">
        <aside>
            <section class="watermark-box">
                <h2>1 · TẢI ẢNH LÊN</h2>
                <label class="watermark-drop" id="watermarkDrop">
                    <input type="file" id="watermarkFiles" accept="image/*" multiple>
                    <strong>Kéo thả ảnh vào đây</strong>
                    <small>hoặc bấm để chọn – chọn được nhiều ảnh cùng lúc</small>
                </label>
            </section>

            <section class="watermark-box">
                <h2>KIỂU NHANH</h2>
                <div class="watermark-segments" id="watermarkPreset">
                    <button type="button" data-key="sharp">Rõ nét</button>
                    <button type="button" data-key="transparent">Logo trong 45%</button>
                    <button type="button" data-key="color-transparent">Logo màu trong</button>
                    <button type="button" data-key="centered">Chìm giữa ảnh</button>
                </div>
            </section>

            <section class="watermark-box">
                <h2>2 · LOGO</h2>
                <div class="watermark-field">
                    <span>Màu logo</span>
                    <div class="watermark-segments" id="watermarkVariant">
                        <button type="button" data-value="color">Màu gốc</button>
                        <button type="button" data-value="white">Trắng</button>
                        <button type="button" data-value="brown">Nâu</button>
                        <button type="button" data-value="cream">Kem</button>
                    </div>
                </div>
                <div class="watermark-field">
                    <span>Vị trí</span>
                    <div class="watermark-position" id="watermarkPosition" role="group" aria-label="Vị trí logo"></div>
                </div>
                <label class="watermark-field">
                    <span>Kích thước <output id="watermarkSizeOutput"></output></span>
                    <input type="range" id="watermarkSize" min="8" max="60" step="1">
                </label>
                <label class="watermark-field">
                    <span>Cách mép <output id="watermarkMarginOutput"></output></span>
                    <input type="range" id="watermarkMargin" min="0" max="15" step="0.5">
                </label>
                <label class="watermark-field">
                    <span>Độ rõ của logo <em>(kéo trái = trong hơn)</em> <output id="watermarkOpacityOutput"></output></span>
                    <input type="range" id="watermarkOpacity" min="10" max="100" step="5">
                </label>
                <label class="watermark-upload-link">
                    Dùng logo khác…
                    <input type="file" id="watermarkLogoFile" accept="image/png,image/svg+xml,image/webp">
                </label>
            </section>

            <section class="watermark-box">
                <h2>3 · NỀN SAU LOGO</h2>
                <div class="watermark-segments" id="watermarkBackground">
                    <button type="button" data-value="glow">Bóng mờ</button>
                    <button type="button" data-value="shadow">Đổ bóng</button>
                    <button type="button" data-value="none">Không nền</button>
                </div>
                <label class="watermark-field">
                    <span>Độ mờ của bóng <output id="watermarkGlowOutput"></output></span>
                    <input type="range" id="watermarkGlow" min="10" max="100" step="5">
                </label>
            </section>

            <section class="watermark-box">
                <h2>4 · XUẤT ẢNH</h2>
                <label class="watermark-field">
                    <span>Định dạng</span>
                    <select id="watermarkFormat">
                        <option value="jpeg">JPG (nhẹ, đăng web/Facebook)</option>
                        <option value="png">PNG (nét nhất)</option>
                    </select>
                </label>
                <label class="watermark-field">
                    <span>Chất lượng JPG <output id="watermarkQualityOutput"></output></span>
                    <input type="range" id="watermarkQuality" min="60" max="100" step="2">
                </label>
            </section>
        </aside>

        <main class="watermark-preview">
            <div class="watermark-stage" id="watermarkStage">
                <p>Tải ảnh lên để xem logo được gắn tự động.</p>
            </div>
            <div class="watermark-bar">
                <span class="watermark-info" id="watermarkInfo"></span>
                <span class="watermark-actions">
                    <button type="button" class="watermark-button watermark-button--ghost" id="watermarkDownloadOne" disabled>Tải ảnh này</button>
                    <button type="button" class="watermark-button" id="watermarkDownloadAll" disabled>Tải tất cả</button>
                </span>
            </div>
            <div class="watermark-progress" id="watermarkProgress"><i></i></div>
            <div class="watermark-thumbnails" id="watermarkThumbnails" aria-label="Danh sách ảnh"></div>
        </main>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="{{ asset('js/admin/watermark.js') }}?v={{ filemtime(public_path('js/admin/watermark.js')) }}"></script>
@endpush
