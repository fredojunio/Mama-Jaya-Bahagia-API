<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_code',
        'item_id',
        'tonnage',
        'buy_price',
        'status',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    public function grabs()
    {
        return $this->hasMany(PurchaseOrderGrab::class, 'purchase_order_id', 'id');
    }
}
