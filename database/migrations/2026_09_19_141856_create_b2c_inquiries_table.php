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
        Schema::create('b2c_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('business_type', 100);
            $table->string('contact_name', 255);
            $table->string('contact_email', 255)->nullable();
            $table->string('business_name', 255);
            $table->string('address', 500);
            $table->string('phone', 30);
            $table->unsignedSmallInteger('years_in_business')->default(0);
            $table->string('social_media', 500);
            $table->string('tax_code', 50);
            $table->string('vat_email', 255);
            $table->string('business_license', 100);
            $table->enum('status', ['new', 'contacted', 'completed'])->default('new');
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b2c_inquiries');
    }
};
