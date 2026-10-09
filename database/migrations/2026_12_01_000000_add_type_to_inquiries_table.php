<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->enum('type', ['contact', 'tree_preorder'])->default('contact')->after('user_id');
            $table->string('source_slug')->nullable()->after('type');
            $table->json('order_data')->nullable()->after('message');
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn(['type', 'source_slug', 'order_data']);
        });
    }
};
