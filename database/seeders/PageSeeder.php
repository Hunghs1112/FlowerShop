<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Giới thiệu',
                'slug'  => 'gioi-thieu',
                'content' => 'VỀ LÂM NHIÊN THẢO

Lâm Nhiên Thảo là cửa hàng hoa tươi cao cấp chuyên cung cấp hoa nhập khẩu và hoa nội địa chất lượng tại TP. Hồ Chí Minh. Với niềm đam mê hoa và nghệ thuật cắm hoa, chúng tôi mang đến những bó hoa tinh tế, độc đáo cho mọi dịp đặc biệt trong cuộc sống của bạn.

CÂU CHUYỆN CỦA CHÚNG TÔI
Lâm Nhiên Thảo được thành lập bởi những người yêu hoa với mong muốn mang vẻ đẹp thuần túy của thiên nhiên vào từng không gian sống. Chúng tôi tin rằng một bó hoa đẹp không chỉ là món quà — đó là cầu nối cảm xúc, là lời nói thay cho những gì trái tim muốn thổ lộ.

SỨ MỆNH
Sứ mệnh của chúng tôi là cung cấp hoa tươi chất lượng cao nhất với dịch vụ tận tâm nhất, giúp mỗi dịp đặc biệt của bạn trở nên thật sự đáng nhớ — từ sinh nhật, kỷ niệm, khai trương, lễ cưới cho đến những món quà bất ngờ gửi đến người thân yêu.

TẠI SAO CHỌN LÂM NHIÊN THẢO

Chất lượng đảm bảo: Chúng tôi chỉ lựa chọn những bông hoa tươi nhất từ các nhà cung cấp uy tín trong và ngoài nước, kiểm soát chặt chẽ từ khâu nhập hàng đến khi giao đến tay bạn.

Đội ngũ chuyên nghiệp: Các florist của chúng tôi được đào tạo bài bản, am hiểu ngôn ngữ của hoa và xu hướng thiết kế hiện đại. Mỗi bó hoa là một tác phẩm được tạo ra với tình yêu và sự tỉ mỉ.

Đa dạng lựa chọn: Từ hoa hồng nhập khẩu Ecuador, hoa tulip Hà Lan, hoa cẩm tú cầu cho đến các loài hoa nhiệt đới độc đáo — chúng tôi luôn cập nhật bộ sưu tập để bạn có nhiều lựa chọn phù hợp với phong cách và ngân sách.

Giao hàng tận nơi: Dịch vụ giao hoa tận nơi trong ngày trên toàn TP. Hồ Chí Minh, đảm bảo hoa đến tay người nhận trong tình trạng tươi và đẹp nhất.

Tư vấn miễn phí: Đội ngũ chúng tôi sẵn sàng tư vấn lựa chọn hoa phù hợp cho từng dịp, từng phong cách và ngân sách của bạn — hoàn toàn miễn phí qua Zalo hoặc điện thoại.

CAM KẾT CỦA CHÚNG TÔI
Chúng tôi cam kết mỗi đơn hàng đều được thực hiện với sự chăm chút tối đa. Nếu bạn không hài lòng với sản phẩm, chúng tôi sẵn sàng lắng nghe và giải quyết thỏa đáng nhất.

