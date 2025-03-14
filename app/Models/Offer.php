<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $appends = ['is_booked'];

    public function getIsBookedAttribute()
    {
        return ($this->po && $this->po->indent) ? 1 : 0;
    }

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
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
        return $this->hasMany(OfferItem::class);
    }

    public function po()
    {
        return $this->belongsTo(PurchaseOrder::class, 'id', 'offer_id');
    }
}
