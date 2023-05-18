<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'trip_count' => $this->trip_count,
            'trips' => $this->trips,
            'toll' => $this->toll
        ];
    }
}
