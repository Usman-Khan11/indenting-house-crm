<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryItem extends Model
{
    use HasFactory;

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function item()
    {
        return $this->belongsTo(Product::class, 'item_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function suppliers()
    {
        return $this->hasMany(SupplierProducts::class, 'product_id', 'item_id');
    }
}
