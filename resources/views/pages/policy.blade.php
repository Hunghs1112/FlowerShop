@php
    $variant = match ($page->slug) {
        'chinh-sach-bao-mat' => [
            'eyebrow' => 'QUYỀN RIÊNG TƯ',
            'lead' => 'Lâm Nhiên Thảo trân trọng sự tin tưởng và bảo vệ thông tin của bạn trong suốt hành trình cùng hoa.',
            'visual' => 'privacy',
            'stamp' => 'FLOWER PASS',
            'updated' => 'Cập nhật lần cuối · Tháng 9, 2026',
        ],
        'dieu-khoan-dich-vu' => [
            'eyebrow' => 'THÔNG TIN',
            'lead' => 'Vui lòng đọc kỹ các điều khoản dịch vụ trước khi sử dụng website và đặt hoa tại Lâm Nhiên Thảo.',
            'visual' => 'terms',
            'stamp' => 'VISA · FLOWER ENTRY',
            'updated' => 'Có hiệu lực · Cho mỗi đơn hàng',
        ],
        'chinh-sach-giao-hang' => [
            'eyebrow' => 'DỊCH VỤ',
            'lead' => 'Giao hoa tận nơi với phương thức vận chuyển được lựa chọn phù hợp theo từng đơn hàng và khu vực.',
            'visual' => 'delivery',
            'stamp' => 'THEO DÕI ĐƠN HOA',
            'updated' => 'Thứ Hai – Thứ Bảy · 08:00–17:00',
        ],
        default => [
            'eyebrow' => 'CAM KẾT',
            'lead' => 'Sự hài lòng và quyền lợi của khách hàng luôn là ưu tiên hàng đầu của Lâm Nhiên Thảo.',
            'visual' => 'returns',
            'stamp' => 'LNT · CARE',
            'updated' => 'Cập nhật lần cuối · Tháng 9, 2026',
        ],
    };

    $content = trim((string) $page->content);
    $sectionStart = '/\R(?=(?:#{1,6}\s*\d+\.\s+[^\r\n]+|\d+\.\s+[^\r\n\p{Ll}]+)(?:\R|$))/u';
    $chunks = preg_split($sectionStart, $content, -1, PREG_SPLIT_NO_EMPTY) ?: [];
    $sections = collect($chunks)->map(function (string $chunk) {
        $lines = preg_split('/\R/u', trim($chunk), 2);
        $heading = trim($lines[0] ?? 'Thông tin');
        $body = trim($lines[1] ?? '');
        if (preg_match('/^(?:#{1,6}\s*)?(\d+)\.\s*(.+)$/u', $heading, $m)) {
            return ['code' => str_pad($m[1], 2, '0', STR_PAD_LEFT), 'title' => mb_convert_case($m[2], MB_CASE_TITLE, 'UTF-8'), 'body' => $body];
        }
        return null;
    })->filter()->values();

    if ($sections->isEmpty()) {
        $sections = collect([['code' => '01', 'title' => 'Thông tin chính sách', 'body' => $content]]);
    }
@endphp

@extends('layouts.app')

@section('title', $page->title)

