<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    public function indent()
    {
        return $this->belongsTo(Indent::class, 'indent_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function added_by()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function items()
    {
        return $this->hasMany(ShipmentItems::class, 'shipment_id');
    }
}
