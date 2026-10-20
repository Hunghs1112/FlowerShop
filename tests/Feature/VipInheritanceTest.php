<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\VipLevel;
use App\Services\CartService;
use Exception;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class VipInheritanceTest extends TestCase
{
    public function test_higher_vip_level_inherits_products_from_lower_levels(): void
    {
        [$highest, $lowest, $highestProduct, $lowestProduct] = $this->catalog();
        $highestUser = User::factory()->create(['vip_level_id' => $highest->id]);
        $lowestUser = User::factory()->create(['vip_level_id' => $lowest->id]);

        $this->assertEqualsCanonicalizing(
            [$highestProduct->id, $lowestProduct->id],
            Product::visibleToUser($highestUser)->pluck('id')->all(),
        );
        $this->assertSame(
            [$lowestProduct->id],
            Product::visibleToUser($lowestUser)->pluck('id')->all(),
        );
        $this->assertTrue($lowestProduct->isAccessibleTo($highestUser));
        $this->assertFalse($highestProduct->isAccessibleTo($lowestUser));
    }

    public function test_cart_uses_inherited_vip_access(): void
    {
        [$highest, $lowest, $highestProduct, $lowestProduct] = $this->catalog();
        $highestUser = User::factory()->create(['vip_level_id' => $highest->id]);
        $lowestUser = User::factory()->create(['vip_level_id' => $lowest->id]);

        $this->actingAs($highestUser);
        app(CartService::class)->addItem($lowestProduct->id);
        $this->assertDatabaseHas('cart_items', [
            'user_id' => $highestUser->id,
            'product_id' => $lowestProduct->id,
        ]);

        $this->actingAs($lowestUser);
        $this->expectException(Exception::class);
        app(CartService::class)->addItem($highestProduct->id);
    }

    public function test_inactive_vip_behaves_like_a_regular_customer(): void
    {
        [$highest, $lowest, $highestProduct, $lowestProduct] = $this->catalog();
        $lowest->update(['is_active' => false]);
        $user = User::factory()->create(['vip_level_id' => $lowest->id]);

        $this->assertEqualsCanonicalizing(
            [$highestProduct->id, $lowestProduct->id],
            Product::visibleToUser($user)->pluck('id')->all(),
        );
        $this->assertTrue($highestProduct->isAccessibleTo($user));
    }

    public function test_loaded_vip_levels_are_reused_without_an_extra_query(): void
    {
        [$highest, , , $lowestProduct] = $this->catalog();
        $user = User::factory()->create(['vip_level_id' => $highest->id])->load('vipLevel');
        $lowestProduct->load('vipLevels');

        DB::enableQueryLog();
        $this->assertTrue($lowestProduct->isAccessibleTo($user));
        $this->assertCount(0, DB::getQueryLog());
    }

    public function test_vip_priorities_must_be_unique(): void
    {
        $existing = VipLevel::create(['name' => 'VIP Một', 'priority' => 1, 'is_active' => true]);
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.vip-levels.store'), [
                'name' => 'VIP Hai',
                'priority' => $existing->priority,
                'is_active' => true,
            ])
            ->assertSessionHasErrors('priority');

        $other = VipLevel::create(['name' => 'VIP Hai', 'priority' => 2, 'is_active' => true]);
        $this->actingAs($admin)
            ->patchJson(route('admin.vip-levels.autoSave', $other), [
                'field' => 'priority',
                'value' => $existing->priority,
            ])
            ->assertUnprocessable();
    }

    private function catalog(): array
    {
        $highest = VipLevel::create(['name' => 'VIP Cao', 'priority' => 0, 'is_active' => true]);
        $lowest = VipLevel::create(['name' => 'VIP Thấp', 'priority' => 10, 'is_active' => true]);
        $category = Category::create(['name' => 'Hoa', 'slug' => 'hoa']);
        $highestProduct = Product::create([
            'category_id' => $category->id,
            'name' => 'Hoa VIP Cao',
            'slug' => 'hoa-vip-cao',
            'price' => 100000,
            'stock' => 10,
            'is_active' => true,
        ]);
        $lowestProduct = Product::create([
            'category_id' => $category->id,
            'name' => 'Hoa VIP Thấp',
            'slug' => 'hoa-vip-thap',
            'price' => 100000,
            'stock' => 10,
            'is_active' => true,
        ]);
        $highestProduct->vipLevels()->attach($highest);
        $lowestProduct->vipLevels()->attach($lowest);

        return [$highest, $lowest, $highestProduct, $lowestProduct];
    }
}
