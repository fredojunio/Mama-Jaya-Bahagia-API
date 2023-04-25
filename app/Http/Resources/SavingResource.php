<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SavingResource extends JsonResource
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
            "tb" => $this->tb,
            "tw" => $this->tw,
            "thr" => $this->thr,
            "tonnage" => $this->tonnage,
            "total_tw" => $this->total_tw,
            "total_tb" => $this->total_tb,
            "total_thr" => $this->total_thr,
            "total_tonnage" => $this->total_tonnage,
            "type" => $this->type,
            "customer" => $this->customer,
            "transaction" => $this->transaction,
        ];
    }
}
