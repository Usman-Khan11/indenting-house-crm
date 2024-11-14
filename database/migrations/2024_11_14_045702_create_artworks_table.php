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
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->integer('card_id');
            $table->string('artwork_no', 20);
            $table->string('front_print', 50)->nullable();
            $table->string('front_print_color', 50)->nullable();
            $table->string('back_print', 50)->nullable();
            $table->string('back_print_color', 50)->nullable();
            $table->text('remarks')->nullable();
            $table->tinyInteger('status')->comment('1-Approved, 2-Pending at Supplier, 3-Pending at Customer');
            $table->tinyInteger('print_style')->comment('1-Axial Not Rectified, 2-Radial Not Rectified, 3-Not Known, 4-Axial Rectified, 5-Radial Rectified');
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
        Schema::dropIfExists('artworks');
    }
};
