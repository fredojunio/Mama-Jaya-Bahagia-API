<?php

namespace App\Http\Resources;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
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
            "note" => $this->note,
            "name" => $this->name,
            "time" => $this->time,
            "type" => $this->type,
            "trip" => $this->trip_id ? TripResource::make($this->trip) : null,
        ];
    }
}
