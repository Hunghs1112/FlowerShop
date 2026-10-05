@extends('layouts.app')

@section('title', $mysteryContent['hero_title'])

@section('content')
<main class="mystery-room" id="mysteryBoxExperience"
    data-options="{{ json_encode(['colors' => $mysteryContent['colors'], 'styles' => $mysteryContent['styles'], 'preferences' => $mysteryContent['preferences'], 'budgets' => $mysteryContent['budgets'], 'surprise_levels' => $mysteryContent['surprise_levels']], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP) }}"
    data-initial="{{ json_encode(['name' => old('name', $user?->name), 'phone' => old('phone', $user?->phone), 'email' => old('email', $user?->email), 'style' => old('style'), 'colors' => old('colors', []), 'preferences' => old('preferences', []), 'budget_range' => old('budget_range'), 'surprise_level' => old('surprise_level'), 'note' => old('note')], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP) }}"
    data-return-policy="{{ route('policy', 'chinh-sach-doi-tra') }}">
    <div class="mystery-room__wrap">
        <header class="mystery-room__header">
            <div>
                <a class="mystery-room__brand" href="{{ route('home') }}" aria-label="Lâm Nhiên Thảo — Trang chủ">✿ <span>LÂM NHIÊN THẢO</span></a>
                <p class="mystery-room__eyebrow">MYSTERY BOX · MỘT TRÒ CHƠI NHỎ</p>
                <h1>{{ $mysteryContent['hero_title'] }}</h1>
                <p class="mystery-room__lead">Tám món đồ đang ẩn mình trong căn phòng bí mật. Mỗi món giữ một điều bạn muốn gửi gắm cho hộp hoa. Tìm đủ, rồi dùng chiếc chìa khoá cuối cùng để niêm phong.</p>
            </div>
            <div class="mystery-room__tools">
                <button class="mystery-room__button" id="mysteryHint" type="button">✦ Gợi ý</button>
                <button class="mystery-room__button" id="mysteryReveal" type="button">Hiện tất cả món đồ</button>
            </div>
        </header>

        <section class="mystery-room__stage" id="mysteryStage" aria-label="Căn phòng bí mật">
            <svg class="mystery-room__scene" id="mysteryScene" viewBox="0 0 1200 680" role="group" aria-label="Tìm tám món đồ trong căn phòng để tạo hộp hoa">
                <defs>
                    <linearGradient id="roomWall" x2="0" y2="1"><stop stop-color="var(--color-cream)"/><stop offset="1" stop-color="var(--color-botanical)"/></linearGradient>
                    <linearGradient id="roomGlass" x2="0" y2="1"><stop stop-color="var(--color-botanical-pale)"/><stop offset="1" stop-color="var(--color-sage)"/></linearGradient>
                    <linearGradient id="roomFloor" x2="0" y2="1"><stop stop-color="var(--color-primary-light)"/><stop offset="1" stop-color="var(--color-primary)"/></linearGradient>
                    <radialGradient id="roomLight"><stop stop-color="#fff1ca" stop-opacity=".85"/><stop offset="1" stop-color="#fff1ca" stop-opacity="0"/></radialGradient>
                </defs>
                <rect width="1200" height="520" fill="url(#roomWall)"/><rect y="410" width="1200" height="110" fill="var(--color-sage)"/>
                <path d="M40 425h140v80H40zM220 425h140v80H220zM400 425h140v80H400zM580 425h140v80H580zM760 425h140v80H760zM940 425h140v80H940z" fill="none" stroke="var(--color-border)" stroke-width="2"/>
                <rect y="520" width="1200" height="160" fill="url(#roomFloor)"/><path d="M0 560h1200M0 605h1200M0 650h1200M180 520v40m340-40v40m380-40v40M320 560v45m440-45v45M90 605v45m520-45v45m440-45v45" stroke="var(--color-primary-dark)" opacity=".3"/>
                <path d="M140 360V180a120 120 0 0 1 240 0v180z" fill="var(--color-sage)"/><path d="M156 352V182a104 104 0 0 1 208 0v170z" fill="url(#roomGlass)"/>
                <g fill="var(--color-primary-lighter)" opacity=".9"><circle cx="190" cy="300" r="46"/><circle cx="250" cy="320" r="38"/><circle cx="320" cy="290" r="50"/><circle cx="215" cy="250" r="30"/></g><g fill="#e6b8b0"><circle cx="205" cy="270" r="7"/><circle cx="300" cy="262" r="6"/><circle cx="330" cy="300" r="7"/></g><path d="M260 82v270M156 240h208" stroke="var(--color-sage)" stroke-width="8"/><rect x="126" y="352" width="268" height="16" rx="4" fill="var(--color-primary-light)"/>
                <circle cx="620" cy="130" r="48" fill="var(--color-white)" stroke="var(--color-primary-light)" stroke-width="7"/><path d="M620 130v-30m0 30 22 10" stroke="var(--color-text)" stroke-width="3" stroke-linecap="round"/><g fill="var(--color-primary)"><circle cx="620" cy="90" r="3"/><circle cx="660" cy="130" r="3"/><circle cx="620" cy="170" r="3"/><circle cx="580" cy="130" r="3"/></g>
                <rect x="450" y="200" width="100" height="120" rx="4" fill="var(--color-primary-light)"/><rect x="460" y="210" width="80" height="100" fill="var(--color-cream)"/><g fill="#c79a8f"><circle cx="490" cy="250" r="16"/><circle cx="512" cy="262" r="12"/></g><path d="M498 270v30" stroke="var(--color-primary)" stroke-width="3"/>
                <rect x="900" y="70" width="240" height="440" rx="6" fill="var(--color-primary-light)"/><rect x="914" y="84" width="212" height="412" fill="var(--color-primary-dark)"/><path d="M914 180h212m-212 110h212m-212 110h212" stroke="var(--color-primary-light)" stroke-width="10"/>
                <g fill="#c79a8f"><rect x="922" y="112" width="18" height="68"/><rect x="958" y="120" width="20" height="60"/></g><g fill="var(--color-botanical-pale)"><rect x="942" y="104" width="14" height="76"/><rect x="980" y="108" width="16" height="72"/></g><path d="M1050 290l10-40h40l10 40z" fill="var(--color-sage)"/><g fill="var(--color-primary-lighter)"><circle cx="1068" cy="244" r="9"/><circle cx="1086" cy="238" r="11"/></g>
                <ellipse cx="620" cy="604" rx="340" ry="56" fill="var(--color-accent-light)"/><ellipse cx="620" cy="604" rx="300" ry="44" fill="none" stroke="var(--color-white)" stroke-width="3" stroke-dasharray="10 8"/>
                <rect x="96" y="388" width="248" height="70" rx="30" fill="var(--color-primary-light)"/><rect x="80" y="430" width="60" height="110" rx="24" fill="var(--color-primary)"/><rect x="300" y="430" width="60" height="110" rx="24" fill="var(--color-primary)"/><rect x="120" y="440" width="200" height="70" rx="20" fill="var(--color-primary-lighter)"/><rect x="120" y="500" width="220" height="40" rx="10" fill="var(--color-primary)"/>
                <rect x="430" y="398" width="360" height="18" rx="4" fill="var(--color-primary-light)"/><path d="M446 416v140m314-140v140" stroke="var(--color-primary-dark)" stroke-width="14"/><path d="M690 398c-14-6-14-46 4-56h22c18 10 18 50 4 56z" fill="var(--color-sage)"/><g stroke="var(--color-primary)" stroke-width="3"><path d="m705 344-14-50m14 50 4-60m-4 60 20-46"/></g><g fill="#d7a3a0"><circle cx="690" cy="290" r="16"/><circle cx="709" cy="280" r="18"/><circle cx="726" cy="296" r="15"/></g><path d="M392 398h200l-70-86h-60z" fill="url(#roomLight)"/>

                <g class="mystery-room__object" data-item="color" tabindex="0" role="button" aria-label="Tìm bảng màu hoa"><circle class="mystery-room__hit" cx="580" cy="390" r="32"/><g class="mystery-room__object-art"><path d="M560 396c-6-10 4-20 22-20 16 0 24 8 22 14-2 5-8 3-10 7s4 7-4 9c-10 2-26 0-30-10z" fill="#efe3d3" stroke="#cdb59e"/><circle cx="572" cy="386" r="3.5" fill="#d7a3a0"/><circle cx="582" cy="382" r="3.5" fill="#c98e6a"/><circle cx="592" cy="385" r="3.5" fill="#9aa07a"/></g><circle class="mystery-room__hint-ring" cx="580" cy="390" r="14"/></g>
                <g class="mystery-room__object" data-item="flower" tabindex="0" role="button" aria-label="Tìm sách thực vật"><circle class="mystery-room__hit" cx="972" cy="58" r="34"/><g class="mystery-room__object-art"><rect x="944" y="54" width="58" height="14" rx="2" fill="#7e8a52"/><rect x="948" y="44" width="52" height="12" rx="2" fill="#e6d3c6"/><circle cx="974" cy="50" r="4" fill="#d7a3a0"/></g><circle class="mystery-room__hint-ring" cx="972" cy="58" r="14"/></g>
                <g class="mystery-room__object" data-item="style" tabindex="0" role="button" aria-label="Tìm khung tranh phong cách"><circle class="mystery-room__hit" cx="80" cy="300" r="36"/><g class="mystery-room__object-art"><ellipse cx="80" cy="300" rx="22" ry="28" fill="#b28a6c"/><ellipse cx="80" cy="300" rx="16" ry="22" fill="#f1e2d4"/><circle cx="76" cy="296" r="5" fill="#c79a8f"/><circle cx="85" cy="300" r="4" fill="#d7a3a0"/></g><circle class="mystery-room__hint-ring" cx="80" cy="300" r="14"/></g>
                <g class="mystery-room__object" data-item="interest" tabindex="0" role="button" aria-label="Tìm đĩa nhạc sở thích"><circle class="mystery-room__hit" cx="796" cy="516" r="34"/><g class="mystery-room__object-art"><circle cx="796" cy="516" r="22" fill="#2e2420"/><circle cx="796" cy="516" r="15" fill="none" stroke="#4a3a32" stroke-width="2"/><circle cx="796" cy="516" r="5" fill="#c78e66"/></g><circle class="mystery-room__hint-ring" cx="796" cy="516" r="14"/></g>
                <g class="mystery-room__object" data-item="budget" tabindex="0" role="button" aria-label="Tìm heo đất ngân sách"><circle class="mystery-room__hit" cx="226" cy="556" r="34"/><g class="mystery-room__object-art"><ellipse cx="226" cy="556" rx="20" ry="13" fill="#e3afa8"/><circle cx="244" cy="553" r="6" fill="#e3afa8"/><circle cx="247" cy="553" r="1.5" fill="#8f5b47"/><path d="m214 545 4-6 4 6z" fill="#d59a92"/><rect x="222" y="543" width="9" height="2.5" rx="1" fill="#8f5b47"/></g><circle class="mystery-room__hint-ring" cx="226" cy="556" r="14"/></g>
                <g class="mystery-room__object" data-item="surprise" tabindex="0" role="button" aria-label="Tìm hộp quà mức độ bất ngờ"><circle class="mystery-room__hit" cx="350" cy="336" r="34"/><g class="mystery-room__object-art"><rect x="334" y="328" width="32" height="24" rx="2" fill="#c79a8f"/><rect x="331" y="322" width="38" height="9" rx="2" fill="#b98c7c"/><rect x="347" y="322" width="6" height="30" fill="#f3e2d2"/><path d="M350 322c-8-10-18-7-15-2 2 4 10 3 15 2s13-12 18-2c2 4-8 5-18 2z" fill="#f3e2d2"/></g><circle class="mystery-room__hint-ring" cx="350" cy="336" r="14"/></g>
                <g class="mystery-room__object" data-item="note" tabindex="0" role="button" aria-label="Tìm cuốn sổ ghi chú"><circle class="mystery-room__hit" cx="282" cy="486" r="34"/><g class="mystery-room__object-art" transform="rotate(10 282 485)"><rect x="262" y="468" width="38" height="32" rx="3" fill="#a86e4e"/><rect x="266" y="470" width="32" height="28" rx="2" fill="#fbf4ec"/><path d="M270 478h24m-24 6h24m-24 6h18" stroke="#c9b3a0" stroke-width="1.5"/></g><circle class="mystery-room__hint-ring" cx="282" cy="486" r="14"/></g>
                <g class="mystery-room__object" data-item="confirm" tabindex="0" role="button" aria-label="Tìm chìa khoá xác nhận"><circle class="mystery-room__hit" cx="905" cy="620" r="36"/><g class="mystery-room__object-art" transform="rotate(-18 905 620)"><circle cx="890" cy="620" r="9" fill="none" stroke="#d9a85e" stroke-width="5"/><rect x="898" y="617" width="30" height="6" rx="2" fill="#d9a85e"/><rect x="918" y="622" width="5" height="8" fill="#d9a85e"/></g><circle class="mystery-room__hint-ring" cx="905" cy="620" r="14"/></g>
                <g id="mysteryBoxMark" opacity="0"><rect x="545" y="530" width="150" height="105" rx="16" fill="var(--color-primary-dark)"/><rect x="535" y="515" width="170" height="28" rx="8" fill="var(--color-primary)"/><path d="M610 516v119m-18-120c-20-18-34-5-17 5l35 1c20-18 34-5 17 5l-18-6z" fill="var(--color-sage)"/><circle cx="620" cy="570" r="22" fill="var(--color-primary-light)"/><text x="620" y="575" text-anchor="middle" font-size="12" fill="#fff">LNT</text></g>
            </svg>
            <div class="mystery-room__dialog-backdrop" id="mysteryDialogBackdrop" hidden></div>
            <section class="mystery-room__dialog" id="mysteryDialog" role="dialog" aria-modal="true" aria-labelledby="mysteryDialogTitle" hidden>
                <p class="mystery-room__dialog-kicker" id="mysteryDialogKicker"></p>
                <h2 id="mysteryDialogTitle"></h2>
                <p class="mystery-room__dialog-help" id="mysteryDialogHelp"></p>
                <div id="mysteryDialogFields"></div>
                <p class="mystery-room__dialog-error" id="mysteryDialogError" aria-live="polite"></p>
                <div class="mystery-room__dialog-actions"><button class="mystery-room__button" id="mysteryDialogClose" type="button">Để sau</button><button class="mystery-room__button mystery-room__button--primary" id="mysteryDialogSave" type="button">Cất giữ</button></div>
            </section>
            <div class="mystery-room__success" id="mysterySuccess" hidden><div class="mystery-room__wax">LNT</div><h2>Căn phòng đã khoá</h2><p>Mọi điều bạn gửi gắm đã được cất vào hộp hoa. Lâm Nhiên Thảo sẽ liên hệ để xác nhận yêu cầu.</p><button class="mystery-room__button mystery-room__button--primary" id="mysterySubmit" type="button">Gửi yêu cầu đến LNT</button></div>
            <div class="mystery-room__progress" id="mysteryProgress" aria-live="polite"></div>
        </section>
        <nav class="mystery-room__collection" id="mysteryCollection" aria-label="Các món đồ cần tìm"></nav>
        <div class="mystery-room__status"><p id="mysteryStatus" aria-live="polite"></p><span>Thông tin nhận hàng chỉ dùng để xử lý đơn · <a href="{{ route('policy', 'chinh-sach-bao-mat') }}">Chính sách bảo mật</a></span></div>
        <form id="mysteryBoxForm" action="{{ route('mystery-box.store') }}" method="POST" hidden>
            @csrf
            <input type="hidden" name="style"><input type="hidden" name="budget_range"><input type="hidden" name="surprise_level"><input type="hidden" name="note">
            <div id="mysteryColors"></div><div id="mysteryPreferences"></div>
            <input type="text" name="name"><input type="tel" name="phone"><input type="email" name="email">
        </form>
    </div>
</main>
<link rel="stylesheet" href="{{ asset('css/mystery-box.css') }}?v=3">
<script src="{{ asset('js/mystery-box.js') }}?v=2"></script>
@endsection
