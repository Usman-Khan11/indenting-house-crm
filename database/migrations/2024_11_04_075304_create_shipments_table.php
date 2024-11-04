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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('shipment_no', 20);
            $table->string('date', 20);
            $table->string('currency', 30)->nullable();
            $table->integer('indent_id');
            $table->integer('supplier_id');
            $table->integer('customer_id');
            $table->string('lc_bt_tt_no', 100)->nullable();
            $table->string('lc_issue_date', 20)->nullable();
            $table->string('lc_exp_date', 20)->nullable();
            $table->string('lot_no', 100)->nullable();
            $table->string('inv_no', 40)->nullable();
            $table->string('inv_date', 20)->nullable();
            $table->string('bl_id', 40)->nullable();
            $table->string('bl_date', 20)->nullable();
            $table->text('payment_remark')->nullable();
            $table->text('final_remark')->nullable();
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
        Schema::dropIfExists('shipments');
    }
};
