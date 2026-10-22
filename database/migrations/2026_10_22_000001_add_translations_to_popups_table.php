<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('popups', function (Blueprint $table) {
            $table->string('eyebrow_en')->nullable()->after('eyebrow');
            $table->string('title_en')->nullable()->after('title');
            $table->text('text_en')->nullable()->after('text');
            $table->json('bullets_en')->nullable()->after('bullets');
            $table->string('countdown_label_en')->nullable()->after('countdown_label');
            $table->string('image_alt_en')->nullable()->after('image_alt');
            $table->string('stamp_sub_en')->nullable()->after('stamp_sub');
            $table->string('cta_label_en')->nullable()->after('cta_label');
            $table->string('cta2_label_en')->nullable()->after('cta2_label');
            $table->text('note_en')->nullable()->after('note');
            $table->string('teaser_en')->nullable()->after('teaser');
        });
    }

    public function down(): void
    {
        Schema::table('popups', function (Blueprint $table) {
            $table->dropColumn([
                'eyebrow_en', 'title_en', 'text_en', 'bullets_en', 'countdown_label_en',
                'image_alt_en', 'stamp_sub_en', 'cta_label_en', 'cta2_label_en', 'note_en', 'teaser_en',
            ]);
        });
    }
};
