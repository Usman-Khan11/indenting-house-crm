<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaInvoiceItems extends Model
{
    use HasFactory;
    protected $table = 'proforma_invoice_items';

    public function proforma_invoice()
    {
        return $this->belongsTo(ProformaInvoice::class, 'proforma_invoice_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Product::class, 'item_id', 'id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id', 'id');
    }

    public function artwork()
    {
        return $this->belongsTo(Artwork::class, 'artwork_id', 'id');
    }
}
