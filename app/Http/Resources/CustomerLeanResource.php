<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerLeanResource extends JsonResource
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
            'cashback_days' => $this->cashback_days,
            'type' => $this->type,
        ];
    }

    private function getUniqueDays($transactions)
    {
        $transactionsArray = $transactions->toArray();

        $uniqueDays = array_reduce($transactionsArray, function ($acc, $transaction) {
            $date = explode(" ", $transaction['created_at'])[0]; // get the date part only
            if (!isset($acc[$date])) {
                $acc[$date] = true; // add the date to the array if it doesn't exist yet
            }
            return $acc;
        }, []);

        return count(array_keys($uniqueDays)); // get the number of unique dates
    }
}
