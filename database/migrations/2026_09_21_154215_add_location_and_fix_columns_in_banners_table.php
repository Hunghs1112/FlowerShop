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
        Schema::table('banners', function (Blueprint $table) {
            // Add location column
            $table->string('location')->default('home')->after('is_active');
            
            // Rename columns to match model expectations
            $table->renameColumn('link_url', 'button_link');
            $table->renameColumn('link_text', 'button_text');
            
            // Add index for location queries
            $table->index(['is_active', 'location', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            // Drop the location index
            $table->dropIndex(['is_active', 'location', 'sort_order']);
            
            // Rename columns back
            $table->renameColumn('button_link', 'link_url');
            $table->renameColumn('button_text', 'link_text');
            
            // Drop location column
            $table->dropColumn('location');
        });
    }
};
