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
        Schema::create('terms_and_condition_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('terms_and_condition_id');
            $table->string('language');
            $table->longText('terms_and_condition')->nullable();
            $table->longText('privacy_policy')->nullable();
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
        Schema::dropIfExists('terms_and_condition_translations');
    }
};
