<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        "amount",
        "note",
        "name",
        "time",
        "type",
        "trip_id",
        "saving_id"
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id', 'id');
    }

    public function savings()
    {
        return $this->belongsTo(Saving::class, 'saving_id', 'id');
    }
}
