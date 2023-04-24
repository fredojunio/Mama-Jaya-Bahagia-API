<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RitBranch extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "sent_tonnage",
        "income",
        "delivery_date",
        "rit_id",
        "trip_id",
    ];
    public function rit()
    {
        return $this->belongsTo(Rit::class, 'rit_id', 'id');
    }
    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id', 'id');
    }
}
