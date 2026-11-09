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
            "coa_id" => $this->coa_id,
            "coa" => $this->coa ? [
                "id" => $this->coa->id,
                "code" => $this->coa->code,
                "name" => $this->coa->name,
            ] : null,
            "trip" => $this->trip_id ? TripResource::make($this->trip) : null,
        ];
    }
}
