<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportRit extends Model
{
    use HasFactory;
    protected $fillable = [
        "tonnage_left",
        "tonnage_sold",
        "tonnage_sold_price",
        "real_tonnage",
        "total_tonnage_sold",
        "rit_id",
        "report_id"
    ];
    public function rit()
    {
        return $this->belongsTo(Rit::class, 'rit_id', 'id');
    }
    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id', 'id');
    }
}
