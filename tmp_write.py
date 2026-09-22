from pathlib import Path

# 1) Migration
Path("database/migrations/2026_09_22_220000_add_header_image_to_pages_table.php").write_text("""<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('header_image')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('header_image');
        });
    }
};
""", encoding="utf-8")

print("migration written")
