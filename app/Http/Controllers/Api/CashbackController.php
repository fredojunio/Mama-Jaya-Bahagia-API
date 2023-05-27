<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CashbackResource;
use App\Http\Resources\SuccessResource;
use App\Models\Cashback;
use App\Models\Customer;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CashbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cashbacks = Cashback::whereNull("approval_date")
            ->get();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => CashbackResource::collection($cashbacks),
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cashback $cashback)
    {
        $cashback->update([
            "approval_date" => Carbon::now()
        ]);

        $customer = Customer::find($cashback->customer_id);

        $expense = Expense::create([
            "amount" => $cashback->amount,
            "note" => "Cashback " . $customer->name,
            "name" => $customer->name,
            "time" => Carbon::now(),
            "type" => "Cashback",
        ]);

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => CashbackResource::make($cashback)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cashback $cashback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cashback $cashback)
    {
        //
    }
}
