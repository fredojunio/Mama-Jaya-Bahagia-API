<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        "amount",
        "transaction_date",
        "settled_date",
        "transaction_id",
        "report_id"
    ];
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id', 'id');
    }
}
