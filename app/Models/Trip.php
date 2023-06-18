<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $fillable = [
        "allowance",
        "toll",
        "gas",
        "note",
        "toll_used",
        "branch_to_main_tonnage",
        "finance_approved",
        "vehicle_id",
        "plate_number"
    ];
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
    public function branches()
    {
        return $this->hasMany(RitBranch::class, 'trip_id', 'id');
    }
    public function expense()
    {
        return $this->hasOne(Expense::class, 'trip_id', 'id');
    }
}
