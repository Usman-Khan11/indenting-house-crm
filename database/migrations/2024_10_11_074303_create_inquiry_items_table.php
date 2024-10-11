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
        Schema::create('inquiry_items', function (Blueprint $table) {
            $table->id();
            $table->integer('inquiry_id');
            $table->integer('item_id');
            $table->string('qty', 15);
            $table->string('unit', 15)->nullable();
            $table->string('rate', 15);
            $table->string('total', 15);
            $table->string('shipment_mode', 50)->nullable();
            $table->string('payment_term', 150)->nullable();
            $table->string('delivery', 150)->nullable();
            $table->integer('supplier_id');
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
        Schema::dropIfExists('inquiry_items');
    }
};
