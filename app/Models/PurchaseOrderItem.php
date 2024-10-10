<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    public function po()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Product::class, 'item_id', 'id');
    }
}