Hãy để Lâm Nhiên Thảo đồng hành cùng bạn trong những khoảnh khắc đáng nhớ nhất của cuộc đời.',
            ],
            [
                'title' => 'Chính sách bảo mật',
                'slug'  => 'chinh-sach-bao-mat',
                'content' => 'CHÍNH SÁCH BẢO MẬT

Cập nhật lần cuối: Tháng 9, 2026

Lâm Nhiên Thảo cam kết bảo vệ quyền riêng tư và thông tin cá nhân của quý khách khi sử dụng website của chúng tôi. Chính sách này giải thích cách chúng tôi thu thập, sử dụng và bảo vệ dữ liệu của bạn.

1. THÔNG TIN CHÚNG TÔI THU THẬP
Chúng tôi thu thập các thông tin mà bạn cung cấp trực tiếp khi sử dụng dịch vụ, bao gồm:
- Họ và tên
- Số điện thoại và địa chỉ email
- Địa chỉ giao hàng
- ID Zalo (nếu có)
- Nội dung tin nhắn và yêu cầu đặt hàng

2. MỤC ĐÍCH SỬ DỤNG THÔNG TIN
Thông tin thu thập được sử dụng để:
- Xác nhận và xử lý đơn hàng của bạn
- Liên hệ tư vấn và hỗ trợ sau mua hàng
- Giao hoa đúng địa chỉ và thời gian yêu cầu
- Cải thiện chất lượng sản phẩm và dịch vụ

3. CHIA SẺ THÔNG TIN
Chúng tôi không bán, cho thuê hay chia sẻ thông tin cá nhân của bạn với bên thứ ba vì mục đích thương mại. Thông tin chỉ được chia sẻ với đối tác vận chuyển nội bộ để thực hiện giao hàng.

4. BẢO MẬT DỮ LIỆU
Chúng tôi áp dụng các biện pháp kỹ thuật và tổ chức phù hợp để bảo vệ thông tin của bạn khỏi truy cập trái phép, thay đổi hoặc tiết lộ.

5. QUYỀN CỦA BẠN
Bạn có quyền yêu cầu xem, chỉnh sửa hoặc xóa thông tin cá nhân của mình bất kỳ lúc nào bằng cách liên hệ với chúng tôi.

6. THAY ĐỔI CHÍNH SÁCH
Chúng tôi có thể cập nhật chính sách này theo thời gian. Mọi thay đổi sẽ được thông báo trên trang web.

7. LIÊN HỆ
Nếu bạn có bất kỳ câu hỏi nào về chính sách bảo mật, vui lòng liên hệ với chúng tôi qua số điện thoại hoặc Zalo để được hỗ trợ.',
            ],
            [
                'title' => 'Điều khoản dịch vụ',
                'slug'  => 'dieu-khoan-dich-vu',
                'content' => 'ĐIỀU KHOẢN DỊCH VỤ

Cập nhật lần cuối: Tháng 9, 2026

Vui lòng đọc kỹ các điều khoản dịch vụ dưới đây trước khi sử dụng website Lâm Nhiên Thảo. Việc truy cập và sử dụng website đồng nghĩa với việc bạn chấp thuận các điều khoản này.

1. CHẤP THUẬN ĐIỀU KHOẢN
Bằng cách sử dụng website này, bạn đồng ý bị ràng buộc bởi các Điều khoản Dịch vụ hiện hành. Nếu bạn không đồng ý, vui lòng không sử dụng dịch vụ của chúng tôi.

2. SẢN PHẨM VÀ DỊCH VỤ
Chúng tôi cố gắng hiển thị hình ảnh và mô tả sản phẩm chính xác nhất có thể. Tuy nhiên, do đặc tính tự nhiên của hoa tươi, màu sắc và hình dáng thực tế có thể khác biệt đôi chút so với hình ảnh. Chúng tôi sẽ luôn đảm bảo chất lượng và sự tinh tế trong từng bó hoa.

3. ĐẶT HÀNG VÀ THANH TOÁN
- Mọi đơn hàng đều cần được xác nhận qua Zalo hoặc điện thoại
- Chúng tôi chấp nhận thanh toán tiền mặt và chuyển khoản ngân hàng
- Đơn hàng chỉ được xác nhận sau khi thanh toán hoặc theo thỏa thuận
- Giá sản phẩm có thể thay đổi tùy theo mùa và nguồn cung hoa nhập khẩu

4. GIAO HÀNG
- Thời gian và phí giao hàng sẽ được thỏa thuận khi đặt hàng
- Chúng tôi không chịu trách nhiệm với các trường hợp chậm trễ do thiên tai, kẹt xe hoặc sự kiện ngoài tầm kiểm soát
- Khách hàng cần có mặt tại địa điểm giao hàng hoặc thông báo trước cho người nhận thay

5. ĐỔI TRẢ VÀ HOÀN TIỀN
Do tính chất của hoa tươi dễ hỏng, chúng tôi không nhận đổi trả sau khi giao hàng. Tuy nhiên, nếu bạn nhận được sản phẩm không đúng yêu cầu hoặc bị hỏng trong quá trình vận chuyển, vui lòng liên hệ ngay để chúng tôi hỗ trợ giải quyết.

6. GIỚI HẠN TRÁCH NHIỆM
Lâm Nhiên Thảo không chịu trách nhiệm về các thiệt hại gián tiếp, ngẫu nhiên hay hệ quả phát sinh từ việc sử dụng sản phẩm và website của chúng tôi ngoài phạm vi quy định của pháp luật.

7. THAY ĐỔI ĐIỀU KHOẢN
Chúng tôi có quyền sửa đổi các điều khoản này bất kỳ lúc nào. Mọi thay đổi có hiệu lực ngay khi đăng tải lên website. Việc tiếp tục sử dụng dịch vụ sau khi thay đổi đồng nghĩa bạn chấp thuận điều khoản mới.

8. LIÊN HỆ
Nếu có thắc mắc về Điều khoản Dịch vụ, vui lòng liên hệ chúng tôi qua số điện thoại hoặc Zalo để được hỗ trợ.',
            ],
            [
                'title' => 'Chính sách giao hàng',
                'slug'  => 'chinh-sach-giao-hang',
                'content' => 'CHÍNH SÁCH GIAO HÀNG

Cập nhật lần cuối: Tháng 9, 2026

LNT cung cấp dịch vụ giao hoa tận nơi, với phương thức vận chuyển được lựa chọn phù hợp theo từng đơn hàng và khu vực nhận hàng.

1. KHU VỰC GIAO HÀNG
LNT hiện hỗ trợ giao hàng tại **TP. Hà Nội và một số khu vực lân cận**.

Phạm vi giao hàng có thể thay đổi tùy theo địa chỉ, thời điểm và điều kiện vận chuyển. Vui lòng cung cấp đầy đủ địa chỉ khi đặt hàng để LNT kiểm tra và xác nhận khả năng giao nhận.

2. THỜI GIAN GIAO HÀNG
### Giao hàng tiêu chuẩn
LNT nhận giao hàng từ **Thứ Hai đến Thứ Bảy, 08:00–17:00**.

Thời gian giao cụ thể được xác nhận dựa trên thời điểm đặt hàng, tình trạng sản phẩm và khu vực nhận hàng.

### Giao hàng trong ngày
Dịch vụ giao trong ngày áp dụng đối với **các sản phẩm đang có sẵn** và đơn hàng được LNT xác nhận trong ngày.

- Đơn hàng cần được **đặt và xác nhận trước 14:00** để được xem xét giao trong ngày.
- Đơn đặt sau 14:00 có thể được chuyển sang ngày tiếp theo, tùy tình trạng sản phẩm và khả năng giao hàng.
- Thời gian giao thực tế phụ thuộc vào **thời điểm xác nhận đơn, thời gian chuẩn bị hoa, khoảng cách giao hàng và tình trạng vận chuyển**.
- Yêu cầu giao trong ngày **không đồng nghĩa với giao ngay hoặc giao trong một khung giờ cố định**, trừ khi LNT đã xác nhận cụ thể.
- Đối với các đơn cần giao gấp, khách hàng vui lòng liên hệ trực tiếp qua **Zalo hoặc điện thoại** để LNT kiểm tra khả năng đáp ứng trước khi đặt hàng.
- Một số sản phẩm **đặt trước, hoa theo mùa, hoa nhập khẩu hoặc sản phẩm cần chuẩn bị riêng** có thể không áp dụng dịch vụ giao trong ngày.

### Giao theo khung giờ yêu cầu
LNT có thể hỗ trợ giao theo khung giờ cụ thể tùy từng đơn hàng. Yêu cầu này cần được xác nhận trước và **có thể phát sinh phụ phí**.

### Chủ Nhật và ngày lễ
LNT có thể hỗ trợ giao hàng vào Chủ Nhật hoặc ngày lễ tùy lịch vận hành và khả năng đáp ứng tại từng thời điểm. Vui lòng liên hệ trước để được xác nhận.

Thời gian giao dự kiến có thể thay đổi do **tình hình giao thông, thời tiết hoặc các yếu tố khách quan khác**.

3. PHÍ GIAO HÀNG
Phí giao hàng được xác định dựa trên **khoảng cách, khu vực giao nhận, thời điểm và hình thức vận chuyển**.

Chi phí giao hàng cụ thể sẽ được LNT thông báo và xác nhận cùng đơn hàng trước khi giao.

Trong một số chương trình hoặc đơn hàng đạt giá trị nhất định, LNT có thể áp dụng chính sách hỗ trợ phí giao hàng theo từng thời điểm.

4. QUY TRÌNH GIAO HÀNG
Sau khi đơn hàng được xác nhận:

1. LNT xác nhận thông tin sản phẩm, địa chỉ và thời gian giao hàng.
2. Đơn hàng được chuẩn bị và bàn giao cho đơn vị hoặc nhân viên giao hàng phù hợp.
3. Người giao hàng có thể liên hệ trước khi đến địa chỉ nhận.
4. Khách hàng vui lòng đảm bảo có người nhận tại địa chỉ đã cung cấp.
5. Sau khi giao thành công, đơn hàng được xem là hoàn tất.

Đối với các đơn hàng có yêu cầu giao tại **lễ tân, bảo vệ, quầy tiếp nhận hoặc khu vực trung gian**, khách hàng vui lòng thông báo trước để LNT ghi nhận khi điều phối giao hàng.

5. TIẾP NHẬN VÀ KIỂM TRA HOA
Hoa là sản phẩm tươi và có tính chất đặc thù. LNT kiểm tra tình trạng sản phẩm trước khi giao và đóng gói phù hợp với từng loại hoa.

Khi nhận hàng, khách hàng vui lòng kiểm tra tình trạng hoa và thông báo cho LNT trong thời gian sớm nhất nếu phát hiện bất thường.

Hướng dẫn chăm sóc sẽ được cung cấp tùy theo loại hoa và hình thức sản phẩm.

6. YÊU CẦU ĐẶC BIỆT
Đối với các địa điểm như **bệnh viện, trường học, tòa nhà văn phòng, khu dân cư có kiểm soát ra vào** hoặc các địa điểm có quy định riêng về giao nhận, khách hàng vui lòng cung cấp đầy đủ thông tin cần thiết.

Các yêu cầu về thời gian, người nhận, điểm giao hoặc quy trình ra vào cần được thông báo trước để LNT kiểm tra khả năng đáp ứng.

7. GIAO HÀNG KHÔNG THÀNH CÔNG
Đơn hàng có thể phát sinh giao hàng không thành công trong trường hợp:

- Không liên lạc được với người nhận.
- Địa chỉ hoặc thông tin giao hàng không chính xác.
- Người nhận từ chối nhận hoặc không có mặt tại địa chỉ đã đăng ký.
- Địa điểm nhận không thể tiếp cận tại thời điểm giao.

Trong trường hợp này, LNT sẽ liên hệ với khách hàng để thống nhất phương án xử lý.

Nếu cần giao lại, **phí giao hàng phát sinh có thể được áp dụng** tùy nguyên nhân và điều kiện của đơn hàng.

Đối với hoa tươi, thời gian và điều kiện bảo quản có thể ảnh hưởng trực tiếp đến chất lượng sản phẩm. Vì vậy, LNT không đảm bảo giữ nguyên tình trạng ban đầu của hoa trong thời gian chờ xử lý giao lại.

8. LIÊN HỆ
Để kiểm tra phạm vi giao hàng, chi phí hoặc yêu cầu giao nhận đặc biệt, vui lòng liên hệ:

- Điện thoại / Zalo: [0869 308 993](tel:0869308993)
- Email: [support@lamnhienthao.com](mailto:support@lamnhienthao.com)

LNT sẽ xác nhận thông tin giao hàng trước khi đơn hàng được thực hiện.',
            ],

HỖ TRỢ KHÁCH HÀNG
Nếu có bất kỳ thắc mắc nào, đừng ngại liên hệ với chúng tôi qua:
- Điện thoại / Zalo: 0909999999
- Email: contact@lamnhienthao.vn
- Hoặc điền vào form liên hệ trên trang web

Chúng tôi luôn sẵn sàng hỗ trợ bạn!',
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                [
                    'title'     => $pageData['title'],
                    'content'   => $pageData['content'],
                    'is_active' => true,
                ]
            );
        }
    }
}
