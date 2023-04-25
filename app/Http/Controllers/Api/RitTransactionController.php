<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RitTransactionResource;
use App\Http\Resources\SuccessResource;
use App\Models\RitTransaction;
use Illuminate\Http\Request;

class RitTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rit_transactions = RitTransaction::all();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitTransactionResource::collection($rit_transactions)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rit_transaction = RitTransaction::create([
            "allowance" => $request->allowance,
            "toll" => $request->toll,
            "gas" => $request->gas,
            "note" => $request->note,
            "toll_used" => $request->toll_used,
            "branch_to_main_tonnage" => $request->branch_to_main_tonnage,
            "vehicle_id" => $request->vehicle_id,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitTransactionResource::make($rit_transaction)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(RitTransaction $rit_transaction)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitTransactionResource::make($rit_transaction)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RitTransaction $rit_transaction)
    {
        $rit_transaction->update([
            "tonnage" => $request->tonnage,
            "masak" => $request->masak,
            "item_price" => $request->item_price,
            "total_price" => $request->total_price,
            "tonnage_left" => $request->tonnage_left,
            "rit_id" => $request->rit_id,
            "transaction_id" => $request->transaction_id,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitTransactionResource::make($rit_transaction)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RitTransaction $rit_transaction)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses Terhapus.',
            'api_results' => RitTransactionResource::make($rit_transaction)
        ];
        $rit_transaction->delete();
        return SuccessResource::make($return);
    }
}
