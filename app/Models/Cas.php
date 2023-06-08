<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cas extends Model
{
    use HasFactory;
    protected $fillable = [
        "koin",
        "seribu",
        "duaribu",
        "limaribu",
        "sepuluhribu",
        "duapuluhribu",
        "fee",
        "total"
    ];
}
