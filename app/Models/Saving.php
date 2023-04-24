<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasFactory;
    protected $fillable = [
        "tb",
        "tw",
        "thr",
        "tonnage",
        "total_tw",
        "total_tb",
        "total_thr",
        "total_tonnage",
        "type",
        "customer_id",
        "transaction_id",
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
