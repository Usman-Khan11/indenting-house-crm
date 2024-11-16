<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('navs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('slug', 100)->nullable();
            $table->string('icon', 50)->nullable();
            $table->timestamps();
        });

        DB::table('navs')->insert([
            [
                'name' => 'Materials',
                'slug' => 'product',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customers',
                'slug' => 'customers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Suppliers',
                'slug' => 'suppliers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Inquiry',
                'slug' => 'inquiry',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Offers',
                'slug' => 'offers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Purchase Orders',
                'slug' => 'po',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Indents',
                'slug' => 'indents',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Reports',
                'slug' => 'reports',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Shipment',
                'slug' => 'shipment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sizes',
                'slug' => 'sizes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Shade Card & Artwork',
                'slug' => 'shade-card-and-artwork',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Proforma Invoices',
                'slug' => 'proforma_invoice',
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
        Schema::dropIfExists('navs');
    }
};
