<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_collections', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->string('slug_en')->nullable()->unique()->after('slug');
            $table->text('criterion_en')->nullable()->after('criterion');
        });
    }

    public function down(): void
    {
        Schema::table('product_collections', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'slug_en', 'criterion_en']);
        });
    }
};
