<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function suppliers()
    {
        return $this->belongsToMany(SupplierProducts::class, 'product_id', 'id');
    }
}
