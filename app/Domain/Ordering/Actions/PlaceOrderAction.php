<?php

namespace App\Domain\Ordering\Actions;

use App\Domain\Ordering\Data\PlaceOrderData;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PlaceOrderAction
{
    public function execute(PlaceOrderData $data): Order
    {
        if ($data->idempotencyKey && ($existing = Order::where('idempotency_key', $data->idempotencyKey)->first())) {
            return $existing->load('items');
        }

        try {
            return DB::transaction(function () use ($data) {
                $items = $data->items
                    ? collect($data->items)
                    : CartItem::where(Auth::check() ? ['user_id' => Auth::id()] : ['session_id' => session()->getId()])->get();

                if ($items->isEmpty()) {
                    throw new RuntimeException('Giỏ hàng trống');
                }

                $snapshots = $items->map(function ($item) {
                    $productId = (int) ($item['product_id'] ?? $item->product_id);
                    $variantId = $item['variant_id'] ?? $item->variant_id;
                    $quantity = (int) ($item['quantity'] ?? $item->quantity);
                    if ($quantity < 1) throw new RuntimeException('Số lượng không hợp lệ');

                    $product = Product::query()->lockForUpdate()->findOrFail($productId);
                    if (!$product->is_active) throw new RuntimeException('Sản phẩm đã ngừng bán');
                    if (Auth::user()?->vip_level_id && !$product->vipLevels()->whereKey(Auth::user()->vip_level_id)->exists()) {
                        throw new RuntimeException('Bạn không còn quyền mua sản phẩm này');
                    }

                    $variant = $variantId
                        ? ProductVariant::query()->lockForUpdate()->where('product_id', $product->id)->whereKey($variantId)->where('is_active', true)->firstOrFail()
                        : null;
                    $stockOwner = $variant ?: $product;
                    if ($stockOwner->stock < $quantity) throw new RuntimeException("Sản phẩm {$product->name} không đủ số lượng");
                    $stockOwner->decrement('stock', $quantity);

                    $price = (float) ($variant?->price ?? $product->price);
                    return [
                        'product_id' => $product->id,
                        'variant_id' => $variant?->id,
                        'product_name' => $product->name,
                        'variant_name' => $variant?->name,
                        'sku' => $variant?->sku ?? $product->sku,
                        'unit_price' => $price,
                        'quantity' => $quantity,
                        'subtotal' => $price * $quantity,
                    ];
                });

                $subtotal = $snapshots->sum('subtotal');
                $order = Order::create([
                    'user_id' => Auth::id(), 'status' => 'new',
                    'customer_name' => $data->name, 'customer_phone' => $data->phone,
                    'customer_email' => $data->email, 'zalo_id' => $data->zaloId,
                    'delivery_address' => $data->deliveryAddress, 'delivery_date' => $data->deliveryDate,
                    'delivery_time' => $data->deliveryTime, 'subtotal' => $subtotal,
                    'shipping_fee' => null, 'total' => $subtotal, 'note' => $data->note,
                    'idempotency_key' => $data->idempotencyKey,
                ]);
                $order->items()->createMany($snapshots->all());
                if (!$data->items) CartItem::where(Auth::check() ? ['user_id' => Auth::id()] : ['session_id' => session()->getId()])->delete();
                return $order->load('items');
            });
        } catch (QueryException $e) {
            if ($data->idempotencyKey && $e->getCode() === '23000') {
                return Order::where('idempotency_key', $data->idempotencyKey)->firstOrFail()->load('items');
            }
            throw $e;
        }
    }
}
