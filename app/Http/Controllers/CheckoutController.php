<?php

namespace App\Http\Controllers;

use App\Domain\Ordering\Actions\PlaceOrderAction;
use App\Domain\Ordering\Data\PlaceOrderData;
use App\Models\Inquiry;
use App\Models\Order;
use App\Mail\AdminOrderNotificationMail;
use App\Mail\OrderConfirmationMail;
use App\Services\CartService;
use App\Services\SettingService;
use App\Services\ZaloService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected SettingService $settingService,
        protected PlaceOrderAction $placeOrder,
        protected ZaloService $zaloService,
        protected \App\Services\NotificationService $notificationService,
    ) {}

    public function index()
    {
        $cartItems = $this->cartService->getCartItems();
        if ($cartItems->isEmpty()) return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        $total = $this->cartService->getTotal();
        $user = auth()->user();
        $bannerKey = 'checkout';
        $siteInfo = $this->settingService->getSiteInfo();
        return view('checkout.index', compact('cartItems', 'total', 'user', 'bannerKey', 'siteInfo'));
    }

    public function success(?int $inquiry = null)
    {
        $order = $inquiry ? Order::with('items')->find($inquiry) : null;
        if ($order) {
            $this->authorize('view', $order);
        }
        $inquiry = $order ? null : ($inquiry ? Inquiry::whereKey($inquiry)->where('user_id', auth()->id())->firstOrFail() : null);
        $bannerKey = 'checkout';
        return view('checkout.success', compact('inquiry', 'order', 'bannerKey'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'email' => ['nullable', 'email', 'max:255'], 'zalo_id' => ['nullable', 'string', 'max:255'],
            'delivery_address' => ['required', 'string', 'max:500'],
            'delivery_date' => ['required', 'date', 'after_or_equal:today'],
            'delivery_time' => ['required', 'date_format:H:i'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);
        try {
            $order = $this->placeOrder->execute(new PlaceOrderData(
                name: $validated['name'], phone: $validated['phone'], email: $validated['email'] ?? null,
                zaloId: $validated['zalo_id'] ?? null, note: $validated['message'] ?? null,
                idempotencyKey: $request->header('Idempotency-Key', $request->input('idempotency_key')),
                deliveryAddress: $validated['delivery_address'], deliveryDate: $validated['delivery_date'],
                deliveryTime: $validated['delivery_time'],
            ));
        } catch (\Throwable $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
        DB::afterCommit(function () use ($order) {
            $payload = [
            'order_id' => $order->id, 'customer_name' => $order->customer_name,
            'customer_phone' => $order->customer_phone, 'customer_email' => $order->customer_email,
            'customer_zalo_id' => $order->zalo_id, 'message' => $order->note,
            'items' => $order->items->map(fn ($item) => ['name' => $item->product_name, 'price' => $item->unit_price, 'quantity' => $item->quantity, 'subtotal' => $item->subtotal])->all(),
            'total' => (float) $order->total, 'created_at' => $order->created_at->format('d/m/Y H:i'),
            ];
            try {
                if ($this->notificationService->isZaloEnabled()) {
                    $this->zaloService->notifyAdminNewOrder($payload);
                }
                if ($this->notificationService->isEmailEnabled()) {
                    $this->notificationService->applyMailConfig();
                    if ($order->customer_email) {
                        Mail::to($order->customer_email)->send(new OrderConfirmationMail($order, $payload['items'], $payload['total']));
                    }
                    if ($admin = $this->notificationService->getAdminEmail()) {
                        Mail::to($admin)->send(new AdminOrderNotificationMail($order, $payload['items'], $payload['total']));
                    }
                }
            } catch (\Throwable $e) {
                report($e);
            }
        });
        return redirect()->route('checkout.success', ['inquiry' => $order->id])->with('success', 'Đặt hàng thành công!');
    }
}
