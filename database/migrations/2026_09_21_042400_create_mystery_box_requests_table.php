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
        Schema::create('mystery_box_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->unique(); // LNT-MB-XXXX
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Customer info
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            
            // Mystery Box selections
            $table->string('style'); // Thanh lịch, Lãng mạn, Tự nhiên, Tối giản, Sang trọng
            $table->json('colors'); // Array: Trắng, Kem, Hồng, Xanh, Đỏ, Pastel, Không giới hạn
            $table->json('preferences'); // Array: Nhiều hoa, Ít hoa, Nhiều lá, Nhẹ nhàng, Nổi bật, Tự nhiên
            $table->string('budget_range'); // 500k-1M, 1M-2M, 2M-5M, 5M+
            $table->string('surprise_level'); // Bất ngờ hoàn toàn, Bất ngờ một phần, Muốn giữ một vài yêu cầu
            $table->text('note')->nullable();
            
            // Status
            $table->enum('status', ['new', 'reviewing', 'confirmed', 'completed', 'cancelled'])->default('new');
            
            $table->timestamps();
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mystery_box_requests');
    }
};