@section('content')
<main class="policy-modern policy-{{ $variant['visual'] }}" data-policy-page>
    <div class="policy-wrap">
        <section class="policy-hero" aria-labelledby="policy-title">
            <div class="policy-copy">
                <a class="policy-mark" href="{{ route('home') }}" aria-label="Về trang chủ">
                    <span class="policy-mark-flower">✽</span><span>LNT</span>
                </a>
                <p class="policy-eyebrow">{{ $variant['eyebrow'] }}</p>
                <h1 id="policy-title">{{ $page->title }}</h1>
                <p class="policy-lead">{{ $variant['lead'] }}</p>
                <p class="policy-updated">{{ $variant['updated'] }}</p>
            </div>

            <div class="policy-visual" aria-label="Minh họa {{ $page->title }}">
                @if($variant['visual'] === 'delivery')
                    <img class="delivery-bloom" src="{{ asset('images/pages/page-header-4-1791166033.jpg') }}" alt="" aria-hidden="true">
                    <div class="delivery-card" role="img" aria-label="Thẻ theo dõi đơn hoa minh họa quy trình giao hàng 5 bước">
                        <div class="visual-top"><span>{{ $variant['stamp'] }}</span><span>LNT·01</span></div>
                        <strong class="delivery-title">Đang trên đường đến bạn</strong>
                        <div class="delivery-route"><span><b>VƯỜN</b><small>Xưởng hoa LNT</small></span><i></i><span><b>BẠN</b><small>Không gian của bạn</small></span></div>
                        <div class="delivery-progress"><i></i></div>
                        <ol class="delivery-steps"><li class="done">Xác nhận đơn</li><li class="done">Chuẩn bị hoa</li><li class="done">Bàn giao vận chuyển</li><li>Liên hệ trước khi đến</li><li>Giao thành công</li></ol>
                        <div class="delivery-facts"><span>Thứ Hai – Thứ Bảy · 08:00–17:00</span><span>Giao trong ngày: xác nhận trước 14:00</span><span>Hà Nội &amp; khu vực lân cận</span></div>
                    </div>
                @elseif($variant['visual'] === 'privacy')
                    <div class="privacy-card">
                        <div class="visual-top"><span>{{ $variant['stamp'] }}</span><span>08·SAFE</span></div>
                        <div class="privacy-grid"><span>HỌ VÀ TÊN<small>Để xác nhận và xử lý đơn hàng</small></span><span>SỐ ĐIỆN THOẠI<small>Để tư vấn, chăm sóc và hỗ trợ bạn</small></span><span>ĐỊA CHỈ GIAO HÀNG<small>Để giao hoa đúng địa chỉ, đúng hẹn</small></span><span>NỘI DUNG TRAO ĐỔI<small>Để cải thiện sản phẩm và dịch vụ</small></span></div>
                        <small class="visual-note">ĐƯỢC BẢO VỆ · Rê chuột hoặc chạm vào từng ô</small>
                    </div>
                @elseif($variant['visual'] === 'terms')
                    <div class="passport-card"><div class="visual-top"><span>{{ $variant['stamp'] }}</span><span>APPROVED</span></div><div class="passport-code">V&lt;VNMLAM&lt;NHIEN&lt;THAO&lt;&lt;FLOWERS&lt;&lt;&lt;&lt;&lt;</div><div class="passport-fields"><span><b>LNT</b><small>LOẠI</small>Hoa tươi nhập khẩu</span><span><b>HÀ NỘI</b><small>ĐIỂM ĐẾN</small>Không gian của bạn</span></div><div class="passport-seal">✓</div></div>
                @else
                    <div class="care-card"><div class="visual-top"><span>{{ $variant['stamp'] }}</span><span>LNT·CARE</span></div><div class="care-flower">✽</div><strong>Hoa tươi · Chăm sóc tận tâm</strong><p>Kiểm tra ngay khi nhận<br>Liên hệ sớm khi có bất thường</p><div class="care-line"></div></div>
                @endif
            </div>
        </section>

        <div class="policy-toolbar"><p>{{ str_pad((string) $sections->count(), 2, '0', STR_PAD_LEFT) }} CÁC MỤC</p><button type="button" class="policy-toggle" data-policy-toggle>Mở tất cả</button></div>

        <section class="policy-gates" aria-label="Nội dung chính sách">
            @foreach($sections as $section)
                <details class="policy-gate" @if($loop->first) open @endif>
                    <summary><span class="policy-code">{{ $section['code'] }}</span><h2>{{ $section['title'] }}</h2><span class="policy-chevron" aria-hidden="true">⌄</span></summary>
                    <div class="policy-body"><p class="policy-tldr">{{ Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($section['body']))), 220) }}</p><x-markdown-renderer :content="$section['body']" /></div>
                </details>
            @endforeach
        </section>

        <section class="policy-help"><div><h2>Cần hỗ trợ?</h2><p>Lâm Nhiên Thảo luôn sẵn sàng lắng nghe và đồng hành cùng bạn.</p></div><div class="policy-actions"><a class="primary" href="{{ route('contact') }}">Liên hệ</a><a href="tel:0869308993">Gọi điện</a><a href="mailto:{{ config('mail.from.address', 'support@lamnhienthao.com') }}">Email</a></div></section>
        <footer class="policy-foot"><span>© Lâm Nhiên Thảo</span><span>Hoa nhập khẩu tuyển chọn · Hà Nội</span></footer>
    </div>
</main>

