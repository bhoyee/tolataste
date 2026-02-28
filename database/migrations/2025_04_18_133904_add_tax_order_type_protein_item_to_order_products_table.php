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
    Schema::table('order_products', function (Blueprint $table) {
        $table->double('tax')->default(0)->after('optional_item');
        $table->string('order_type')->nullable()->after('tax');
        $table->json('protein_item')->nullable()->after('order_type');
    });
}

public function down()
{
    Schema::table('order_products', function (Blueprint $table) {
        $table->dropColumn(['tax', 'order_type', 'protein_item']);
    });
}

};
