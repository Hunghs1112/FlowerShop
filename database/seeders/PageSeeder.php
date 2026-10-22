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
                'content_en' => 'About Lam Nhiên Thảo

Lam Nhiên Thảo is a premium fresh flower shop specializing in imported and domestic fresh flowers located in Ho Chi Minh City. With a passion for flowers and flower arranging art, we bring delicate and unique flower bouquets for every special occasion in your life.

Our Mission
We are established by flower lovers with the desire to bring the pure beauty of nature into every living space. We believe a beautiful bouquet is not just a gift — it is an emotional connection, words when the heart wishes to convey.

Our Mission
Our mission is to provide the highest quality fresh flowers with the most attentive service, making every special occasion of yours truly memorable — from birthdays, anniversaries, grand openings, weddings to surprising gifts to your loved ones.

Why Choose Us
Quality Assurance: We only select the freshest flowers from trusted domestic and international suppliers, strictly controlled from procurement to delivery to your hands.

Professional Team: Our florists are thoroughly trained, understanding the language of flowers and modern design trends. Each bouquet is a work of art created with love and meticulous care.

Diverse Selection: From Ecuadorian imported roses, Dutch tulips to unique tropical flowers — we always update our collection so you have many options suitable for your style and budget.

Doorstep Delivery: Door-to-door delivery service within Ho Chi Minh City on the same day, ensuring the flowers arrive fresh and beautiful to the recipient.

Free Consultation: Our team is ready to advise you on choosing the right flower for every occasion, style, and budget — completely free via Zalo or phone.

Our Commitment
We are committed to executing every order with maximum care. If you are not satisfied with the product, we are ready to listen and resolve it to your complete satisfaction.

Let Lam Nhiên Thảo accompany you in the most memorable moments of your life.',
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
                'content_en' => 'Privacy Policy

Updated: September 2026

Lam Nhiên Thảo is committed to protecting the privacy and personal data of our customers when using our website. This policy explains how we collect, use, and protect your data.

1. INFORMATION WE COLLECT
We collect information that you provide directly when using our service, including:
- Full name
- Phone number and email address
- Delivery address
- Zalo ID (if any)
- Message content and order requests

2. PURPOSE OF USE
The collected information is used to:
- Confirm and process your order
- Consult and support after-sales
- Deliver flowers to the correct address and time
- Improve product and service quality

3. INFORMATION SHARING
We do not sell, rent, or share your personal information with third parties for commercial purposes. Information is only shared with internal shipping partners to fulfill deliveries.

4. DATA SECURITY
We apply appropriate technical and organizational measures to protect your information from unauthorized access, modification, or disclosure.

5. YOUR RIGHTS
You have the right to view, edit, or delete your personal data at any time by contacting us.

6. POLICY UPDATES
We may update this policy over time. All changes will be announced on the website.

7. CONTACT
If you have any questions about this privacy policy, please contact us via phone or Zalo for support.',
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

5. ĐỔI TRẢ VÀ HOÀN TIÊN
Do tính chất của hoa tươi dễ hỏng, chúng tôi không nhận đổi trả sau khi giao hàng. Tuy nhiên, nếu bạn nhận được sản phẩm không đúng yêu cầu hoặc bị hỏng trong quá trình vận chuyển, vui lòng liên hệ ngay để chúng tôi hỗ trợ giải quyết.

6. GIỚI HẠN TRÁCH NHIỆM
Lâm Nhiên Thảo không chịu trách nhiệm về các thiệt hại gián tiếp, ngẫu nhiên hay hệ quả phát sinh từ việc sử dụng sản phẩm và website của chúng tôi ngoài phạm vi quy định của pháp luật.

7. THAY ĐỔI ĐIỀU KHOẢN
Chúng tôi có quyền sửa đổi các điều khoản này bất kỳ lúc nào. Mọi thay đổi có hiệu lực ngay khi đăng tải lên website. Việc tiếp tục sử dụng dịch vụ sau khi thay đổi đồng nghĩa bạn chấp thuận điều khoản mới.

8. LIÊN HỆ
Nếu có thắc mắc về Điều khoản Dịch vụ, vui lòng liên hệ chúng tôi qua số điện thoại hoặc Zalo để được hỗ trợ.',
                'content_en' => 'Terms of Service

Updated: September 2026

Please read the following Terms of Service carefully before using the Lam Nhiên Thảo website. Accessing and using the website implies your acceptance of these Terms.

