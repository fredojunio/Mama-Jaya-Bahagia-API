<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportTransactionResource extends JsonResource
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
            "amount" => $this->amount,
            "transaction_date" => $this->transaction_date,
            "settled_date" => $this->settled_date,
            "transaction" => TransactionResource::make($this->transaction),
            "report_id" => $this->report_id
        ];
    }
}
