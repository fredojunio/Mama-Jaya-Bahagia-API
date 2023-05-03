<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::collection($transactions)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $transaction = Transaction::create([
            "daily_id" => $request->daily_id,
            "tb" => $request->tb,
            "tw" => $request->tw,
            "thr" => $request->thr,
            "sack" => $request->sack,
            "sack_price" => $request->sack_price,
            "item_price" => $request->item_price,
            "discount" => $request->discount,
            "ongkir" => $request->ongkir,
            "total_price" => $request->total_price,
            "settled_date" => $request->settled_date,
            "owner_approved" => $request->owner_approved,
            "finance_approved" => $request->finance_approved,
            "customer_id" => $request->customer_id,
            "trip_id" => $request->trip_id,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::make($transaction)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::make($transaction)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $transaction->update([
            "daily_id" => $request->daily_id,
            "tb" => $request->tb,
            "tw" => $request->tw,
            "thr" => $request->thr,
            "sack" => $request->sack,
            "sack_price" => $request->sack_price,
            "item_price" => $request->item_price,
            "discount" => $request->discount,
            "ongkir" => $request->ongkir,
            "total_price" => $request->total_price,
            "settled_date" => $request->settled_date,
            "owner_approved" => $request->owner_approved,
            "finance_approved" => $request->finance_approved,
            "customer_id" => $request->customer_id,
            "trip_id" => $request->trip_id,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::make($transaction)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses Terhapus.',
            'api_results' => TransactionResource::make($transaction)
        ];
        $transaction->delete();
        return SuccessResource::make($return);
    }

    public function approve_finance(Transaction $transaction)
    {
        $transaction->update([
            "finance_approved" => 1,
            "settled_date" => Carbon::now(),
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::make($transaction)
        ];
        return SuccessResource::make($return);
    }
}
