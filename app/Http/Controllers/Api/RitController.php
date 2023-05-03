<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RitResource;
use App\Http\Resources\SuccessResource;
use App\Models\Rit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rits = Rit::all();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::collection($rits)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rit = Rit::create([
            "expected_tonnage" => $request->expected_tonnage,
            "customer_tonnage" => $request->customer_tonnage,
            "branch_tonnage" => $request->branch_tonnage,
            "main_tonnage" => $request->main_tonnage,
            "retur_tonnage" => $request->retur_tonnage,
            "arrived_tonnage" => $request->arrived_tonnage,
            "tonnage_left" => $request->tonnage_left,
            "delivery_date" => $request->delivery_date,
            "arrival_date" => $request->arrival_date,
            "sold_date" => $request->sold_date,
            "sell_price" => $request->sell_price,
            "buy_price" => $request->buy_price,
            "sack" => $request->sack,
            "finance_approved" => $request->finance_approved,
            "is_hold" => $request->is_hold,
            "item_id" => $request->item_id,
            "trip_id" => $request->trip_id,
            "retur_trip_id" => $request->retur_trip_id,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::make($rit)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rit $rit)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::make($rit)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rit $rit)
    {
        $rit->update([
            "expected_tonnage" => $request->expected_tonnage,
            "customer_tonnage" => $request->customer_tonnage,
            "branch_tonnage" => $request->branch_tonnage,
            "main_tonnage" => $request->main_tonnage,
            "retur_tonnage" => $request->retur_tonnage,
            "arrived_tonnage" => $request->arrived_tonnage,
            "tonnage_left" => $request->tonnage_left,
            "delivery_date" => $request->delivery_date,
            "arrival_date" => $request->arrival_date,
            "sold_date" => $request->sold_date,
            "sell_price" => $request->sell_price,
            "buy_price" => $request->buy_price,
            "sack" => $request->sack,
            "finance_approved" => $request->finance_approved,
            "is_hold" => $request->is_hold,
            "item_id" => $request->item_id,
            "trip_id" => $request->trip_id,
            "retur_trip_id" => $request->retur_trip_id,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::make($rit)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rit $rit)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses Terhapus.',
            'api_results' => RitResource::make($rit)
        ];
        $rit->delete();
        return SuccessResource::make($return);
    }

    public function approve_finance(Rit $rit)
    {
        $rit->update([
            'finance_approved' => 1,
            'delivery_date' => Carbon::now()
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::make($rit)
        ];
        return SuccessResource::make($return);
    }
}
