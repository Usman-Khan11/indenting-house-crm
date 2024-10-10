<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndentItems extends Model
{
    use HasFactory;
    protected $table = 'indent_items';

    public function indent()
    {
        return $this->belongsTo(Indent::class, 'indent_id', 'id');
    }

    public function po()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Product::class, 'item_id', 'id');
    }
}
