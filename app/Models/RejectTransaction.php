<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        "daily_id",
        "tb",
        "tw",
        "thr",
        "sack",
        "sack_free",
        "sack_price",
        "other",
        "item_price",
        "discount",
        "ongkir",
        "total_price",
        "settled_date",
        "owner_approved",
        "finance_approved",
        "revision_requested",
        "revision_allowed",
        "revision_note",
        "customer_id",
        "cas_id",
        "trip_id",
        "type",
        "created_at"
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
