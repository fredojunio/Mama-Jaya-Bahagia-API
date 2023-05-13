<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'nik',
        'name',
        'nickname',
        'address',
        'phone',
        'ongkir',
        'birthdate',
        'type',
        "tb",
        "tw",
        "thr",
        "tonnage",
        "cashback_approved",
    ];
    public function savings()
    {
        return $this->hasMany(Saving::class, 'customer_id', 'id');
    }
    public function cashbacks()
    {
        return $this->hasMany(Cashback::class, 'customer_id', 'id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'customer_id', 'id');
    }
}
