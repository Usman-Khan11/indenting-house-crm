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
        Schema::create('indent_items', function (Blueprint $table) {
            $table->id();
            $table->integer('indent_id');
            $table->integer('item_id');
            $table->text('item_desc')->nullable();
            $table->string('qty', 15);
            $table->string('unit', 15)->nullable();
            $table->string('rate', 40);
            $table->string('total', 40);
            $table->string('shipment_mode', 50)->nullable();
            $table->string('payment_term', 150)->nullable();
            $table->integer('po_id')->nullable();
            $table->string('po_date', 15)->nullable();
            $table->string('lot_detail', 255)->nullable();
            $table->text('other_desc')->nullable();
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
        Schema::dropIfExists('indent_items');
    }
};
