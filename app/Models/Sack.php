<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sack extends Model
{
    use HasFactory;
    protected $fillable = [
        "amount",
        "rit_id"
    ];
    public function rit()
    {
        return $this->belongsTo(Rit::class, 'rit_id', 'id');
    }
}
