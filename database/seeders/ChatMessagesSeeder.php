<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seed sample chat messages between customers and admin.
     */
    public function run(): void
    {
        // Get admin user
        $admin = User::where('email', 'admin@flowershop.local')->first();
        
        // Get customer users
        $customers = User::where('email', '!=', 'admin@flowershop.local')->get();
        
        if ($customers->isEmpty()) {
            $this->command->warn('No customers found. Skipping chat messages seeding.');
            return;
        }

        $messages = [
            // Customer 1 - Order inquiry
            [
                'user_id' => $customers[0]->id,
                'is_admin' => false,
                'message' => 'Xin chào, tôi muốn đặt hoa hồng cho ngày sinh nhật mẹ vào tuần sau.',
                'is_read' => true,
            ],
            [
                'user_id' => $customers[0]->id,
                'is_admin' => true,
                'message' => 'Chào bạn! Cảm ơn đã liên hệ. Chúng tôi có nhiều loại hoa hồng đẹp, bạn muốn chọn màu nào ạ?',
                'is_read' => true,
            ],
            [
                'user_id' => $customers[0]->id,
                'is_admin' => false,
                'message' => 'Tôi muốn bó hoa hồng đỏ 18 bông, giao vào thứ 7 tuần sau.',
                'is_read' => false,
            ],
            
            // Customer 2 - Product question
            [
                'user_id' => $customers->count() > 1 ? $customers[1]->id : $customers[0]->id,
                'is_admin' => false,
                'message' => 'Hoa lavender có giao được ra Hà Nội không?',
                'is_read' => false,
            ],
            [
                'user_id' => $customers->count() > 1 ? $customers[1]->id : $customers[0]->id,
                'is_admin' => true,
                'message' => 'Dạ có ạ! Chúng tôi giao hoa tươi ra Hà Nội trong 1-2 ngày. Lavender hiện có 2 loại: túi 10g và 20g.',
                'is_read' => true,
            ],
            
            // Customer 3 - Delivery question
            [
                'user_id' => $customers->count() > 2 ? $customers[2]->id : $customers[0]->id,
                'is_admin' => false,
                'message' => 'Bó hoa đặt hôm qua đã giao chưa ạ?',
                'is_read' => false,
            ],
        ];

        foreach ($messages as $msg) {
            ChatMessage::create($msg);
        }

        $this->command->info('Created ' . count($messages) . ' chat messages.');
    }
}
