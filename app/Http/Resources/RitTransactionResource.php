<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RitTransactionResource extends JsonResource
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
            "tonnage" => $this->tonnage,
            "masak" => $this->masak,
            "item_price" => $this->item_price,
            "total_price" => $this->total_price,
            "tonnage_left" => $this->tonnage_left,
            "rit" => RitResource::make($this->rit),
            "transaction" => $this->transaction,
        ];
    }
}
