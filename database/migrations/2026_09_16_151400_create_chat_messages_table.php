<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tạo bảng chat_messages để lưu trữ tin nhắn giữa user và admin.
     */
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_admin')->default(false); // true nếu admin gửi
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            // Index cho query: messages của 1 user, sort theo thời gian
            $table->index(['user_id', 'created_at']);
            // Index cho query: count unread messages
            $table->index(['is_read']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};