<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RitTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        "daily_id",
        "customer_name",
        "tonnage",
        "masak",
        "item_price",
        "total_price",
        "tonnage_left",
        "actual_tonnage",
        "rit_id",
        "transaction_id",
        "created_at"
    ];
    public function rit()
    {
        return $this->belongsTo(Rit::class, 'rit_id', 'id');
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