1. ACCEPTANCE OF TERMS
By using this website, you agree to be bound by the current Terms of Service. If you do not agree, please do not use our service.

2. PRODUCTS AND SERVICES
We strive to display the most accurate product images and descriptions possible. However, due to the natural characteristics of fresh flowers, the actual colors and shapes may differ slightly from the images. We will always ensure quality and elegance in every bouquet.

3. ORDERING AND PAYMENT
- All orders must be confirmed via Zalo or phone
- We accept cash and bank transfer payments
- Orders are only confirmed after payment or by agreement
- Product prices may vary depending on the season and flower import source

4. DELIVERY
- Delivery time and fees will be agreed upon when placing the order
- We are not responsible for delays caused by natural disasters, traffic jams, or events beyond our control
- Customers must be present at the delivery address or notify the recipient in advance

5. RETURNS AND REFUNDS
Due to the perishable nature of fresh flowers, we do not accept returns after delivery. However, if you receive a product that does not match your request or is damaged during transport, please contact us immediately for support.

6. LIMITATION OF LIABILity
Lam Nhiên Thảo is not liable for indirect, random, or consequential damages arising from the use of products and website beyond the scope prescribed by law.

7. TERM MODIFICATIONS
We have the right to modify these terms at any time. All changes take effect immediately upon posting to the website. Continued use of the service after changes means you accept the new terms.

8. CONTACT
If you have any questions about the Terms of Service, please contact us via phone or Zalo for support.',
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

Thời gian giao cụ thể được xác định dựa trên thời điểm đặt hàng, tình trạng sản phẩm và khu vực nhận hàng.

### Giao trong ngày
Dịch vụ giao trong ngày áp dụng đối với **các sản phẩm đang có sẵn** và đơn hàng được LNT xác nhận trong ngày.

- Đơn hàng cần được **đặt và xác nhận trước 14:00** để được xem xét giao trong ngày.
- Đơn đặt sau 14:00 có thể được chuyển sang ngày tiếp theo, tùy tình trạng sản phẩm và khả năng giao hàng.
- Thời gian giao thực tế phụ thuộc vào **thời điểm xác nhận đơn, thời gian chuẩn bị hoa, khoảng cách giao hàng và tình trạng vận chuyển**.
- Yêu cầu giao trong ngày **không đồng nghĩa với giao ngay hoặc giao trong một khung giờ cố định**, trừ khi LNT đã xác nhận cụ thể.
- Đối với các đơn cần giao gấp, khách hàng vui lòng liên hệ trực tiếp qua **Zalo hoặc điện thoại** để LNT kiểm tra khả năng đáp ứng trước khi đặt hàng.
- Một số sản phẩm **đặt trước, hoa theo mùa, hoa nhập khẩu hoặc sản phẩm cần chuẩn bị riêng** có thể không áp dụng dịch vụ giao trong ngày.

### Chủ Nhật và ngày lễ
LNT có thể hỗ trợ giao hàng vào Chủ Nhật hoặc ngày lễ tùy lịch vận hành và khả năng đáp ứng tại từng thời điểm. Vui lòng liên hệ trước để được xác nhận.

Thời gian giao dự kiến có thể thay đổi do **tình hình giao thông, thời tiết hoặc các yếu tố khách quan khác**.

3. PHÍ GIAO HÀNG
Phí giao hàng được xác định dựa trên **khoảng cách, khu vực giao nhận, thời điểm và hình thức vận chuyển**.

Chi phí giao hàng cụ thể sẽ được LNT thông báo và xác nhận cùng đơn hàng trước khi giao.

In some programs or orders reaching a certain value, Lam Nhiên Thảo may apply a shipping fee support policy from time to time.

4. QUÊN TRÌNH GIAO HÀNG
After the order is confirmed:

1. Lam Nhiên Thảo confirms product, address, and delivery time information.
2. The order is prepared and handed over to the suitable delivery person or employee.
3. The delivery person may contact the recipient before arriving at the delivery address.
4. Customers must ensure someone is present at the provided delivery address.
5. After successful delivery, the order is considered complete.

For delivery requests at **lobby, ceremony, reception desk, or intermediate areas**, customers must notify in advance for Lam Nhiên Thảo to record during delivery coordination.

5. TIẾP NHẬN VÀ KIỂM TRA HOA
Fresh flowers are products with unique characteristics. Lam Nhiên Thảo checks the product condition before delivery and packages appropriately for each type of flower.

