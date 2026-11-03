<?php

namespace App\Http\Controllers;

use App\Domain\Ordering\Actions\PlaceOrderAction;
use App\Domain\Ordering\Data\PlaceOrderData;
use App\Services\NotificationService;
use App\Services\ZaloService;
use Illuminate\Http\Request;

class QuickOrderController extends Controller
{
    public function store(Request $request, PlaceOrderAction $placeOrder, NotificationService $notifications, ZaloService $zaloService)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'], 'variant_id' => ['nullable', 'exists:product_variants,id'],
            'quantity' => ['nullable', 'integer', 'min:1'], 'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'], 'email' => ['nullable', 'email', 'max:255'],
            'zalo_id' => ['nullable', 'string', 'max:50'], 'message' => ['nullable', 'string', 'max:1000'],
        ]);
        try {
            $order = $placeOrder->execute(new PlaceOrderData(
                name: $validated['name'], phone: $validated['phone'], email: $validated['email'] ?? null,
                zaloId: $validated['zalo_id'] ?? null, note: $validated['message'] ?? null,
                idempotencyKey: $request->header('Idempotency-Key', $request->input('idempotency_key')),
                items: [['product_id' => $validated['product_id'], 'variant_id' => $validated['variant_id'] ?? null, 'quantity' => $validated['quantity'] ?? 1]],
            ));
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        try {
            $payload = [
                'order_id' => $order->id, 'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone, 'customer_email' => $order->customer_email,
                'customer_zalo_id' => $order->zalo_id, 'message' => $order->note,
                'items' => $order->items->map(fn ($item) => ['name' => $item->product_name, 'price' => $item->unit_price, 'quantity' => $item->quantity, 'subtotal' => $item->subtotal])->all(),
                'total' => (float) $order->total, 'created_at' => $order->created_at->format('d/m/Y H:i'),
            ];
            if ($notifications->isZaloEnabled()) {
                $zaloService->notifyAdminNewOrder($payload);
            }
            $notifications->notifyOrderPlaced($order);
        } catch (\Throwable $e) {
            \Log::error('Failed to send quick order notifications', ['order_id' => $order->id, 'error' => $e->getMessage()]);
        }

        return redirect(localized_route('checkout.success', ['inquiry' => $order->id]))->with('success', __('customer.messages.quick_order_success'));
    }
}
