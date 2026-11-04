<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discount_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('name_en', 100)->nullable();
            $table->string('description', 255)->nullable();
            $table->unsignedTinyInteger('discount_percent');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('discount_group_product', function (Blueprint $table) {
            $table->foreignId('discount_group_id')->constrained('discount_groups')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['discount_group_id', 'product_id']);
            $table->unique('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discount_group_product');
        Schema::dropIfExists('discount_groups');
    }
};
