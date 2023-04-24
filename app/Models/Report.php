<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        "money",
        "income",
        "expense",
        "tonnage",
        "item_income",
        "tb_income",
        "tw_income",
        "thr_income",
        "tb_expense",
        "tw_expense",
        "thr_expense",
        "salary_expense",
        "operational_expense",
    ];
    public function rits()
    {
        return $this->hasMany(ReportRit::class, 'report_id', 'id');
    }
}
