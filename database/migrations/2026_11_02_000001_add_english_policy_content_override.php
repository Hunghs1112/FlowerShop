<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('pages', 'policy_content_override_en')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->longText('policy_content_override_en')->nullable()->after('policy_content_override');
            });
        }

        DB::table('pages')->insertOrIgnore([
            'slug' => 'chinh-sach-uu-dai-doanh-nghiep',
            'title' => 'Chính sách ưu đãi doanh nghiệp',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        if (Schema::hasColumn('pages', 'policy_content_override_en')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->dropColumn('policy_content_override_en');
            });
        }

        DB::table('pages')->where('slug', 'chinh-sach-uu-dai-doanh-nghiep')->delete();
    }
};
