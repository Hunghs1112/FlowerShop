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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('sales_count')->default(0)->after('stock');
            $table->timestamp('latest_arrival_date')->nullable()->after('sales_count');
            
            $table->index('sales_count');
            $table->index('latest_arrival_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['sales_count']);
            $table->dropIndex(['latest_arrival_date']);
            $table->dropColumn(['sales_count', 'latest_arrival_date']);
        });
    }
};
