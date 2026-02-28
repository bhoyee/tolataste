<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->longText('soup_item')->nullable()->after('protein_item');
            $table->longText('wrap_item')->nullable()->after('soup_item');
            $table->longText('drink_item')->nullable()->after('wrap_item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->dropColumn('soup_item');
            $table->dropColumn('wrap_item');
            $table->dropColumn('drink_item');
        });
    }
};
