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
        Schema::create('indents', function (Blueprint $table) {
            $table->id();
            $table->string('indent_no', 20);
            $table->string('date', 15);
            $table->integer('po_id');
            $table->integer('customer_id');
            $table->integer('supplier_id');
            $table->text('port_destination')->nullable();
            $table->text('port_shipment')->nullable();
            $table->string('partial_ship', 200)->nullable();
            $table->string('trans_shipment', 200)->nullable();
            $table->string('packing', 200)->nullable();
            $table->string('shipment', 200)->nullable();
            $table->string('shipping_type', 200)->nullable();
            $table->string('payment', 200)->nullable();
            $table->string('latest_date_of_shipment', 15)->nullable();
            $table->string('date_of_negotiation', 15)->nullable();
            $table->string('validity', 15)->nullable();
            $table->string('origin', 200)->nullable();
            $table->string('currency', 20)->nullable();
            $table->text('bank_detail')->nullable();
            $table->text('remark')->nullable();
            $table->text('remark_2')->nullable();
            $table->text('shipping_marks')->nullable();
            $table->tinyInteger('revised');
            $table->integer('added_by');
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
        Schema::dropIfExists('indents');
    }
};
