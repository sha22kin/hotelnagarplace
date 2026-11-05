<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Footer widgets of the hotel theme: Facebook page box, YouTube video and Google map.
     */
    public function up(): void
    {
        Schema::table('generals', function (Blueprint $table) {
            if (! Schema::hasColumn('generals', 'facebook_page_url')) {
                $table->string('facebook_page_url', 300)->nullable();
            }
            if (! Schema::hasColumn('generals', 'youtube_video_url')) {
                $table->string('youtube_video_url', 300)->nullable();
            }
            if (! Schema::hasColumn('generals', 'google_map_url')) {
                $table->text('google_map_url')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('generals', function (Blueprint $table) {
            $table->dropColumn(['facebook_page_url', 'youtube_video_url', 'google_map_url']);
        });
    }
};
