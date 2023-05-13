<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportRitResource extends JsonResource
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
            "tonnage_left" => $this->tonnage_left,
            "tonnage_sold" => $this->tonnage_sold,
            "total_tonnage_sold" => $this->total_tonnage_sold,
            "rit" => RitResource::make($this->rit),
            "report_id" => $this->report_id
        ];
    }
}
