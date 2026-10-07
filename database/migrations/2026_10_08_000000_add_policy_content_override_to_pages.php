<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pages', 'policy_content_override')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->longText('policy_content_override')->nullable()->after('policy_updated_at_display');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pages', 'policy_content_override')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->dropColumn('policy_content_override');
            });
        }
    }
};
