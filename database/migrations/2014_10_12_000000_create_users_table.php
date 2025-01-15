<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('designation', 255)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username', 200);
            $table->string('password', 255);
            $table->integer('role_id')->default(0);
            $table->string('remember_token', 100)->nullable();
            $table->text('imap_setting')->nullable();
            $table->timestamps();
        });

        DB::table('users')->insert([
            [
                'name' => 'MRI',
                'email' => 'admin@gmail.com',
                'phone' => '123456789',
                'address' => 'gulshan iqbal karachi',
                'designation' => 'CEO',
                'username' => 'admin',
                'password' => Hash::make('newpass@2020'),
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
