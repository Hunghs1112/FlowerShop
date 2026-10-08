<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mystery_box_requests', function (Blueprint $table) {
            $table->json('flower_preferences')->nullable()->after('preferences');
            $table->string('delivery_address', 500)->nullable()->after('note');
            $table->date('delivery_date')->nullable()->after('delivery_address');
        });
    }

    public function down(): void
    {
        Schema::table('mystery_box_requests', function (Blueprint $table) {
            $table->dropColumn(['flower_preferences', 'delivery_address', 'delivery_date']);
        });
    }
};