Upon receipt, customers should check the flower condition and notify Lam Nhiên Thảo as soon as possible if any abnormality is detected.

Care instructions will be provided depending on the flower type and product form.

6. SPECIAL REQUESTS
For requests at **lobby, ceremony, reception desk, or intermediate areas**, customers must notify in advance for Lam Nhiên Thảo to coordinate delivery.

Specific requests regarding time, recipient, delivery point, or process must be notified in advance for Lam Nhiên Thảo to check deliverability.

7. DELIVERY FAILURE
Orders may fail to deliver in the following situations:

- Inability to contact the recipient.
- Incorrect or inaccurate delivery address or information.
- Recipient refuses to accept or is not present at the registered delivery address.
- Delivery location is not accessible at the time of delivery.

In this case, Lam Nhiên Thảo will contact the customer to agree on a resolution method.

If re-delivery is needed, **delivery fees incurred may apply** depending on the cause and conditions of the delivery.

For fresh flowers, the time and storage conditions can directly affect product quality. Therefore, Lam Nhiên Thảo does not guarantee preserving the initial condition during re-delivery coordination.

8. CONTACT
To check delivery coverage, fees, or special delivery requests, please contact:

- Phone / Zalo: [0869 308 993](tel:0869308993)
- Email: [support@lamnhienthao.com](mailto:support@lamnhienthao.com)

Lam Nhiên Thảo will confirm delivery information before the order is fulfilled.',
                'content_en' => 'Shipping Policy

Updated: September 2026

Lam Nhiên Thảo provides doorstep delivery service, with the transport method selected suitable for each order and delivery area.

1. DELIVERY AREA
Lam Nhiên Thảo currently supports delivery in **Hanoi City and some surrounding areas**.

The delivery scope may vary depending on the address, time, and transport conditions. Please provide a complete address when placing an order for Lam Nhiên Thảo to check and confirm delivery capability.

2. DELIVERY SCHEDULE
### Standard Delivery
Lam Nhiên Thâle accepts delivery from **Monday to Saturday, 08:00–17:00**.

The specific delivery time is determined based on the order placement time, product condition, and delivery area.

### Next-Day Delivery
Next-day delivery service applies to **available products** and orders confirmed by Lam Nhiên Thâle on the same day.

- Orders must be **placed and confirmed before 14:00** to be considered for next-day delivery.
- Orders placed after 14:00 may be moved to the next day, depending on product condition and delivery capability.
- Actual delivery time depends on **order confirmation time, flower preparation time, delivery distance, and transport condition**.
- Next-day delivery requests are not equivalent to immediate delivery or delivery within a fixed time slot, unless Lam Nhiên Thâle has specifically confirmed.
- For urgent orders, customers should contact Lam Nhiên Thâle directly via **Zalo or phone** to check deliverability before placing the order.
- Some products **pre-order, seasonal flowers, imported flowers, or products requiring special preparation** may not apply for next-day delivery.

### Sunday and Public Holidays
Lam Nhiên Thảo may support delivery on Sundays or public holidays depending on the operating schedule and delivery capability at each time. Please contact in advance to confirm.

Expected delivery time may change due to **traffic conditions, weather, or other objective factors**.

3. DELIVERY FEES
Delivery fees are determined based on **distance, delivery area, time, and transport method**.

The specific delivery fees will be announced and confirmed by Lam Nhiên Thâle together with the order prior to delivery.

In some programs or orders reaching a certain value, Lam Nhiên Thảo may apply a shipping fee support policy from time to time.

4. DELIVERY PROCESS
After the order is confirmed:

1. Lam Nhiên Thâle confirms product, address, and delivery time information.
2. The order is prepared and handed over to the suitable delivery person or employee.
3. The delivery person may contact the recipient before arriving at the delivery address.
4. Customers must ensure someone is present at the provided delivery address.
5. After successful delivery, the order is considered complete.

For delivery requests at **lobby, ceremony, reception desk, or intermediate areas**, customers must notify in advance for Lam Nhiên Thâle to record during delivery coordination.

5. RECEIPT AND FLOWER INSPECTION
Fresh flowers are products with unique characteristics. Lam Nhiên Thâle checks the product condition before delivery and packages appropriately for each type of flower.

Upon receipt, customers should check the flower condition and notify Lam Nhiên Thâle as soon as possible if any abnormality is detected.

