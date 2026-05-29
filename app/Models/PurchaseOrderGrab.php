<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderGrab extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'rit_id',
        'description'
    ];

    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }

    public function rit()
    {
        return $this->belongsTo(Rit::class, 'rit_id', 'id');
    }
}
