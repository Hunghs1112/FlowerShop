<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->longText('description_en')->nullable()->after('description');
        });

        Schema::table('subcategories', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->string('slug_en')->nullable()->unique()->after('slug');
            $table->text('description_en')->nullable()->after('description');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('slug_en')->nullable()->unique()->after('slug');
            $table->text('excerpt_en')->nullable()->after('excerpt');
            $table->longText('content_en')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'slug_en', 'excerpt_en', 'content_en']);
        });

        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'slug_en', 'description_en']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('description_en');
        });
    }
};
