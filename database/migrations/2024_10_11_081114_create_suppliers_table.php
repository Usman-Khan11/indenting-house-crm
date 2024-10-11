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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('fax_number', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('person', 150)->nullable();
            $table->string('email_2', 150)->nullable();
            $table->string('person_2', 150)->nullable();
            $table->string('email_3', 150)->nullable();
            $table->string('person_3', 150)->nullable();
            $table->text('address')->nullable();
            $table->string('origin', 150)->nullable();
            $table->text('band_detail')->nullable();
            $table->string('swift_code', 50)->nullable();
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
        Schema::dropIfExists('suppliers');
    }
};
