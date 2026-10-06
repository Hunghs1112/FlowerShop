<?php

namespace App\Http\Controllers;

use App\Domain\Ordering\Actions\PlaceOrderAction;
use App\Domain\Ordering\Data\PlaceOrderData;
use Illuminate\Http\Request;

class QuickOrderController extends Controller
{
    public function store(Request $request, PlaceOrderAction $placeOrder)
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
        return redirect()->route('checkout.success', ['inquiry' => $order->id])->with('success', 'Đặt hàng nhanh thành công!');
    }
}
