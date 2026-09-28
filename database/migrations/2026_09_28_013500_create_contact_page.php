<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!DB::table('pages')->where('slug', 'lien-he')->exists()) {
            DB::table('pages')->insert([
                'title' => 'Liên hệ',
                'slug' => 'lien-he',
                'content' => 'Hãy liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi nào. Chúng tôi luôn sẵn sàng hỗ trợ bạn.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('pages')->where('slug', 'lien-he')->delete();
    }
};
