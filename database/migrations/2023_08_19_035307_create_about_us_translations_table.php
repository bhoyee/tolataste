<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_us_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('about_us_id');
            $table->string('language');
            $table->longText('about_us')->nullable();
            $table->string('video_title')->nullable();
            $table->string('about_us_short_title')->nullable();
            $table->string('about_us_long_title')->nullable();
            $table->string('why_choose_us_short_title')->nullable();
            $table->string('why_choose_us_long_title')->nullable();
            $table->text('why_choose_us_description')->nullable();
            $table->string('title_one')->nullable();
            $table->string('title_two')->nullable();
            $table->string('title_three')->nullable();
            $table->string('title_four')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('about_us_translations');
    }
};