<style>
.policy-modern{--p-bg:#f5ebe6;--p-paper:#fcf8f5;--p-ink:#5e4636;--p-soft:#8c6e5c;--p-copper:#c78e66;--p-deep:#a8714e;--p-line:#e6d3c6;--p-board:#3a2c24;background:var(--p-bg);color:var(--p-ink);font-family:"Josefin Sans","Avenir Next",system-ui,sans-serif;margin:calc(var(--space-8,2rem)*-1) 0 0;padding:var(--space-8,2rem) 0 0}.policy-wrap{max-width:1180px;margin:auto;padding:0 clamp(1.25rem,4vw,3rem)}.policy-hero{display:grid;grid-template-columns:minmax(0,4fr) minmax(0,6fr);gap:clamp(2rem,4vw,4rem);align-items:center;padding:clamp(2.5rem,6vw,5rem) 0 clamp(2rem,4vw,3rem)}.policy-mark{display:inline-flex;gap:.55rem;align-items:center;color:var(--p-deep);text-decoration:none;font-weight:600;letter-spacing:.2em;margin-bottom:2rem}.policy-mark-flower{display:grid;place-items:center;width:2.2rem;height:2.2rem;border:1px solid var(--p-copper);border-radius:50%;font-size:1.4rem}.policy-eyebrow{font-size:.8rem;letter-spacing:.28em;color:var(--p-deep);display:flex;align-items:center;gap:.9rem;margin:0 0 .9rem}.policy-eyebrow:after{content:"";width:64px;height:1.5px;background:currentColor}.policy-modern h1{margin:0;font-weight:600;text-transform:uppercase;color:var(--p-copper);font-size:clamp(2rem,3.8vw,3.2rem);line-height:1.06;letter-spacing:.01em}.policy-lead{font-family:Lora,Georgia,serif;font-style:italic;color:var(--p-deep);font-size:clamp(1.02rem,1.35vw,1.2rem);line-height:1.65;margin:1.2rem 0 0;max-width:32em}.policy-updated{margin:1.1rem 0 0;font-size:.8rem;letter-spacing:.08em;color:var(--p-soft)}.policy-visual{min-width:0}.delivery-card,.privacy-card,.passport-card,.care-card{background:var(--p-board);color:#f4e8dc;border-radius:22px;padding:clamp(1.25rem,2.5vw,2rem);min-height:290px;box-shadow:0 30px 60px -30px rgba(120,80,55,.4);position:relative;overflow:hidden}.visual-top{display:flex;justify-content:space-between;color:#e2ae84;font-size:.76rem;font-weight:600;letter-spacing:.16em;margin-bottom:2.2rem}.delivery-card>strong,.care-card>strong{display:block;color:#e2ae84;font-size:1.4rem;letter-spacing:.02em}.delivery-route{display:flex;align-items:center;justify-content:space-between;gap:1rem;margin:2rem 0 1.1rem}.delivery-route span{display:grid;gap:.25rem}.delivery-route b{font-size:.8rem;color:#e2ae84;letter-spacing:.15em}.delivery-route small{color:#cdb5a2}.delivery-route i{height:1px;flex:1;background:#a8714e;position:relative}.delivery-route i:after{content:"";position:absolute;right:0;top:-3px;width:7px;height:7px;border-radius:50%;background:#e2ae84}.delivery-progress{height:4px;background:#5e4636;border-radius:9px;overflow:hidden}.delivery-progress i{display:block;width:65%;height:100%;background:#e2ae84;border-radius:inherit}.delivery-card ol{display:flex;gap:.7rem;justify-content:space-between;padding:0;margin:1rem 0 0;list-style:none;font-size:.68rem;color:#cdb5a2}.delivery-card li{max-width:5.3rem}.visual-note{display:block;color:#bfa493;letter-spacing:.08em;margin-top:1.4rem}.privacy-grid{display:grid;grid-template-columns:1fr 1fr;gap:.7rem}.privacy-grid span{border:1px solid rgba(226,174,132,.35);padding:1rem;border-radius:10px;color:#e2ae84;font-size:.72rem;letter-spacing:.1em}.privacy-grid small{display:block;color:#cdb5a2;letter-spacing:0;line-height:1.45;margin-top:.5rem}.privacy-grid span:hover{background:rgba(226,174,132,.1);transform:translateY(-2px)}.passport-code{font:600 .72rem/1.7 monospace;letter-spacing:.1em;color:#e2ae84;margin-bottom:2rem}.passport-fields{display:grid;grid-template-columns:1fr 1fr;gap:1rem;border-top:1px solid rgba(226,174,132,.3);padding-top:1rem}.passport-fields span{display:grid;gap:.3rem;color:#f4e8dc}.passport-fields b{font-size:1.1rem;letter-spacing:.12em}.passport-fields small{color:#bfa493;letter-spacing:.16em}.passport-seal{position:absolute;right:2rem;bottom:1.5rem;border:1px solid #e2ae84;border-radius:50%;width:3rem;height:3rem;display:grid;place-items:center;color:#e2ae84;font-size:1.5rem;transform:rotate(-12deg)}.care-flower{font-size:5rem;line-height:1;color:#e2ae84;margin:.4rem 0 .7rem}.care-card p{font-family:Lora,Georgia,serif;color:#cdb5a2;line-height:1.6}.care-line{height:1px;background:#a8714e;width:70%;margin-top:1.4rem}.policy-toolbar{display:flex;justify-content:space-between;align-items:center;gap:1rem;margin:.5rem 0 1rem;flex-wrap:wrap}.policy-toolbar p{margin:0;font-size:.78rem;letter-spacing:.18em;color:var(--p-soft)}.policy-toggle{font:inherit;font-size:.85rem;color:var(--p-deep);background:transparent;border:1.5px solid var(--p-line);border-radius:999px;padding:.5rem 1rem;cursor:pointer}.policy-toggle:hover{border-color:var(--p-copper)}.policy-gates{display:grid;gap:1rem;padding-bottom:2rem}.policy-gate{background:var(--p-paper);border-radius:20px;box-shadow:0 18px 40px -30px rgba(120,80,55,.3);border:1px solid var(--p-line);overflow:hidden}.policy-gate summary{list-style:none;display:grid;grid-template-columns:auto 1fr auto;gap:1.1rem;align-items:center;padding:1.2rem clamp(1.1rem,3vw,1.8rem);cursor:pointer}.policy-gate summary::-webkit-details-marker{display:none}.policy-gate summary:focus-visible{outline:2px solid var(--p-deep);outline-offset:-4px;border-radius:20px}.policy-code{font-weight:600;font-size:.78rem;letter-spacing:.14em;color:var(--p-paper);background:var(--p-copper);border-radius:999px;padding:.45rem .75rem .35rem;min-width:3.1rem;text-align:center}.policy-gate h2{margin:0;font-size:clamp(1.08rem,1.9vw,1.35rem);font-weight:600;color:var(--p-ink)}.policy-chevron{width:34px;height:34px;border-radius:50%;border:1.5px solid var(--p-line);display:grid;place-items:center;transition:transform .3s,border-color .2s;color:var(--p-copper);font-size:1.35rem;line-height:1}.policy-gate[open] .policy-chevron{transform:rotate(180deg);border-color:var(--p-copper)}.policy-body{margin:0 clamp(1.1rem,3vw,1.8rem);padding:0 0 1.5rem;border-top:1.5px dashed var(--p-line)}.policy-tldr{font-family:Lora,Georgia,serif;font-style:italic;color:var(--p-deep);font-size:1.04rem;margin:1.1rem 0 .7rem;padding-left:.9rem;border-left:2px solid var(--p-copper)}.policy-body p,.policy-body li{font-family:Lora,Georgia,serif;color:var(--p-soft);line-height:1.78;font-size:1rem;max-width:70ch}.policy-body h1,.policy-body h2,.policy-body h3{font-family:inherit;color:var(--p-ink);font-size:1rem;margin:1.3rem 0 .2rem}.policy-body strong{color:var(--p-ink)}.policy-body a{color:var(--p-deep)}.policy-help{display:grid;grid-template-columns:1fr auto;gap:1.5rem;align-items:center;background:var(--p-board);color:#f4e8dc;border-radius:22px;padding:clamp(1.3rem,3vw,2rem);margin:1rem 0 2.5rem}.policy-help h2{margin:0 0 .3rem;font-size:1.3rem;font-weight:600;color:#e2ae84}.policy-help p{margin:0;font-family:Lora,Georgia,serif;font-style:italic;color:#cdb5a2}.policy-actions{display:flex;gap:.7rem;flex-wrap:wrap}.policy-actions a{display:inline-flex;align-items:center;text-decoration:none;font-size:.9rem;border-radius:999px;padding:.7rem 1rem;border:1.5px solid rgba(226,174,132,.5);color:#f4e8dc}.policy-actions a.primary{background:#e2ae84;border-color:#e2ae84;color:#2a1f19;font-weight:600}.policy-foot{border-top:1px solid var(--p-line);padding:1.4rem 0 2.2rem;color:var(--p-soft);font-size:.85rem;display:flex;justify-content:space-between;gap:1rem;flex-wrap:wrap}@media(max-width:900px){.policy-hero{grid-template-columns:1fr}.policy-help{grid-template-columns:1fr}}@media(max-width:620px){.policy-modern{margin-top:-1rem}.delivery-card ol{font-size:.6rem;gap:.35rem}.privacy-grid{grid-template-columns:1fr}.policy-gate summary{gap:.7rem;padding:.95rem}.policy-code{min-width:2.7rem}.policy-help{padding:1.2rem}.policy-actions a{font-size:.8rem}}@media(prefers-reduced-motion:reduce){.policy-gate *{transition:none!important}}
.policy-delivery .policy-visual{position:relative;display:grid;place-items:center}.policy-delivery .delivery-card{z-index:1;width:min(100%,600px);min-height:0;background:var(--p-paper);color:var(--p-ink);border:1px solid var(--p-line);border-radius:24px;padding:1.4rem 1.6rem 1.3rem;overflow:visible}.policy-delivery .delivery-card .visual-top{color:var(--p-copper);margin-bottom:.4rem}.policy-delivery .delivery-card .visual-top span:last-child{color:var(--p-soft)}.policy-delivery .delivery-card .delivery-title{font-family:Lora,Georgia,serif;font-size:1.45rem;font-weight:400;color:var(--p-ink);margin:0 0 1.3rem}.policy-delivery .delivery-route{align-items:end;margin:0 0 1.2rem}.policy-delivery .delivery-route span:last-child{text-align:right}.policy-delivery .delivery-route b{font-size:2rem;color:var(--p-copper);letter-spacing:0;line-height:1}.policy-delivery .delivery-route small{font-family:Lora,Georgia,serif;font-style:italic;color:var(--p-deep);font-size:.85rem}.policy-delivery .delivery-route>i{display:none}.policy-delivery .delivery-progress{height:6px;margin:0 11px;background:var(--p-line);overflow:visible}.policy-delivery .delivery-progress i{width:0;background:var(--p-copper);animation:delivery-fill 3.2s .4s cubic-bezier(.5,0,.2,1) forwards}.policy-delivery .delivery-steps{display:grid;grid-template-columns:repeat(5,1fr);gap:0;margin:-14px 0 0;padding:0;color:var(--p-soft);font-size:.72rem}.policy-delivery .delivery-steps li{max-width:none;text-align:center;line-height:1.3}.policy-delivery .delivery-steps li:before{content:"";display:block;width:22px;height:22px;margin:0 auto .55rem;border-radius:50%;background:var(--p-paper);border:3px solid var(--p-copper)}.policy-delivery .delivery-steps li.done:before{background:var(--p-copper)}.policy-delivery .delivery-facts{display:flex;flex-wrap:wrap;gap:.5rem;margin-top:1.2rem;padding-top:1rem;border-top:1.5px dashed var(--p-line)}.policy-delivery .delivery-facts span{font-size:.8rem;color:var(--p-deep);border:1.5px solid var(--p-line);border-radius:999px;padding:.38rem .75rem}.policy-delivery .delivery-bloom{position:absolute;right:-20px;top:-50px;width:clamp(110px,13vw,160px);aspect-ratio:1;border-radius:50%;object-fit:cover;object-position:right center;box-shadow:0 0 0 6px var(--p-bg),0 0 0 7.5px var(--p-copper)}@keyframes delivery-fill{to{width:100%}}@media(max-width:900px){.policy-delivery .delivery-bloom{display:none}}@media(max-width:520px){.policy-delivery .delivery-steps{font-size:.62rem}}@media(prefers-reduced-motion:reduce){.policy-delivery .delivery-progress i{width:100%;animation:none}}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const root = document.querySelector('[data-policy-page]');
    if (!root) return;
    const gates = [...root.querySelectorAll('.policy-gate')];
    const toggle = root.querySelector('[data-policy-toggle]');
    const sync = () => { const open = gates.length > 0 && gates.every(g => g.open); toggle.textContent = open ? 'Thu gọn tất cả' : 'Mở tất cả'; };
    toggle?.addEventListener('click', () => { const open = gates.every(g => g.open); gates.forEach(g => g.open = !open); sync(); });
    gates.forEach(g => g.addEventListener('toggle', sync));
    sync();
});
</script>
@endsection
