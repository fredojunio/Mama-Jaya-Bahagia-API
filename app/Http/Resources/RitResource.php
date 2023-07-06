<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RitResource extends JsonResource
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
            "do_code" => $this->do_code,
            "expected_tonnage" => $this->expected_tonnage,
            "customer_tonnage" => $this->customer_tonnage,
            "branch_tonnage" => $this->branch_tonnage,
            "main_tonnage" => $this->main_tonnage,
            "retur_tonnage" => $this->retur_tonnage,
            "arrived_tonnage" => $this->arrived_tonnage,
            "tonnage_left" => $this->tonnage_left,
            "delivery_date" => $this->delivery_date,
            "arrival_date" => $this->arrival_date,
            "sold_date" => $this->sold_date,
            "sell_price" => $this->sell_price,
            "buy_price" => $this->buy_price,
            "sack" => $this->sack,
            "finance_approved" => $this->finance_approved,
            "is_hold" => $this->is_hold,
            "item" => $this->item,
            "trip" => TripResource::make($this->trip),
            "retur_trip" => $this->retur_trip,
            "customer" => $this->customer,
            "branches" => RitBranchResource::collection($this->branches),
            "transactions" => RitTransactionResourceVerOne::collection($this->transactions),
            "histories" => $this->histories,
            "customer_transaction" => $this->customer_transaction,
            "created_at" => $this->created_at,
        ];
    }
}
