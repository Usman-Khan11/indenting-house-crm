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
        Schema::create('proforma_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->integer('proforma_invoice_id');
            $table->integer('item_id');
            $table->string('qty', 15);
            $table->string('unit', 15)->nullable();
            $table->string('rate', 40);
            $table->string('total', 40);
            $table->integer('size_id')->nullable()->default(0);
            $table->integer('artwork_id')->nullable()->default(0);
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
        Schema::dropIfExists('proforma_invoice_items');
    }
};
