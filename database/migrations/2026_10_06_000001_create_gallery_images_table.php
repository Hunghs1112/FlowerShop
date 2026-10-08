<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->string('image'); // public or storage path
            $table->string('alt_text')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $images = [
            ['title' => 'PHÒNG KHÁCH', 'caption' => 'PHÒNG KHÁCH', 'alt_text' => 'Hoa trong phòng khách', 'image' => 'images/gallery/window-seat-01.jpg'],
            ['title' => 'XƯỞNG HOA', 'caption' => 'XƯỞNG HOA', 'alt_text' => 'Hoa tại xưởng', 'image' => 'images/gallery/window-seat-02.jpg'],
            ['title' => 'QUÀ TẶNG', 'caption' => 'QUÀ TẶNG', 'alt_text' => 'Hoa làm quà tặng', 'image' => 'images/gallery/window-seat-03.jpg'],
            ['title' => 'HOA VỀ KHO', 'caption' => 'HOA VỀ KHO', 'alt_text' => 'Hoa vừa về kho', 'image' => 'images/gallery/window-seat-04.jpg'],
            ['title' => 'TRAO TAY', 'caption' => 'TRAO TAY', 'alt_text' => 'Bó hoa được trao tận tay', 'image' => 'images/gallery/window-seat-05.jpg'],
        ];
        foreach ($images as $sortOrder => $image) {
            DB::table('gallery_images')->insert($image + ['sort_order' => $sortOrder, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_images');
    }
};
