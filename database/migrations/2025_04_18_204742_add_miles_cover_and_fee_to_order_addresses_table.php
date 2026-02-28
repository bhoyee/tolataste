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
        Schema::table('order_addresses', function (Blueprint $table) {
            $table->decimal('miles_cover', 8, 2)->nullable()->after('address');
            $table->decimal('fee', 8, 2)->nullable()->after('miles_cover');
        });
    }
    
    public function down()
    {
        Schema::table('order_addresses', function (Blueprint $table) {
            $table->dropColumn(['miles_cover', 'fee']);
        });
    }
    
};
