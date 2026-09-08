<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Services\CartService;
use App\Services\SettingService;
use App\Services\ZaloService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected SettingService $settingService,
        protected ZaloService $zaloService
    ) {}

    public function index()
    {
        $cartItems = $this->cartService->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        $total = $this->cartService->getTotal();
        $user = auth()->user();

        return view('checkout.index', compact('cartItems', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'zalo_id' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        $cartItems = $this->cartService->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        // Create inquiry with product IDs from cart
        $productIds = $cartItems->pluck('product_id')->toArray();
        
        $inquiry = Inquiry::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'zalo_id' => $validated['zalo_id'] ?? null,
            'product_ids' => $productIds,
            'message' => $validated['message'] ?? null,
            'status' => 'new',
        ]);

        // Prepare order data for Zalo notification
        $orderData = [
            'order_id' => $inquiry->id,
            'customer_name' => $inquiry->name,
            'customer_phone' => $inquiry->phone,
            'customer_email' => $inquiry->email,
            'customer_zalo_id' => $inquiry->zalo_id,
            'message' => $inquiry->message,
            'items' => $cartItems->map(function ($item) {
                return [
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $item->getSubtotal(),
                ];
            })->toArray(),
            'total' => $this->cartService->getTotal(),
            'created_at' => now()->format('d/m/Y H:i'),
        ];

        // Send Zalo notifications
        try {
            // Gửi thông báo cho admin
            $this->zaloService->notifyAdminNewOrder($orderData);
            
            // Gửi xác nhận cho khách hàng (nếu có Zalo ID)
            if (!empty($inquiry->zalo_id)) {
                $this->zaloService->sendCustomerConfirmation($orderData);
            }
        } catch (\Exception $e) {
            // Log error nhưng vẫn tiếp tục
            \Log::error('Zalo notification error: ' . $e->getMessage());
        }

        // Clear cart after successful inquiry
        $this->cartService->clearCart();

        // Get Zalo info for success page
        $zaloId = $this->settingService->get('zalo_id');
        $zaloQr = $this->settingService->get('zalo_qr');

        return view('checkout.success', compact('inquiry', 'zaloId', 'zaloQr'));
    }

    public function quickOrder(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'zalo_id' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        $product = \App\Models\Product::findOrFail($validated['product_id']);

        $inquiry = Inquiry::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'zalo_id' => $validated['zalo_id'] ?? null,
            'product_ids' => [$validated['product_id']],
            'message' => $validated['message'] ?? null,
            'status' => 'new',
        ]);

        // Prepare order data for Zalo notification
        $orderData = [
            'order_id' => $inquiry->id,
            'customer_name' => $inquiry->name,
            'customer_phone' => $inquiry->phone,
            'customer_email' => $inquiry->email,
            'customer_zalo_id' => $inquiry->zalo_id,
            'message' => $inquiry->message,
            'items' => [
                [
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => $product->price,
                    'subtotal' => $product->price,
                ],
            ],
            'total' => $product->price,
            'created_at' => now()->format('d/m/Y H:i'),
        ];

        // Send Zalo notifications
        try {
            // Gửi thông báo cho admin
            $this->zaloService->notifyAdminNewOrder($orderData);
            
            // Gửi xác nhận cho khách hàng (nếu có Zalo ID)
            if (!empty($inquiry->zalo_id)) {
                $this->zaloService->sendCustomerConfirmation($orderData);
            }
        } catch (\Exception $e) {
            // Log error nhưng vẫn tiếp tục
            \Log::error('Zalo notification error: ' . $e->getMessage());
        }

        $zaloId = $this->settingService->get('zalo_id');
        $zaloQr = $this->settingService->get('zalo_qr');

        return view('checkout.success', compact('inquiry', 'zaloId', 'zaloQr'));
    }
}
