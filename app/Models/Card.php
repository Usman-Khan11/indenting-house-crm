<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    public function artwork()
    {
        return $this->belongsTo(Artwork::class, 'id', 'card_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function item()
    {
        return $this->belongsTo(Product::class, 'item_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
