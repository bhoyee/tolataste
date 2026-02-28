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
        Schema::create('catering_requests', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->text('delivery_address');
            $table->string('occasion')->nullable();
            $table->date('event_date');
            $table->string('catering_type');
            $table->string('event_start_time')->nullable();
            $table->string('dropoff_time')->nullable();
            $table->integer('guest_count');
            $table->text('menu_items');
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
        Schema::dropIfExists('catering_requests');
    }
};
