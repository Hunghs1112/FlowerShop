<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pages')->insertOrIgnore([
            'slug' => 'tuyen-dung',
            'title' => 'Tuyển dụng',
            'content' => file_get_contents(resource_path('data/career.json')),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('pages')->where('slug', 'tuyen-dung')->delete();
    }
};
