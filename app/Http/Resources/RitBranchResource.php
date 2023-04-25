<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RitBranchResource extends JsonResource
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
            "name" => $this->name,
            "sent_tonnage" => $this->sent_tonnage,
            "income" => $this->income,
            "delivery_date" => $this->delivery_date,
            "rit" => $this->rit,
            "trip" => $this->trip,
        ];
    }
}
