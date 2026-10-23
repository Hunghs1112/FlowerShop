<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('origin_en')->nullable()->after('origin');
            $table->text('specification_en')->nullable()->after('specification');
            $table->string('unit_en')->nullable()->after('unit');
        });

        Schema::table('flower_origins', function (Blueprint $table) {
            $table->string('country_en')->nullable()->after('country');
            $table->string('flower_en')->nullable()->after('flower');
            $table->string('region_en')->nullable()->after('region');
        });

        Schema::table('gallery_images', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('caption_en')->nullable()->after('caption');
            $table->string('alt_text_en')->nullable()->after('alt_text');
        });
    }

    public function down(): void
    {
        Schema::table('gallery_images', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'caption_en', 'alt_text_en']);
        });

        Schema::table('flower_origins', function (Blueprint $table) {
            $table->dropColumn(['country_en', 'flower_en', 'region_en']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['origin_en', 'specification_en', 'unit_en']);
        });
    }
};
