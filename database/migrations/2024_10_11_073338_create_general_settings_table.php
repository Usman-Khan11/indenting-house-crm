<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('sitename', 150)->nullable();
            $table->string('logo', 150)->nullable();
            $table->integer('page_length')->default(10);
            $table->tinyInteger('expired')->default(0);
            $table->string('expired_at', 20)->nullable();
            $table->timestamps();
        });

        DB::table('general_settings')->insert([
            [
                'sitename' => 'MRI',
                'logo' => 'assets/img/logo.png',
                'page_length' => 15,
                'expired' => 0,
                'expired_at' => '2050-12-31',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_settings');
    }
};
