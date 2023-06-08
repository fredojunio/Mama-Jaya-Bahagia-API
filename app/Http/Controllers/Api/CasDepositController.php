<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CasDepositResource;
use App\Http\Resources\CasResource;
use App\Models\CasDeposit;
use Illuminate\Http\Request;

class CasDepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deposit = CasDeposit::first();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => CasDepositResource::make($deposit)
        ];
        return $return;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $deposit = CasDeposit::first();
        $deposit->update([
            "koin" => $deposit["koin"] + $request["koin"],
            "seribu" => $deposit["seribu"] + $request["seribu"],
            "duaribu" => $deposit["duaribu"] + $request["duaribu"],
            "limaribu" => $deposit["limaribu"] + $request["limaribu"],
            "sepuluhribu" => $deposit["sepuluhribu"] + $request["sepuluhribu"],
            "duapuluhribu" => $deposit["duapuluhribu"] + $request["duapuluhribu"],
        ]);
        $new_deposit = CasDeposit::create([
            "koin" => $request["koin"],
            "seribu" => $request["seribu"],
            "duaribu" => $request["duaribu"],
            "limaribu" => $request["limaribu"],
            "sepuluhribu" => $request["sepuluhribu"],
            "duapuluhribu" => $request["duapuluhribu"],
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => CasDepositResource::make($deposit)
        ];
        return $return;
    }

    /**
     * Display the specified resource.
     */
    public function show(CasDeposit $casDeposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CasDeposit $casDeposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CasDeposit $casDeposit)
    {
        //
    }
}
