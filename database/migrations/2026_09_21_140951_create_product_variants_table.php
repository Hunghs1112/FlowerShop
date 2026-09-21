<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('sku')->unique();
            $table->string('name')->nullable(); // Tên riêng của variant (nếu có)
            $table->decimal('price', 10, 2)->nullable(); // Giá riêng (nếu có)
            $table->integer('stock')->nullable(); // Tồn kho riêng (nếu có)
            $table->text('description')->nullable(); // Mô tả riêng (nếu có)
            $table->text('short_description')->nullable(); // Mô tả ngắn riêng (nếu có)
            $table->string('color')->nullable(); // Màu sắc
            $table->string('size')->nullable(); // Kích thước
            $table->json('attributes')->nullable(); // Các thuộc tính khác (JSON)
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['product_id', 'is_active']);
            $table->index('sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
