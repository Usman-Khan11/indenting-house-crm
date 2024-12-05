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
        Schema::create('nav_keys', function (Blueprint $table) {
            $table->id();
            $table->integer('nav_id');
            $table->string('key', 100)->nullable();
            $table->timestamps();
        });

        DB::table('nav_keys')->insert([
            // Materials
            [
                'nav_id' => 1,
                'key' => 'create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 1,
                'key' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 1,
                'key' => 'update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 1,
                'key' => 'delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 1,
                'key' => 'map',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Customers
            [
                'nav_id' => 2,
                'key' => 'create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 2,
                'key' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 2,
                'key' => 'update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 2,
                'key' => 'delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 2,
                'key' => 'map product',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Suppliers
            [
                'nav_id' => 3,
                'key' => 'create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 3,
                'key' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 3,
                'key' => 'update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 3,
                'key' => 'delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 3,
                'key' => 'map product',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Inquiry
            [
                'nav_id' => 4,
                'key' => 'create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 4,
                'key' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 4,
                'key' => 'update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 4,
                'key' => 'delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Offer
            [
                'nav_id' => 5,
                'key' => 'create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 5,
                'key' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 5,
                'key' => 'update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 5,
                'key' => 'delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Purchase Orders
            [
                'nav_id' => 6,
                'key' => 'create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 6,
                'key' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 6,
                'key' => 'update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 6,
                'key' => 'delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Indents
            [
                'nav_id' => 7,
                'key' => 'create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 7,
                'key' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 7,
                'key' => 'update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 7,
                'key' => 'delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Reports
            [
                'nav_id' => 8,
                'key' => 'supplier list',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 8,
                'key' => 'customer list',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 8,
                'key' => 'material list',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 8,
                'key' => 'item wise supplier',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 8,
                'key' => 'item wise customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 8,
                'key' => 'inquiry',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 8,
                'key' => 'offer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 8,
                'key' => 'po',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 8,
                'key' => 'indent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 8,
                'key' => 'shipment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Shipments
            [
                'nav_id' => 9,
                'key' => 'create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 9,
                'key' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 9,
                'key' => 'update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 9,
                'key' => 'delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Sizes
            [
                'nav_id' => 10,
                'key' => 'create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 10,
                'key' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 10,
                'key' => 'update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 10,
                'key' => 'delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Shade Card & Artwork
            [
                'nav_id' => 11,
                'key' => 'create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 11,
                'key' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 11,
                'key' => 'update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 11,
                'key' => 'delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Proforma Invoices
            [
                'nav_id' => 12,
                'key' => 'create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 12,
                'key' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 12,
                'key' => 'update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nav_id' => 12,
                'key' => 'delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nav_keys');
    }
};
