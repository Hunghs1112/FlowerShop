<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    public function test_admin_can_create_user_with_account_settings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.users.store'), [
                'name' => 'Khách Hàng',
                'email' => 'customer@example.com',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
                'role' => 'customer',
                'is_active' => false,
            ])
            ->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'customer@example.com',
            'role' => 'customer',
            'is_active' => false,
        ]);
    }

    public function test_admin_can_auto_save_user_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $this->actingAs($admin)
            ->patchJson(route('admin.users.updateField', $user), [
                'field' => 'is_active',
                'value' => '0',
            ])
            ->assertOk();

        $this->assertFalse($user->fresh()->is_active);
    }

    public function test_admin_cannot_demote_lock_or_delete_their_own_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        foreach ([['role', 'customer'], ['is_active', '0']] as [$field, $value]) {
            $this->actingAs($admin)
                ->patchJson(route('admin.users.updateField', $admin), compact('field', 'value'))
                ->assertUnprocessable();
        }

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $admin))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_update_password_and_delete_another_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $this->actingAs($admin)
            ->put(route('admin.users.update', $user), [
                'name' => $user->name,
                'email' => $user->email,
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
                'role' => 'customer',
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.users.index'));

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $user))
            ->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_user_pages_render_auto_save_url_and_pagination(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->count(15)->create();

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee(route('admin.users.index', ['page' => 2]), false);

        $user = User::whereKeyNot($admin->id)->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.users.edit', $user))
            ->assertSee(route('admin.users.updateField', $user), false)
            ->assertSee('password_confirmation', false);
    }

    public function test_registration_moves_to_admin_creation_and_customers_keep_profile_editing(): void
    {
        $this->get(route('register'))
            ->assertRedirect(route('login'))
            ->assertSessionHas('status');

        $this->post(route('register'), [
            'name' => 'Public Registration',
            'email' => 'public@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('login'));

        $this->assertDatabaseMissing('users', ['email' => 'public@example.com']);

        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)
            ->get(route('register'))
            ->assertRedirect(route('admin.users.create'));

        $customer = User::factory()->create();
        $this->actingAs($customer)
            ->patch(route('profile.update'), [
                'name' => 'Khách Hàng Mới',
                'email' => $customer->email,
                'phone' => '0901234567',
                'address' => 'Hồ Chí Minh',
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'name' => 'Khách Hàng Mới',
            'phone' => '0901234567',
            'address' => 'Hồ Chí Minh',
        ]);
    }

    public function test_locked_customer_is_logged_out_on_the_next_request(): void
    {
        $customer = User::factory()->create(['is_active' => false]);

        $this->actingAs($customer)
            ->get(route('profile.show'))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
