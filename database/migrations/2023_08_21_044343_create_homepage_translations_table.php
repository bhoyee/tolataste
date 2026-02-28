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
        Schema::create('homepage_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('homepage_id');
            $table->string('language');
            $table->string('today_special_short_title')->nullable();
            $table->string('today_special_long_title')->nullable();
            $table->text('today_special_description')->nullable();
            $table->string('menu_short_title')->nullable();
            $table->string('menu_long_title')->nullable();
            $table->text('menu_description')->nullable();
            $table->string('chef_short_title')->nullable();
            $table->string('chef_long_title')->nullable();
            $table->text('chef_description')->nullable();
            $table->string('testimonial_short_title')->nullable();
            $table->string('testimonial_long_title')->nullable();
            $table->text('testimonial_description')->nullable();
            $table->string('blog_short_title')->nullable();
            $table->string('blog_long_title')->nullable();
            $table->text('blog_description')->nullable();
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
        Schema::dropIfExists('homepage_translations');
    }
};
