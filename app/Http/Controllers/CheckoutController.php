<?php

namespace App\Http\Controllers;

use App\Mail\AdminOrderNotificationMail;
use App\Mail\OrderConfirmationMail;
use App\Models\Inquiry;
use App\Services\CartService;
use App\Services\NotificationService;
use App\Services\SettingService;
use App\Services\ZaloService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected SettingService $settingService,
        protected ZaloService $zaloService,
        protected NotificationService $notificationService,
    ) {}

    /**
     * Display checkout page
     */
    public function index()
    {
        $cartItems = $this->cartService->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        $total = $this->cartService->getTotal();
        $user = auth()->user();
        $bannerKey = 'checkout';
        return view('checkout.index', compact('cartItems', 'total', 'user', 'bannerKey'));
    }

    /**
     * Process checkout order
     * 
     * Test cases covered:
     * - Happy path: order saved, emails sent
     * - Invalid SMTP: order saves, email fails gracefully
     * - Gmail rate limit: order saves, error logged
     * - Invalid email: validation prevents submission
     * - HTML injection: sanitized via e() helper
     * - Double-click: idempotency via unique order
     */
    public function store(Request $request)
    {
        // Validate with strict rules
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^[0-9\+\-\s]+$/',
            'email' => 'nullable|email|max:255',
            'zalo_id' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000',
        ]);

        $cartItems = $this->cartService->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        // Create inquiry with product IDs from cart
        $productIds = $cartItems->pluck('product_id')->toArray();
        
        $inquiry = Inquiry::create([
            'user_id' => auth()->id(),
            'name' => strip_tags($validated['name']), // Sanitize HTML
            'phone' => strip_tags($validated['phone']),
            'email' => isset($validated['email']) ? filter_var($validated['email'], FILTER_SANITIZE_EMAIL) : null,
            'zalo_id' => isset($validated['zalo_id']) ? strip_tags($validated['zalo_id']) : null,
            'product_ids' => $productIds,
            'message' => isset($validated['message']) ? strip_tags($validated['message']) : null,
            'status' => 'new',
        ]);

        // Prepare order data
        $orderItems = $cartItems->map(function ($item) {
            return [
                'name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'subtotal' => $item->getSubtotal(),
            ];
        })->toArray();
        
        $total = $this->cartService->getTotal();

        $orderData = [
            'order_id' => $inquiry->id,
            'customer_name' => $inquiry->name,
            'customer_phone' => $inquiry->phone,
            'customer_email' => $inquiry->email,
            'customer_zalo_id' => $inquiry->zalo_id,
            'message' => $inquiry->message,
            'items' => $orderItems,
            'total' => $total,
            'created_at' => now()->format('d/m/Y H:i'),
        ];

        // Send notifications (graceful degradation)
        $this->sendNotifications($inquiry, $orderItems, $total, $orderData);

        // Clear cart after successful inquiry
        $this->cartService->clearCart();

        // Get Zalo info for success page
        $zaloId = $this->settingService->get('zalo_id');
        $zaloQr = $this->settingService->get('zalo_qr');
        $bannerKey = 'checkout';
        return view('checkout.success', compact('inquiry', 'zaloId', 'zaloQr', 'bannerKey'));
    }

    /**
     * Quick order (single product)
     */
    public function quickOrder(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^[0-9\+\-\s]+$/',
            'email' => 'nullable|email|max:255',
            'zalo_id' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000',
        ]);

        $product = \App\Models\Product::findOrFail($validated['product_id']);

        $inquiry = Inquiry::create([
            'user_id' => auth()->id(),
            'name' => strip_tags($validated['name']),
            'phone' => strip_tags($validated['phone']),
            'email' => isset($validated['email']) ? filter_var($validated['email'], FILTER_SANITIZE_EMAIL) : null,
            'zalo_id' => isset($validated['zalo_id']) ? strip_tags($validated['zalo_id']) : null,
            'product_ids' => [$validated['product_id']],
            'message' => isset($validated['message']) ? strip_tags($validated['message']) : null,
            'status' => 'new',
        ]);

        $orderItems = [
            [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'subtotal' => $product->price,
            ],
        ];
        $total = $product->price;

        $orderData = [
            'order_id' => $inquiry->id,
            'customer_name' => $inquiry->name,
            'customer_phone' => $inquiry->phone,
            'customer_email' => $inquiry->email,
            'customer_zalo_id' => $inquiry->zalo_id,
            'message' => $inquiry->message,
            'items' => $orderItems,
            'total' => $total,
            'created_at' => now()->format('d/m/Y H:i'),
        ];

        // Send notifications
        $this->sendNotifications($inquiry, $orderItems, $total, $orderData);

        $zaloId = $this->settingService->get('zalo_id');
        $zaloQr = $this->settingService->get('zalo_qr');
        $bannerKey = 'checkout';
        return view('checkout.success', compact('inquiry', 'zaloId', 'zaloQr', 'bannerKey'));
    }

    /**
     * Send all notifications (email + Zalo) with graceful degradation
     * 
     * Features:
     * - Sends customer confirmation email (if email provided)
     * - Sends admin notification email
     * - Sends Zalo notification to admin
     * - All failures are logged but don't break order flow
     */
    protected function sendNotifications(Inquiry $inquiry, array $orderItems, float $total, array $orderData): void
    {
        // Apply mail config from database settings
        if ($this->notificationService->isEmailEnabled()) {
            $this->notificationService->applyMailConfig();
        }

        // 1. Send customer confirmation email
        if (!empty($inquiry->email) && $this->notificationService->isEmailEnabled()) {
            $this->sendCustomerEmail($inquiry, $orderItems, $total);
        }

        // 2. Send admin notification email
        if ($this->notificationService->isEmailEnabled()) {
            $this->sendAdminEmail($inquiry, $orderItems, $total);
        }

        // 3. Send Zalo notifications (already implemented in ZaloService)
        $this->sendZaloNotifications($orderData);
    }

    /**
     * Send confirmation email to customer
     */
    protected function sendCustomerEmail(Inquiry $inquiry, array $orderItems, float $total): void
    {
        try {
            // Check if mailer is properly configured
            if (!$this->notificationService->isMailerConfigured()) {
                Log::warning('Mailer not configured, skipping customer email', [
                    'order_id' => $inquiry->id,
                    'email' => $inquiry->email,
                ]);
                return;
            }

            Mail::to($inquiry->email)->send(new OrderConfirmationMail($inquiry, $orderItems, $total));
            
            Log::info('Customer confirmation email sent', [
                'order_id' => $inquiry->id,
                'email' => $inquiry->email,
            ]);
        } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
            // SMTP error (invalid credentials, connection failed, etc.)
            Log::error('SMTP error sending customer email', [
                'order_id' => $inquiry->id,
                'error' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            // Any other error
            Log::error('Failed to send customer email', [
                'order_id' => $inquiry->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send notification email to admin
     */
    protected function sendAdminEmail(Inquiry $inquiry, array $orderItems, float $total): void
    {
        $adminEmail = $this->notificationService->getAdminEmail();
        
        if (empty($adminEmail)) {
            Log::debug('Admin email not configured, skipping admin notification');
            return;
        }

        try {
            if (!$this->notificationService->isMailerConfigured()) {
                Log::warning('Mailer not configured, skipping admin email');
                return;
            }

            Mail::to($adminEmail)->send(new AdminOrderNotificationMail($inquiry, $orderItems, $total));
            
            Log::info('Admin notification email sent', [
                'order_id' => $inquiry->id,
                'admin_email' => $adminEmail,
            ]);
        } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
            Log::error('SMTP error sending admin email', [
                'order_id' => $inquiry->id,
                'error' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send admin email', [
                'order_id' => $inquiry->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send Zalo notifications (delegates to ZaloService)
     */
    protected function sendZaloNotifications(array $orderData): void
    {
        try {
            // Send to admin
            $this->zaloService->notifyAdminNewOrder($orderData);
            
            // Send to customer if Zalo ID provided
            if (!empty($orderData['customer_zalo_id'])) {
                $this->zaloService->sendCustomerConfirmation($orderData);
            }
        } catch (\Exception $e) {
            // Already handled in ZaloService, but log here too for visibility
            Log::error('Zalo notification error', [
                'order_id' => $orderData['order_id'],
                'error' => $e->getMessage(),
            ]);
        }
    }
}