Care instructions will be provided depending on the flower type and product form.

6. SPECIAL REQUESTS
For requests at **lobby, ceremony, reception desk, or intermediate areas**, customers must notify in advance for Lam Nhiên Thâle to coordinate delivery.

Specific requests regarding time, recipient, delivery point, or process must be notified in advance for Lam Nhiên Thâle to check deliverability.

7. DELIVERY FAILURE
Orders may fail to deliver in the following situations:

- Inability to contact the recipient.
- Incorrect or inaccurate delivery address or information.
- Recipient refuses to accept or is not present at the registered delivery address.
- Delivery location is not accessible at the time of delivery.

In this case, Lam Nhiên Thâle will contact the customer to agree on a resolution method.

If re-delivery is needed, **delivery fees incurred may apply** depending on the cause and conditions of the delivery.

For fresh flowers, the time and storage conditions can directly affect product quality. Therefore, Lam Nhiên Thâle does not guarantee preserving the initial condition during re-delivery coordination.

8. CONTACT
To check delivery coverage, fees, or special delivery requests, please contact:

- Phone / Zalo: [0869 308 993](tel:0869308993)
- Email: [support@lamnhienthao.com](mailto:support@lamnhienthao.com)

Lam Nhiên Thâle will confirm delivery information before the order is fulfilled.',
            ],
            [
                'title' => 'Hỗ trợ khách hàng',
                'slug'  => 'huong-dan-mua-hang',
                'content' => 'HỖ TRỢ KHÁCH HÀNG

Nếu có bất kỳ thắc mắc nào, đừng ngại liên hệ với chúng tôi qua:
- Điện thoại / Zalo: 0909999999
- Email: contact@lamnhienthao.vn
- Hoặc điền vào form liên hệ trên trang web

Chúng tôi luôn sẵn sàng hỗ trợ bạn!',
                'content_en' => 'Customer Support

If you have any questions, please do not hesitate to contact us via:
- Phone / Zalo: 0909999999
- Email: contact@lamnhienthao.vn
- Or fill out the contact form on the website

We are always ready to support you!',
            ],
            [
                'title' => 'Liên hệ',
                'slug'  => 'lien-he',
                'content' => 'LIÊN HẾ

Nếu có bất kỳ thắc mắc nào, đừng ngại liên hệ với chúng tôi qua:
- Điện thoại / Zalo: 0909999999
- Email: contact@lamnhienthao.vn
- Hoặc điền vào form liên hệ trên trang web

Chúng tôi luôn sẵn sàng hỗ trợ bạn!',
                'content_en' => 'Contact

If you have any questions, please do not hesitate to contact us via:
- Phone / Zalo: 0909999999
- Email: contact@lamnhienthao.vn
- Or fill out the contact form on the website',
            ],
            [
                'title' => 'Chính sách của chúng tôi',
                'slug'  => 'chinh-sach-cua-chung-toi',
                'content' => 'CHÍNH SÁCH CỦA CHÚNG TÔI

Chúng tôi tin rằng việc chia sẻ là bước tiếp theo quan trọng nhất trong hành trình phát triển của một tổ chức.

1. CHÚNG TÔI LÀ AI
Chúng tôi là một cửa hàng hoa tươi cao cấp tại TP. Hồ Chí Minh. Với niềm đam mê hoa và nghệ thuật cắm hoa, chúng tôi mang đến những bó hoa tinh tế, độc đáo cho mọi dịp đặc biệt trong cuộc sống của bạn.

2. TẠI SAO CHIA SẺ
Chúng tôi chia sẻ vì chúng tôi tin rằng sự chia sẻ tạo ra giá trị cộng đồng, giúp lan tỏa vẻ đẹp của thiên nhiên và ý nghĩa của hoa đến nhiều người hơn.

3. CHIẾC CHIA SẺ CHI TIẾT
Chúng tôi chia sẻ:
- Bài viết và kiến thức về hoa, giữ gìn vẻ đẹp tự nhiên
- Những bó hoa yêu thích của chúng tôi
- Những dịp lễ tết và kỷ niệm mà chúng tôi cùng bạn chung soy
- Cách chăm sóc hoa để bông hoa nở kéo dài

4. LƯU Ý KHI CHIA SẺ
- Chúng tôi chỉ chia sẻ nội dung công khai
- Kính trọng quyền tác giả và bản quyền
- Chúng tôi không chia sẻ thông tin cá nhân của khách hàng

5. LIÊN HỆ
Nếu bạn muốn chia sẻ hoặc hợp tác, vui lòng liên hệ với chúng tôi qua:
- Điện thoại / Zalo: 0909999999
- Email: contact@lamnhienthao.vn',

                'content_en' => 'Our Policy

We believe that sharing is the next important step in an organization\'s development journey.

1. WHO WE ARE
We are a premium fresh flower shop in Ho Chi Minh City. With a passion for flowers and flower arranging art, we bring delicate and unique flower bouquets for every special occasion in your life.

2. WHY WE SHARE
We share because we believe sharing creates community value, helping spread the beauty of nature and the meaning of flowers to more people.

3. DETAILED SHARING
We share:
- Articles and knowledge about flowers, preserving natural beauty
- Our favorite bouquets
- Holiday and memorial occasions we share with you
- How to care for flowers to extend blooming

4. SHARING NOTES
- We only share public content
- We respect authors\' rights and copyrights
- We do not share customers\' personal information

5. CONTACT
If you want to share or collaborate, please contact us via:
- Phone / Zalo: 0909999999
- Email: contact@lamnhienthao.vn',
            ],
            [
                'title' => 'Phụ kiện & đồ trang trí cây thông',
                'slug'  => 'phu-kien-cay-thong',
                'content' => 'PHỤ KIẾN & ĐÒ TRANG TRỊ CÂY THÒNG

Chúng tôi mang đến những món đồ trang trí độc đáo và chất lượng cao để nâng tầm không gian sống của bạn.

1. MẪN ĐỒ TRANG TRỊ CÂY THÒNG CỦA LÂM NHIÊN THẢO
Các món đồ trang trí cây thông của chúng tôi được thiết kế tỉ mỉ, kết hợp hài hòa giữa vẻ đẹp tự nhiên và phong cách hiện đại. Mỗi món đồ đều là một tác phẩm độc bản, mang lại cảm giác thư giãn và phòng cảnh sống của bạn.

2. LOẠI KỸ THUẬT
Sử dụng các vật liệu tự nhiên và công nghệ in 3D hiện đại. Mỗi sản phẩm đều đi qua kiểm soát chặt chẽ về chất lượng vàdurability.

3. MÀN ĐỒ TRANG TRỊ PHỔ BIẾN
Từ bàn trà đến vệ sinh gia đình, chúng tôi cung cấp các giải pháp trang trí phù hợp với mọi không gian.

4. CAM KẾT VÀ DỰA KHẢONH
Sản phẩm của chúng tôi cam kết bền bỉ và bền vững. Mỗi sản phẩm đều đi qua kiểm tra chất lượng nghiêm ngặt trước khi bàn giao.

5. LIÊN HỆ
Nếu bạn muốn biết thêm thông tin hoặc đặt món đồ, vui lòng liên hệ chúng tôi qua:
- Điện thoại / Zalo: 0909999999
- Email: contact@lamnhienthao.vn',

                'content_en' => 'Accessories & Tree Decor

We bring unique and high-quality accessories to enhance your living space.

1. LAM NHIÊN THẢO ACCESSORIES
Our tree decor items are meticulously designed, harmoniously combining natural beauty and modern style. Each piece is a unique artwork, bringing a sense of relaxation and enhancing your living space.

2. TECHNIQUES
Using natural materials and modern 3D printing technology. Each product undergoes strict quality and durability control before handover.

3. GENERAL ACCESSORIES
From tea tables to home cleaning, we provide decoration solutions suitable for every space.

4. COMMITMENT AND WARRANTY
Our products are committed to be durable and sustainable. Each product undergoes strict quality checking before handover.

5. CONTACT
If you want to know more information or place an order, please contact us via:
- Phone / Zalo: 0909999999
- Email: contact@lamnhienthao.vn',
            ],
            [
                'title' => 'Mùa lễ hội',
                'slug'  => 'mua-le-hoi',
                'content' => 'MUA LỀ HOI

Chúng tôi mang đến những bộ sưu tập hoa đặc biệt cho các dịp lễ hội quan trọng.

1. TẠI SAO CẦN MUA LỀ HOI
Lâm Nhiên Thảo tin rằng những dịp lễ hội là những khoảnh khắc đáng nhớ trong cuộc sống. Chúng tôi mang đến những bộ sưu tập hoa đặc biệt để bạn có thể trao tặng người thân yêu trong những dịp quan trọng nhất.

2. LỊCH LẬP MUA LỀ
- Tết Nguyên Đán
- Valentine\'s Day
- Ngày Quốc Khánh
- Ngày Phụ Nữ Quốc Tế
- Giáng Sinh
- Giáng Sinh cùng gia đình

3. MẪU SẮC HOA ĐẶC BIỆT
- Hoa hồng Hồng Ecuador tươi sắp nở
- Hoa Tulip Hà Lan giai mùa
- Hoa Cẩm tấu cầu độc đáo
- Các loài hoa nhiệt đới cuối tháng

4. MÃ GIẢM ĐẶC BIỆT
- MÃ: LNT20 - Giảm 20% cho đơn hàng trên 500.000₫
- MÃ: LNT30 - Giảm 30% cho đơn hàng trên 1.000.000₫

5. LIÊN HỆ
- Để biết thêm chi tiết, vui lòng liên hệ chúng tôi qua Zalo hoặc điện thoại.

6. TIN TỨC VÀ KHUYẾN MÃI
- Theo dõi Zalo official account của Lâm Nhiên Thảo để không bỏ lỡ các chương trình giảm giá đặc biệt.
- Đăng ký nhận bản tin email để nhận được thông báo về các sự kiện mua hàng sắp tới.

Nội dung chi tiết bộ sưu tập và giá cả sẽ được cập nhật trước từng dịp lễ hội.',
                'content_en' => 'Holiday Collection

We bring special flower collections for important occasions.

1. WHY HOLIDAY COLLECTIONS
Lam Nhiên Thảo believes that holiday occasions are memorable moments in life. We bring special flower collections for you to gift your loved ones on the most important occasions.

2. HOLIDAY SCHEDULE
- Lunar New Year
- Valentine\'s Day
- National Day
- International Women\'s Day
- Christmas
- Christmas with family

3. SPECIAL COLORS
- Fresh Ecuadorian roses just about to bloom
- Dutch tulips in season
- Unique tropical flowers at month-end

4. SPECIAL DISCOUNT CODES
- CODE: LNT20 - 20% off orders over 500,000₫
- CODE: LNT30 - 30% off orders over 1,000,000₫

5. CONTACT
- For more details, please contact us via Zalo or phone.

6. NEWS AND PROMOTIONS
- Follow Lam Nhiên Thảo\'s official Zalo account to not miss special discount programs.
- Subscribe to email newsletter to receive notifications about upcoming shopping events.

Detailed collection and pricing will be updated before each upcoming holiday.',
            ],
            [
                'title' => 'Tuyển dụng',
                'slug'  => 'tuyen-dung',
                'content' => 'TUYỂN DỤNG

Chúng tôi luôn tìm kiếm những tài năng tài năng yêu đam mê hoa để cùng Lâm Nhiên Thảo phát triển.

1. VỊ THỨC CẦN TỐI ĐA
- Thu ngônPhó bán hàng
- Thu ngônPhó tiếp nhận đơn hàng
- Thiết kế bộ ra hoa
- Nhân viên quản lý kho
- Nhân viên giao hàng

2. LIÊN HỆ
- Để biết thêm chi tiết, vui lòng liên hệ chúng tôi qua Zalo hoặc điện thoại.

3. QUY Trình Tuyển dụng
- Gửi CV và portfolio qua Zalo hoặc email
- Phỏng vấn qua Zalo video hoặc điện thoại
- Kết quả thông báo qua email trong 3-5 ngày làm việc

Nội dung chi tiết bộ sưu tập và giá cả sẽ được cập nhật trước từng dịp lễ hội.',
                'content_en' => 'Recruitment

We are always looking for talents who love flowers to grow together with Lam Nhiên Thảo.

1. OPEN POSITIONS
- Sales Consultant
- Order Receiving Consultant
- Flower Arranger
- Warehouse Staff
- Delivery Staff

2. HOW TO APPLY
- Send CV and portfolio via Zalo or email
- Interview via Zalo video or phone
- Results notified by email within 3-5 business days

3. RECRUITMENT PROCESS
- Submit CV and portfolio via Zalo or email
- Interview via Zalo video or phone
- Results notified by email within 3-5 business days',
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                [
                    'title'     => $pageData['title'],
                    'content'   => $pageData['content'],
                    'content_en' => $pageData['content_en'],
                    'is_active' => true,
                ]
            );
        }
    }
}