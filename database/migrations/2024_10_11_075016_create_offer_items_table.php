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
        Schema::create('offer_items', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_id');
            $table->integer('item_id');
            $table->text('item_desc')->nullable();
            $table->string('qty', 15);
            $table->string('unit', 15)->nullable();
            $table->string('rate', 40);
            $table->string('total', 40);
            $table->string('shipping_type', 25)->nullable();
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
        Schema::dropIfExists('offer_items');
    }
};
