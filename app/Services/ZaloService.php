<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZaloService
{
    protected string $oaId;
    protected string $accessToken;
    protected string $apiEndpoint = 'https://openapi.zalo.me/v3.0/oa';

    public function __construct(protected NotificationService $notificationService)
    {
        $this->oaId = $this->notificationService->getZaloOaId() ?? '';
        $this->accessToken = $this->notificationService->getZaloAccessToken() ?? '';
    }

    /**
     * Gửi tin nhắn text qua Zalo OA
     */
    public function sendTextMessage(string $userId, string $message): bool
    {
        if (!$this->notificationService->isZaloEnabled()) {
            Log::debug('Zalo notifications are disabled');
            return false;
        }

        if (empty($this->accessToken) || empty($userId)) {
            Log::warning('Zalo: Missing access token or user ID');
            return false;
        }

        try {
            $response = Http::withHeaders([
                'access_token' => $this->accessToken,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiEndpoint}/message", [
                'recipient' => [
                    'user_id' => $userId,
                ],
                'message' => [
                    'text' => $message,
                ],
            ]);

            if ($response->successful()) {
                Log::info('Zalo message sent successfully', ['user_id' => $userId]);
                return true;
            }

            Log::error('Zalo API error', [
                'status' => $response->status(),
                'response' => $response->json(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Zalo send message exception', [
                'message' => $e->getMessage(),
                'user_id' => $userId,
            ]);
            return false;
        }
    }

    /**
     * Gửi thông báo đơn hàng mới
     */
    public function sendOrderNotification(string $userId, array $orderData): bool
    {
        $message = $this->formatOrderMessage($orderData);
        return $this->sendTextMessage($userId, $message);
    }

    /**
     * Format thông tin đơn hàng thành message
     */
    protected function formatOrderMessage(array $orderData): string
    {
        $message = "🌸 ĐƠN HÀNG MỚI 🌸\n\n";
        $message .= "Mã đơn: #{$orderData['order_id']}\n";
        $message .= "Khách hàng: {$orderData['customer_name']}\n";
        $message .= "SĐT: {$orderData['customer_phone']}\n";
        
        if (!empty($orderData['customer_email'])) {
            $message .= "Email: {$orderData['customer_email']}\n";
        }

        $message .= "\n📦 SẢN PHẨM:\n";
        
        foreach ($orderData['items'] as $item) {
            $message .= "• {$item['name']} x{$item['quantity']} - " . number_format($item['price'], 0, ',', '.') . "₫\n";
        }

        $message .= "\n💰 Tổng: " . number_format($orderData['total'], 0, ',', '.') . "₫\n";

        if (!empty($orderData['message'])) {
            $message .= "\n📝 Ghi chú: {$orderData['message']}\n";
        }

        $message .= "\n⏰ Thời gian: {$orderData['created_at']}";

        return $message;
    }

    /**
     * Gửi thông báo đơn hàng cho admin qua webhook/phone
     */
    public function notifyAdminNewOrder(array $orderData): bool
    {
        if (!$this->notificationService->isZaloEnabled()) {
            Log::debug('Zalo notifications are disabled');
            return false;
        }

        $adminPhone = $this->notificationService->getZaloAdminPhone();
        
        if (empty($adminPhone)) {
            Log::warning('Zalo: Admin phone not configured');
            return false;
        }

        // Nếu có Zalo User ID của admin, gửi trực tiếp
        $adminZaloId = config('services.zalo.admin_zalo_id');
        if (!empty($adminZaloId)) {
            return $this->sendOrderNotification($adminZaloId, $orderData);
        }

        // Nếu không có, log để admin có thể kiểm tra
        Log::info('New order - Admin notification', $orderData);
        
        return true;
    }

    /**
     * Gửi tin nhắn xác nhận cho khách hàng
     */
    public function sendCustomerConfirmation(array $orderData): bool
    {
        // Nếu khách hàng cung cấp Zalo ID
        if (!empty($orderData['customer_zalo_id'])) {
            $message = "🌸 CẢM ƠN QUÝ KHÁCH! 🌸\n\n";
            $message .= "Đơn hàng #{$orderData['order_id']} đã được tiếp nhận.\n";
            $message .= "Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.\n\n";
            $message .= "📞 Hotline: " . config('services.zalo.hotline', '') . "\n";
            $message .= "💐 Cảm ơn bạn đã tin tưởng Lâm Nhiên Thảo!";

            return $this->sendTextMessage($orderData['customer_zalo_id'], $message);
        }

        return false;
    }

    /**
     * Tạo deep link Zalo để chat trực tiếp
     */
    public function getChatDeepLink(): string
    {
        if (empty($this->oaId)) {
            return '';
        }

        return "https://zalo.me/{$this->oaId}";
    }

    /**
     * Test connection với Zalo API
     */
    public function testConnection(): array
    {
        if (empty($this->accessToken)) {
            return [
                'success' => false,
                'message' => 'Access token not configured',
            ];
        }

        try {
            $response = Http::withHeaders([
                'access_token' => $this->accessToken,
            ])->get("{$this->apiEndpoint}/getoa");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Connection successful',
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => 'API error',
                'response' => $response->json(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
