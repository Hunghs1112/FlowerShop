<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();
        if ($request->filled('status')) $query->where('status', $request->string('status'));
        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(fn ($q) => $q->where('customer_name', 'like', "%{$search}%")->orWhere('customer_phone', 'like', "%{$search}%"));
        }
        $orders = $query->paginate(min(max((int) $request->input('per_page', 25), 1), 100))->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'items.variant']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::STATUSES))],
        ]);

        $result = DB::transaction(function () use ($order, $validated) {
            $order = Order::query()->lockForUpdate()->findOrFail($order->id);

            if (in_array($order->status, ['completed', 'cancelled'], true)) {
                return 'finished';
            }

            if ($validated['status'] === 'new' || $validated['status'] === $order->status) {
                return 'unchanged';
            }

            $order->load(['items.product', 'items.variant']);

            foreach ($order->items as $item) {
                if ($validated['status'] === 'completed' && $item->product) {
                    $item->product->increment('sales_count', $item->quantity);
                }

                if ($validated['status'] === 'cancelled') {
                    ($item->variant ?: $item->product)?->increment('stock', $item->quantity);
                }
            }

            $order->update(['status' => $validated['status']]);

            return 'updated';
        });

        if ($result === 'finished') {
            return back()->with('error', 'Đơn đã kết thúc nên không thể đổi trạng thái.');
        }

        return $result === 'updated'
            ? back()->with('success', 'Đã cập nhật trạng thái đơn hàng.')
            : back();
    }
}
