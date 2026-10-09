<?php

namespace Tests\Feature;

use App\Domain\Ordering\Actions\PlaceOrderAction;
use App\Domain\Ordering\Data\PlaceOrderData;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderPlacementTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_snapshots_stock_and_is_idempotent(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'category_id' => Category::create(['name' => 'Hoa', 'slug' => 'hoa'])->id,
            'name' => 'Hoa hồng', 'slug' => 'hoa-hong', 'price' => 100000, 'stock' => 3,
            'is_active' => true,
        ]);
        $this->actingAs($user);
        CartItem::create(['user_id' => $user->id, 'product_id' => $product->id, 'quantity' => 2]);
        $deliveryDate = now()->addDay()->toDateString();

        $data = new PlaceOrderData(
            'Test',
            '0900000000',
            idempotencyKey: 'checkout-test-1',
            deliveryAddress: '12 Nguyen Hue, Quan 1',
            deliveryDate: $deliveryDate,
            deliveryTime: '14:30',
        );
        $first = app(PlaceOrderAction::class)->execute($data);
        $second = app(PlaceOrderAction::class)->execute($data);

        $this->assertSame($first->id, $second->id);
        $this->assertSame(1, Order::count());
        $this->assertSame(1, Product::find($product->id)->stock);
        $this->assertSame(2, $first->items->first()->quantity);
        $this->assertSame('12 Nguyen Hue, Quan 1', $first->delivery_address);
        $this->assertSame($deliveryDate, $first->delivery_date->toDateString());
        $this->assertSame('14:30', $first->delivery_time);
        $this->assertSame('200000.00', $first->subtotal);
        $this->assertNull($first->shipping_fee);
        $this->assertSame($first->subtotal, $first->total);
        $this->assertDatabaseMissing('cart_items', ['user_id' => $user->id]);
    }

    public function test_checkout_request_persists_delivery_details(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'category_id' => Category::create(['name' => 'Hoa', 'slug' => 'hoa'])->id,
            'name' => 'Hoa lan', 'slug' => 'hoa-lan', 'price' => 150000, 'stock' => 2,
            'is_active' => true,
        ]);
        CartItem::create(['user_id' => $user->id, 'product_id' => $product->id, 'quantity' => 1]);
        $deliveryDate = now()->addDay()->toDateString();

        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'name' => 'Test Customer',
            'phone' => '0900000000',
            'delivery_address' => '34 Le Loi, Quan 1',
            'delivery_date' => $deliveryDate,
            'delivery_time' => '09:15',
        ]);

        $order = Order::sole();
        $response->assertRedirect(route('checkout.success', ['inquiry' => $order->id]));
        $this->assertSame('34 Le Loi, Quan 1', $order->delivery_address);
        $this->assertSame($deliveryDate, $order->delivery_date->toDateString());
        $this->assertSame('09:15', $order->delivery_time);
        $this->assertSame('150000.00', $order->subtotal);
        $this->assertNull($order->shipping_fee);
        $this->assertSame($order->subtotal, $order->total);
    }
}
