<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'length')) {
                $table->string('length')->nullable()->after('description');
            }
            if (!Schema::hasColumn('products', 'min_order_quantity')) {
                $table->integer('min_order_quantity')->default(1)->after('length');
            }
            if (!Schema::hasColumn('products', 'origin')) {
                $table->string('origin')->nullable()->after('min_order_quantity');
            }
            if (!Schema::hasColumn('products', 'specification')) {
                $table->text('specification')->nullable()->after('origin');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['length', 'min_order_quantity', 'origin', 'specification']);
        });
    }
};
