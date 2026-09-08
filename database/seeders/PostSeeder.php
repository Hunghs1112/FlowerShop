<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Cách chăm sóc hoa tươi cắt cành',
                'excerpt' => 'Tìm hiểu những cách tốt nhất để giữ hoa tươi lâu và rực rỡ hơn.',
                'content' => 'Hoa tươi cắt cành có thể làm sáng bừng bất kỳ căn phòng nào, nhưng cần chăm sóc đúng cách để kéo dài tuổi thọ. Hãy cắt thân hoa theo góc 45 độ trước khi cắm vào nước. Thay nước mỗi 2-3 ngày và để hoa tránh xa ánh nắng trực tiếp cũng như nguồn nhiệt. Loại bỏ lá nằm dưới mực nước để ngăn vi khuẩn phát triển.',
                'thumbnail' => 'https://images.unsplash.com/photo-1487530811015-780e25f07b82?w=800&q=80',
            ],
            [
                'title' => 'Top 10 xu hướng hoa cưới 2026',
                'excerpt' => 'Khám phá những xu hướng hoa đám cưới hot nhất năm nay.',
                'content' => 'Xu hướng hoa cưới 2026 thiên về phong cách tự nhiên, hữu cơ với trọng tâm là tính bền vững. Các lựa chọn phổ biến bao gồm bó hoa kiểu vườn hoang dã, điểm nhấn từ hoa khô và bảng màu đơn sắc. Cỏ pampas vẫn tiếp tục là xu hướng, trong khi hoa địa phương theo mùa ngày càng được ưa chuộng bởi các cặp đôi có ý thức môi trường.',
                'thumbnail' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=800&q=80',
            ],
            [
                'title' => 'Ngôn ngữ của hoa: Ý nghĩa từng loài',
                'excerpt' => 'Hiểu ý nghĩa ẩn sau những loài hoa khác nhau.',
                'content' => 'Mỗi loài hoa mang ý nghĩa biểu tượng riêng. Hoa hồng đỏ tượng trưng cho tình yêu nồng nàn, hoa hồng vàng đại diện cho tình bạn. Hoa ly trắng mang ý nghĩa thuần khiết và chia buồn, thích hợp cho cả đám cưới lẫn lễ tang. Hoa hướng dương thể hiện sự tôn sùng và trung thành, còn hoa lan tượng trưng cho sự sang trọng và sức mạnh.',
                'thumbnail' => 'https://images.unsplash.com/photo-1490750967868-88df5691cc8d?w=800&q=80',
            ],
            [
                'title' => 'Hướng dẫn hoa theo mùa tại Việt Nam',
                'excerpt' => 'Hướng dẫn toàn diện về các loài hoa theo mùa tại Việt Nam.',
                'content' => 'Hiểu về tính mùa vụ giúp bạn chọn được hoa tươi nhất với giá tốt nhất. Mùa xuân mang đến tulip và hoa anh đào, mùa hè có hướng dương và thược dược, mùa thu nổi bật với cúc và vạn thọ, trong khi mùa đông phù hợp với trạng nguyên và amaryllis. Mua hoa theo mùa cũng góp phần ủng hộ người trồng hoa địa phương.',
                'thumbnail' => 'https://images.unsplash.com/photo-1444021465936-c6ca81d39b84?w=800&q=80',
            ],
            [
                'title' => 'Mẹo cắm hoa tại nhà cho người mới bắt đầu',
                'excerpt' => 'Tạo ra những bình hoa tuyệt đẹp tại nhà với những mẹo đơn giản này.',
                'content' => 'Cắm hoa đẹp không khó như bạn nghĩ. Bắt đầu với lọ sạch và nước tươi pha chất dinh dưỡng cho hoa. Tạo bố cục bằng cách đặt cành lá làm nền, rồi thêm hoa chủ đạo, cuối cùng bổ sung hoa phụ. Hãy nhớ quy tắc 1/3 để tạo bố cục cân đối.',
                'thumbnail' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=800&q=80',
            ],
        ];

        foreach ($posts as $postData) {
            Post::create([
                'title'        => $postData['title'],
                'slug'         => Str::slug($postData['title']),
                'excerpt'      => $postData['excerpt'],
                'content'      => $postData['content'],
                'thumbnail'    => $postData['thumbnail'],
                'is_published' => true,
                'published_at' => now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
