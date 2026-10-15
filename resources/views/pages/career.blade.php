<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page->title }} · Lâm Nhiên Thảo</title>
    <meta name="description" content="LNT Journal số đặc biệt – Tìm đồng đội cùng Lâm Nhiên Thảo.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;600&family=Lora:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/careers.css') }}?v={{ filemtime(public_path('css/careers.css')) }}">
</head>
<body>
<header class="nav"><div class="wrap">
    <a href="{{ route('home') }}" aria-label="Lâm Nhiên Thảo – Trang chủ"><img src="{{ asset('images/careers/logo.png') }}" alt="Lâm Nhiên Thảo"></a>
    <nav aria-label="Menu chính"><ul><li><a href="{{ route('home') }}">Trang chủ</a></li><li><a href="{{ route('products.index') }}">Sản phẩm</a></li><li><a href="{{ route('blog.index') }}">Góc cảm hứng</a></li><li><a href="{{ route('guide') }}">Thông tin</a></li><li><a href="{{ route('b2c') }}">B2B</a></li></ul></nav>
    <div class="icons"><a href="{{ route('products.index') }}" aria-label="Tìm kiếm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></svg></a><a href="{{ route('cart.index') }}" aria-label="Giỏ hàng"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 8h12l-1 12H7z"/><path d="M9 8a3 3 0 0 1 6 0"/></svg></a><a href="{{ route('login') }}" aria-label="Tài khoản"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 21c1.5-4 4.5-6 8-6s6.5 2 8 6"/></svg></a></div>
</div></header>
<main class="mag">
<section class="cover-sec"><div class="wrap cover-grid">
    <figure class="cover">
        <img id="cvImg" alt="">
        <div class="cv-top"><b id="cvMast"></b><span id="cvIssue"></span></div>
        <div class="cv-lines" id="cvLines"></div>
        <div class="cv-barcode" aria-hidden="true"><i></i><span id="cvNo"></span></div>
    </figure>
    <aside class="toc">
        <p class="eyebrow" id="tocKicker">TRONG SỐ NÀY</p>
        <h1 id="tocTitle"></h1>
        <p class="lead" id="tocLead"></p>
        <ol class="toc-list" id="toc"></ol>
        <a class="btn" href="#dang-ky">Đăng ký ứng tuyển</a>
    </aside>
</div></section>

<section class="letter"><div class="wrap narrow">
    <p class="eyebrow center-e">THƯ TOÀ SOẠN</p>
    <div class="letter-body" id="letter"></div>
    <p class="sign" id="sign"></p>
</div></section>

<div id="features"></div>

<section class="sec soft"><div class="wrap">
    <p class="eyebrow">LỊCH PHÁT HÀNH</p>
    <h2>Quy trình ứng tuyển</h2>
    <ol class="sched" id="steps"></ol>
</div></section>

<section class="sec" id="dang-ky"><div class="wrap sub-grid">
    <div>
        <p class="eyebrow">PHIẾU ĐĂNG KÝ</p>
        <h2 class="big">Góp mặt trong<br><em>số tiếp theo</em></h2>
        <p class="muted" id="subLead"></p>
        <ul class="contact" id="contact"></ul>
    </div>
    <form class="coupon" id="sform" novalidate>
        <span class="scissors" aria-hidden="true">✂</span>
        <div class="cp-head"><b id="cpMast"></b><span>PHIẾU ĐĂNG KÝ ỨNG TUYỂN</span></div>
        <label class="fld"><span>Vị trí *</span><select id="sPos" required></select></label>
        <div class="two"><label class="fld"><span>Họ và tên *</span><input id="sName" autocomplete="name" required></label>
        <label class="fld"><span>Năm sinh</span><input id="sYear" inputmode="numeric" maxlength="4"></label></div>
        <div class="two"><label class="fld"><span>Số điện thoại / Zalo *</span><input id="sPhone" type="tel" autocomplete="tel" required></label>
        <label class="fld"><span>Email *</span><input id="sEmail" type="email" autocomplete="email" required></label></div>
        <label class="fld"><span>Link CV / portfolio</span><input id="sCv" type="url" placeholder="https://"></label>
        <label class="fld"><span>Đôi dòng về bạn</span><textarea id="sNote" rows="3"></textarea></label>
        <p class="err" id="serr" role="alert" hidden></p>
        <div class="cp-foot"><p class="hint" id="shint"></p><button class="btn" type="submit">Gửi phiếu →</button></div>
        <div class="cp-done" id="done" hidden><small>ĐÃ NHẬN PHIẾU</small><b>Cảm ơn bạn</b><p id="doneTxt"></p><button type="button" class="btn ghost" id="again">Gửi phiếu khác</button></div>
    </form>
</div></section>
</main>

<footer><div class="wrap">
    <div><img src="{{ asset('images/careers/logo-footer.png') }}" alt="Lâm Nhiên Thảo" style="height:46px;width:auto"><p class="tl">Từ những vùng đất đặc biệt đến những nơi tuyệt đẹp.</p>
        <ul><li><a href="tel:0869308993">0869 308 993 (Điện thoại / Zalo)</a></li><li><a href="mailto:support@lamnhienthao.com">support@lamnhienthao.com</a></li><li><a href="{{ route('contact') }}">Liên hệ →</a></li></ul></div>
    <div><h4>CỔNG THÔNG TIN</h4><ul>
        <li><a href="{{ route('guide') }}"><span class="gate">A1</span>Hướng dẫn mua hàng</a></li><li><a href="{{ route('policy.delivery') }}"><span class="gate">A2</span>Chính sách giao hàng</a></li>
        <li><a href="{{ route('policy.ours') }}"><span class="gate">A3</span>Chính sách đổi trả</a></li><li><a href="{{ route('policy.terms') }}"><span class="gate">A4</span>Điều khoản dịch vụ</a></li><li><a href="{{ route('policy.baomat') }}"><span class="gate">A5</span>Chính sách bảo mật</a></li></ul></div>
    <div><h4>KHÁM PHÁ</h4><ul><li><a href="{{ route('products.index') }}">Hàng mới hạ cánh</a></li><li><a href="{{ route('mystery-box.index') }}">Hộp hoa bí ẩn</a></li><li><a href="{{ route('blog.index') }}">LNT Journal</a></li><li><a href="{{ route('b2c') }}">Đối tác B2B</a></li><li><a href="{{ route('login') }}">Tài khoản</a></li></ul></div>
</div><p class="copy">© Lâm Nhiên Thảo</p></footer>
<script>
window.CAREER_CONFIG = @json([...$config, 'endpoint' => route('career.store'), 'csrfToken' => csrf_token()]);
</script>
<script src="{{ asset('js/careers.js') }}?v={{ filemtime(public_path('js/careers.js')) }}"></script>
</body>
</html>
