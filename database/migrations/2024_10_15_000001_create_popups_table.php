<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('popups', function (Blueprint $table) {
            $table->id();
            $table->string('id_key')->unique()->comment('Unique identifier for the popup campaign');
            $table->boolean('is_active')->default(false);
            $table->string('theme', 20)->default('cream')->comment('Theme: cream, nordic, rose, autumn, night');
            $table->string('eyebrow')->nullable()->comment('Top banner text');
            $table->string('route')->nullable()->comment('Route info like LNT → HAN');
            $table->string('title')->comment('Main title');
            $table->text('text')->nullable()->comment('Description text');
            $table->json('bullets')->nullable()->comment('Bullet points array');
            $table->date('start_date')->comment('Campaign start date');
            $table->date('end_date')->comment('Campaign end date');
            $table->datetime('countdown')->nullable()->comment('Countdown target datetime');
            $table->string('countdown_label')->nullable()->default('CÒN');
            $table->string('image')->nullable()->comment('Image URL');
            $table->string('image_alt')->nullable()->comment('Image alt text');
            $table->string('stamp')->nullable()->comment('Stamp text like 20/10');
            $table->string('stamp_sub')->nullable()->comment('Stamp subtitle');
            $table->string('cta_label')->nullable()->comment('Primary button label');
            $table->string('cta_link')->nullable()->comment('Primary button link');
            $table->string('cta2')->nullable()->comment('Secondary button type: zalo or custom');
            $table->string('cta2_label')->nullable()->comment('Secondary button label');
            $table->string('cta2_link')->nullable()->comment('Secondary button link');
            $table->text('note')->nullable()->comment('Footer note');
            $table->string('teaser')->nullable()->comment('Teaser button text');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('popups');
    }
};
