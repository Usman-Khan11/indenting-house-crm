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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_no', 20);
            $table->string('date', 20)->nullable();
            $table->integer('customer_id');
            $table->integer('supplier_id');
            $table->integer('item_id');
            $table->integer('size_id');
            $table->string('image', 255)->nullable();
            $table->string('front_color', 50)->nullable();
            $table->string('front_code', 50)->nullable();
            $table->string('back_color', 50)->nullable();
            $table->string('back_code', 50)->nullable();
            $table->string('ingredient', 100)->nullable();
            $table->string('ref_code', 150)->nullable();
            $table->tinyInteger('status')->comment('1-Approved, 2-Pending at Supplier, 3-Pending at Customer');
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
        Schema::dropIfExists('cards');
    }
};
