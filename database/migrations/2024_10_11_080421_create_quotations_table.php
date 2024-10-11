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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('num', 200);
            $table->integer('customer_id');
            $table->string('validity', 150)->nullable();
            $table->string('subject', 150)->nullable();
            $table->string('gst', 20)->default('0');
            $table->string('date', 20)->nullable();
            $table->string('sst', 20)->default('0');
            $table->tinyInteger('tax')->default(0);
            $table->string('discount', 20)->default('0');
            $table->string('s_discount', 20)->default('0');
            $table->text('note')->nullable();
            $table->text('delivery')->nullable();
            $table->text('payment')->nullable();
            $table->text('warranty')->nullable();
            $table->tinyInteger('gdn')->default(0);
            $table->integer('added_by');
            $table->text('show_txt')->nullable();
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
        Schema::dropIfExists('quotations');
    }
};
