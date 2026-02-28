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
        Schema::table('products', function (Blueprint $table) {
            $table->text('soup_item')->nullable()->after('protein_item');
            $table->text('wrap_item')->nullable()->after('soup_item');
            $table->text('drink_item')->nullable()->after('wrap_item');
        });
    }
    
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['soup_item', 'wrap_item', 'drink_item']);
        });
    }
    
};
