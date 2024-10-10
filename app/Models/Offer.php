<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function added_by()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function items()
    {
        return $this->hasMany(OfferItem::class);
    }
}
