<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Birthday', 'description' => 'Beautiful flowers for birthday celebrations', 'icon' => '🎂'],
            ['name' => 'Wedding', 'description' => 'Elegant flowers for weddings and ceremonies', 'icon' => '💒'],
            ['name' => 'Grand Opening', 'description' => 'Impressive flowers for business openings', 'icon' => '🎊'],
            ['name' => 'Congratulations', 'description' => 'Flowers to celebrate achievements', 'icon' => '🎉'],
            ['name' => 'Anniversary', 'description' => 'Romantic flowers for anniversaries', 'icon' => '💕'],
            ['name' => 'Sympathy', 'description' => 'Respectful flowers for condolences', 'icon' => '🕊️'],
            ['name' => 'Valentine', 'description' => 'Romantic flowers for Valentine\'s Day', 'icon' => '❤️'],
            ['name' => 'Mother\'s Day', 'description' => 'Special flowers for mothers', 'icon' => '👩'],
        ];

        foreach ($categories as $index => $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'icon' => $category['icon'],
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
