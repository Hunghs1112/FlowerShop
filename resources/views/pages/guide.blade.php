@extends('layouts.app')

@section('title', 'Hướng dẫn đặt hàng')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/guide.css') }}">
@endpush
<main class="page-guide">
    <div class="guide-wrap">
        <section class="guide-hero" aria-labelledby="guide-title">
            <div class="guide-copy">
                <a class="guide-mark" href="{{ route('home') }}" aria-label="Về trang chủ">
                    <span class="guide-mark-flower">✽</span><span>LNT</span>
                </a>
                <p class="guide-eyebrow">HỖ TRỢ KHÁCH HÀNG</p>
                <h1 id="guide-title">Hướng dẫn<br>đặt hàng</h1>
                <p class="guide-lead">Năm bước đơn giản để những đoá hoa bay đến không gian của bạn. Chạm vào từng chặng trên lịch trình để xem chi tiết.</p>
            </div>

            <div class="guide-visual" aria-label="Minh họa lịch trình đặt hoa">
                <img class="guide-tk" src="{{ asset('images/pages/page-header-4-1791166033.jpg') }}" alt="Hoa tươi Lâm Nhiên Thảo">
                <div class="guide-itin">
                    <div class="guide-ih">
                        <span>LỊCH TRÌNH · ITINERARY</span>
                        <span>LNT·01</span>
                    </div>
                    <ol class="guide-legs">
                        <span class="guide-plane" aria-hidden="true"></span>
                        <li>
                            <button type="button" class="guide-leg" data-target="g1">
                                <i aria-hidden="true"></i>
                                <span><small>01 · CHECK-IN</small><b>Chọn hoa</b><em>Chọn bó hoa bạn yêu thích</em></span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="guide-leg" data-target="g2">
                                <i aria-hidden="true"></i>
                                <span><small>02 · HÀNH LÝ</small><b>Thêm vào giỏ hàng</b><em>Gửi bó hoa vào giỏ của bạn</em></span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="guide-leg" data-target="g3">
                                <i aria-hidden="true"></i>
                                <span><small>03 · LÊN MÁY BAY</small><b>Thanh toán</b><em>Tiền mặt hoặc chuyển khoản</em></span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="guide-leg" data-target="g4">
                                <i aria-hidden="true"></i>
                                <span><small>04 · KHAI BÁO</small><b>Thông tin nhận hàng</b><em>Người nhận, địa chỉ, thời gian</em></span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="guide-leg" data-target="g5">
                                <i aria-hidden="true"></i>
                                <span><small>05 · HẠ CÁNH</small><b>Nhận hoa</b><em>Kiểm tra hoa ngay khi nhận</em></span>
                            </button>
                        </li>
                    </ol>
                    <div class="guide-ifoot">
                        <div><small>TỪ</small>Vườn hoa</div>
                        <div style="text-align:right"><small>ĐẾN</small>Không gian của bạn</div>
                    </div>
                </div>
            </div>
        </section>

        <div class="guide-toolbar">
            <p>05 CHẶNG</p>
            <button type="button" class="guide-toggle" data-guide-toggle>Mở tất cả</button>
        </div>

        <section class="guide-gates" aria-label="Nội dung hướng dẫn đặt hàng">

            <details class="guide-gate" id="g1" open>
                <summary>
                    <span class="guide-code">01</span>
                    <h2>Chọn hoa</h2>
                    <span class="guide-chev" aria-hidden="true">⌄</span>
                </summary>
                <div class="guide-body">
                    <p class="guide-tldr">Chọn hoa trên website; nếu có yêu cầu riêng về màu sắc hay đặc điểm hoa, hãy trao đổi với LNT trước khi đặt.</p>
                    <p>Xem các danh mục <strong>Sản phẩm</strong> hoặc <strong>Hộp hoa bí ẩn</strong> để chọn bó hoa phù hợp.</p>
                    <ul>
                        <li>Hoa tươi là sản phẩm tự nhiên nên màu sắc, kích thước, độ nở và số lượng cành thực tế có thể khác đôi chút so với hình ảnh trên website.</li>
                        <li>Với hoa nhập khẩu, nguồn cung có thể thay đổi theo mùa vụ, thời tiết và vận chuyển. Nếu sản phẩm không còn sẵn hoặc có thay đổi đáng kể, LNT sẽ chủ động trao đổi với bạn trước khi thực hiện đơn.</li>
                        <li>Nếu có yêu cầu cụ thể về đặc điểm của hoa, vui lòng trao đổi với LNT trước thời điểm đặt hàng.</li>
                    </ul>
                </div>
            </details>

            <details class="guide-gate" id="g2">
                <summary>
                    <span class="guide-code">02</span>
                    <h2>Thêm vào giỏ hàng</h2>
                    <span class="guide-chev" aria-hidden="true">⌄</span>
                </summary>
                <div class="guide-body">
                    <p class="guide-tldr">Thêm bó hoa đã chọn vào giỏ và kiểm tra lại trước khi thanh toán.</p>
                    <p>Bấm <strong>Thêm vào giỏ hàng</strong> ở trang sản phẩm. Trong giỏ hàng, bạn có thể kiểm tra lại sản phẩm và số lượng trước khi chuyển sang bước thanh toán.</p>
                    <p>Giá sản phẩm có thể thay đổi tùy theo mùa vụ và nguồn cung hoa, đặc biệt đối với hoa nhập khẩu.</p>
                </div>
            </details>

            <details class="guide-gate" id="g3">
                <summary>
                    <span class="guide-code">03</span>
                    <h2>Thanh toán</h2>
                    <span class="guide-chev" aria-hidden="true">⌄</span>
                </summary>
                <div class="guide-body">
                    <p class="guide-tldr">Thanh toán bằng tiền mặt hoặc chuyển khoản; đơn được xác nhận chính thức sau khi hoàn tất thanh toán.</p>
                    <ul>
                        <li>LNT chấp nhận thanh toán bằng <strong>tiền mặt</strong> hoặc <strong>chuyển khoản ngân hàng</strong>.</li>
                        <li>Đơn hàng chỉ được xác nhận chính thức sau khi hoàn tất thanh toán hoặc theo thỏa thuận cụ thể giữa hai bên.</li>
                        <li>Mọi đơn hàng cần được xác nhận qua <strong>Zalo hoặc điện thoại</strong> trước khi thực hiện.</li>
                    </ul>
                </div>
            </details>

            <details class="guide-gate" id="g4">
                <summary>
                    <span class="guide-code">04</span>
                    <h2>Điền thông tin nhận hàng</h2>
                    <span class="guide-chev" aria-hidden="true">⌄</span>
                </summary>
                <div class="guide-body">
                    <p class="guide-tldr">Cung cấp đầy đủ người nhận, địa chỉ và thời gian; giao trong ngày khi đơn được đặt và xác nhận trước 14:00.</p>
                    <ul>
                        <li>Vui lòng cung cấp <strong>đầy đủ địa chỉ</strong> để LNT kiểm tra và xác nhận khả năng giao nhận. LNT hiện giao tại <strong>TP. Hà Nội và một số khu vực lân cận</strong>.</li>
                        <li>Thời gian giao tiêu chuẩn: <strong>Thứ Hai đến Thứ Bảy, 08:00–17:00</strong>. Giao trong ngày áp dụng với sản phẩm có sẵn và đơn được <strong>đặt, xác nhận trước 14:00</strong>.</li>
                        <li>Nếu cần giao theo khung giờ cụ thể, giao gấp, hoặc giao vào Chủ Nhật, ngày lễ, vui lòng liên hệ trước để LNT xác nhận.</li>
                        <li>Nếu giao tại lễ tân, bảo vệ, bệnh viện, trường học, tòa nhà văn phòng hoặc khu vực có kiểm soát ra vào, vui lòng thông báo trước.</li>
                        <li>Thời gian và phí giao hàng được LNT thông báo và xác nhận cùng đơn hàng.</li>
                    </ul>
                    <p>Xem chi tiết tại <a href="{{ route('policy', 'chinh-sach-giao-hang') }}">Chính sách giao hàng</a>.</p>
                </div>
            </details>

            <details class="guide-gate" id="g5">
                <summary>
                    <span class="guide-code">05</span>
                    <h2>Nhận hoa</h2>
                    <span class="guide-chev" aria-hidden="true">⌄</span>
                </summary>
                <div class="guide-body">
                    <p class="guide-tldr">Kiểm tra hoa ngay khi nhận, quay video lúc mở hộp và phản hồi trong 02 giờ nếu có vấn đề.</p>
                    <ul>
                        <li>Vui lòng đảm bảo có người nhận tại địa chỉ đã cung cấp vào thời gian đã hẹn.</li>
                        <li><strong>Kiểm tra hoa ngay khi nhận.</strong> Nên quay hình ảnh/video trong quá trình mở hộp.</li>
                        <li>Tháo nilon và đưa hoa ra khỏi thùng/gói sau khi nhận, bảo quản theo hướng dẫn chăm sóc đi kèm.</li>
                        <li>Mọi phản hồi về chất lượng cần được gửi đến LNT <strong>trong 02 giờ</strong> kể từ khi hoàn tất giao hàng. Giữ nguyên hiện trạng hoa cho đến khi trao đổi với CSKH.</li>
                    </ul>
                    <p>Xem chi tiết tại <a href="{{ route('policy', 'chinh-sach-doi-tra') }}">Chính sách của chúng tôi</a>.</p>
                </div>
            </details>

        </section>

        <section class="guide-help" aria-labelledby="guide-help-title">
            <div>
                <h2 id="guide-help-title">Cần hỗ trợ?</h2>
                <p>Lâm Nhiên Thảo luôn sẵn sàng lắng nghe và đồng hành cùng bạn.</p>
            </div>
            <div class="guide-actions">
                <a class="guide-action-primary" href="https://zalo.me/0869308993" rel="noopener" target="_blank">Zalo · 0869 308 993</a>
                <a class="guide-action" href="tel:0869308993">Gọi 0869 308 993</a>
                <a class="guide-action" href="mailto:support@lamnhienthao.com">support@lamnhienthao.com</a>
                <a class="guide-action" href="{{ route('contact') }}">Trang liên hệ →</a>
            </div>
        </section>

        <footer class="guide-foot">
            <span>© Lâm Nhiên Thảo</span>
            <span>Từ những vùng đất đặc biệt đến những nơi tuyệt đẹp</span>
        </footer>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const root = document.querySelector('.page-guide');
    if (!root) return;

    // Toggle all accordion sections
    const gates = [...root.querySelectorAll('.guide-gate')];
    const toggle = root.querySelector('[data-guide-toggle]');

    const syncToggle = () => {
        const allOpen = gates.length > 0 && gates.every(g => g.open);
        toggle.textContent = allOpen ? 'Thu gọn tất cả' : 'Mở tất cả';
    };

    toggle?.addEventListener('click', () => {
        const allOpen = gates.every(g => g.open);
        gates.forEach(g => { g.open = !allOpen; });
        syncToggle();
    });

    gates.forEach(g => g.addEventListener('toggle', syncToggle));
    syncToggle();

    // Leg buttons open corresponding accordion + scroll
    root.querySelectorAll('.guide-leg').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = root.querySelector('#' + btn.dataset.target);
            if (!target) return;
            target.open = true;
            target.scrollIntoView({ block: 'start' });
            target.querySelector('summary')?.focus({ preventScroll: true });
        });
    });
});
</script>
@endsection
