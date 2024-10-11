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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('location', 150)->nullable();
            $table->string('fax_number', 50)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('person', 150)->nullable();
            $table->string('email_2', 150)->nullable();
            $table->string('person_2', 150)->nullable();
            $table->string('email_3', 150)->nullable();
            $table->string('person_3', 150)->nullable();
            $table->text('address_office')->nullable();
            $table->text('address_factory')->nullable();
            $table->string('cell_1', 80)->nullable();
            $table->string('cell_2', 80)->nullable();
            $table->string('cell_3', 80)->nullable();
            $table->string('phone_1', 80)->nullable();
            $table->string('phone_2', 80)->nullable();
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
        Schema::dropIfExists('customers');
    }
};
