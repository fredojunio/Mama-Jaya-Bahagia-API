<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rit extends Model
{
    use HasFactory;
    protected $fillable = [
        "expected_tonnage",
        "customer_tonnage",
        "branch_tonnage",
        "main_tonnage",
        "retur_tonnage",
        "arrived_tonnage",
        "tonnage_left",
        "delivery_date",
        "arrival_date",
        "sold_date",
        "sell_price",
        "buy_price",
        "sack",
        "finance_approved",
        "customer_tonnage_sold",
        "is_hold",
        "item_id",
        "trip_id",
        "retur_trip_id",
    ];
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id', 'id');
    }
    public function retur_trip()
    {
        return $this->belongsTo(Trip::class, 'retur_trip_id', 'id');
    }
    public function branches()
    {
        return $this->hasMany(RitBranch::class, 'rit_id', 'id');
    }
    public function transactions()
    {
        return $this->hasMany(RitTransaction::class, 'rit_id', 'id');
    }
}
