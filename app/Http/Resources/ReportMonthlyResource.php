<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportMonthlyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "created_at" => $this->created_at,
            "money" => $this->money,
            "income" => $this->income,
            "expense" => $this->expense,
            "tonnage" => $this->tonnage,
            "item_income" => $this->item_income,
            "tb_income" => $this->tb_income,
            "tw_income" => $this->tw_income,
            "thr_income" => $this->thr_income,
            "other_income" => $this->other_income,
            "tb_expense" => $this->tb_expense,
            "tw_expense" => $this->tw_expense,
            "thr_expense" => $this->thr_expense,
            "salary_expense" => $this->salary_expense,
            "operational_expense" => $this->operational_expense,
            // "rits" => ReportRitResource::collection($this->rits),
            // "transactions" => ReportTransactionResource::collection($this->transactions)
        ];
    }
}
