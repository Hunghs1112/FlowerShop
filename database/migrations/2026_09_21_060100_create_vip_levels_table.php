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
        Schema::create('vip_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // VIP 1, VIP 2, VIP 3
            $table->text('description')->nullable();
            $table->integer('priority')->default(0); // Order: 1, 2, 3
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('is_active');
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vip_levels');
    }
};
