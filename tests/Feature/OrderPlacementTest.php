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

        $data = new PlaceOrderData('Test', '0900000000', idempotencyKey: 'checkout-test-1');
        $first = app(PlaceOrderAction::class)->execute($data);
        $second = app(PlaceOrderAction::class)->execute($data);

        $this->assertSame($first->id, $second->id);
        $this->assertSame(1, Order::count());
        $this->assertSame(1, Product::find($product->id)->stock);
        $this->assertSame(2, $first->items->first()->quantity);
        $this->assertDatabaseMissing('cart_items', ['user_id' => $user->id]);
    }
}
