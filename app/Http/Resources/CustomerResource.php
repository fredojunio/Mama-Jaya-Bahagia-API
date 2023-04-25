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
            'ongkir' => $this->ongkir,
            'birthdate' => $this->birthdate,
            'type' => $this->type,
            'savings' => $this->savings,
            'transactions' => TransactionResource::collection($this->transactions),
        ];
    }
}