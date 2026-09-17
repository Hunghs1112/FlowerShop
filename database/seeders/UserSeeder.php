<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@lamnhienthao.vn'],
            [
                'name' => 'Admin',
                'email' => 'admin@lamnhienthao.vn',
                'password' => Hash::make('password'),
                'phone' => '0909999999',
                'address' => '123 Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh',
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Sample customers
        User::updateOrCreate(
            ['email' => 'customer1@example.com'],
            [
                'name' => 'Nguyễn Văn An',
                'email' => 'customer1@example.com',
                'password' => Hash::make('password'),
                'phone' => '0912345678',
                'address' => '456 Lê Lợi, Quận 3, TP. Hồ Chí Minh',
                'role' => 'customer',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'customer2@example.com'],
            [
                'name' => 'Trần Thị Bình',
                'email' => 'customer2@example.com',
                'password' => Hash::make('password'),
                'phone' => '0923456789',
                'address' => '789 Nguyễn Trãi, Quận 7, TP. Hồ Chí Minh',
                'role' => 'customer',
                'is_active' => true,
            ]
        );
    }
}
