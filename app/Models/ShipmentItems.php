<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentItems extends Model
{
    use HasFactory;
    protected $table = 'shipment_items';

    public function shipment()
    {
        return $this->belongsTo(Indent::class, 'shipment_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Product::class, 'item_id', 'id');
    }
}
