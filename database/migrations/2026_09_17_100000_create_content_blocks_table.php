<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tạo bảng content_blocks để lưu trữ các khối nội dung text có thể chỉnh sửa
     * qua giao diện admin (không cần động đến code hay file ngôn ngữ).
     */
    public function up(): void
    {
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();

            // Key duy nhất để truy xuất trong code, ví dụ: 'hero_slide_1_title'
            $table->string('key')->unique();

            // Giá trị nội dung (text/textarea/richtext)
            $table->text('value')->nullable();

            // Loại field: 'text' (input ngắn), 'textarea' (multi-line), 'richtext' (HTML)
            $table->string('type')->default('text');

            // Nhóm để phân loại trong admin UI: home_hero, product_pages, auth, ...
            $table->string('group')->default('general');

            // Nhãn hiển thị trong admin để admin dễ nhận biết
            $table->string('label')->nullable();

            // Mô tả công dụng của block (gợi ý cho admin)
            $table->string('description')->nullable();

            // Thứ tự hiển thị trong cùng một group
            $table->unsignedInteger('order')->default(0);

            $table->timestamps();

            // Index giúp truy vấn nhanh theo key và group
            $table->index('key');
            $table->index('group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
    }
};