<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'nik' => $this->nik,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'address' => $this->address,
            'phone' => $this->phone,
            'ongkir' => $this->ongkir,
            'birthdate' => $this->birthdate,
            "tb" => $this->tb,
            "tw" => $this->tw,
            "thr" => $this->thr,
            "tonnage" => $this->tonnage,
            "cashback_approved" => $this->cashback_approved,
            'type' => $this->type,
            'savings' => $this->savings,
            'transactions' => TransactionResource::collection($this->transactions),
        ];
    }
}
