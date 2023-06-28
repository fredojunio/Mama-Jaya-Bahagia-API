<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripLeanResource extends JsonResource
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
            "allowance" => $this->allowance,
            "toll" => $this->toll,
            "toll_used" => $this->toll_used,
            "gas" => $this->gas,
            "note" => $this->note,
            "finance_approved" => $this->finance_approved,
        ];
    }
}
