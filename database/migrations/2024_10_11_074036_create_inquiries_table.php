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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('inq_no', 20);
            $table->integer('customer_id');
            $table->string('currency', 20)->nullable();
            $table->string('validity', 20)->nullable();
            $table->text('remark')->nullable();
            $table->text('remark_2')->nullable();
            $table->string('signature', 100)->nullable();
            $table->text('reason_of_close')->nullable();
            $table->tinyInteger('is_close')->default(0);
            $table->string('closed_at', 20)->nullable();
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
        Schema::dropIfExists('inquiries');
    }
};
