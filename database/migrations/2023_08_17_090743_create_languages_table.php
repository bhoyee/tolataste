<?php

use App\Models\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\App;
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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->string('icon')->nullable();
            $table->string('direction', 3)->default('ltr');
            $table->timestamps();
        });

        $languages = [
            [
                'name' => 'English',
                'code' => 'en',
                'icon' => '',
                'direction' => 'ltr',
            ],
            [
                'name' => 'Bangla',
                'code' => 'bn',
                'icon' => '',
                'direction' => 'ltr',
            ],
            [
                'name' => 'Arabic',
                'code' => 'ar',
                'icon' => '',
                'direction' => 'rtl',
            ]

        ];

        Language::insert($languages);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
};
