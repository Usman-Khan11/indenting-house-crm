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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('offer_no', 20)->nullable();
            $table->string('date', 20)->nullable();
            $table->integer('inquiry_id');
            $table->string('currency', 20)->nullable();
            $table->string('shipping_type', 25)->nullable();
            $table->string('validity', 20)->nullable();
            $table->integer('customer_id');
            $table->text('remark')->nullable();
            $table->text('remark_2')->nullable();
            $table->text('status_remark')->nullable();
            $table->string('signature', 150)->nullable();
            $table->integer('added_by')->default(0);
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
        Schema::dropIfExists('offers');
    }
};
