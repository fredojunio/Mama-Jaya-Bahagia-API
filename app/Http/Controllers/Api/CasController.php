<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CasResource;
use App\Http\Resources\SuccessResource;
use App\Models\Cas;
use App\Models\CasDeposit;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function get_cas(Request $request)
    {
        $cases = Cas::where("created_at", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
            ->where("created_at", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
            ->get();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => CasResource::collection($cases)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cas = Cas::create([
            "koin" => $request->koin,
            "seribu" => $request->seribu,
            "duaribu" => $request->duaribu,
            "limaribu" => $request->limaribu,
            "sepuluhribu" => $request->sepuluhribu,
            "duapuluhribu" => $request->duapuluhribu,
            "fee" => $request->fee,
            "total" => $request->total + $request->fee,
        ]);
        $deposit = CasDeposit::first();
        $deposit->update([
            "koin" => $deposit["koin"] - $request["koin"],
            "seribu" => $deposit["seribu"] - $request["seribu"],
            "duaribu" => $deposit["duaribu"] - $request["duaribu"],
            "limaribu" => $deposit["limaribu"] - $request["limaribu"],
            "sepuluhribu" => $deposit["sepuluhribu"] - $request["sepuluhribu"],
            "duapuluhribu" => $deposit["duapuluhribu"] - $request["duapuluhribu"],
        ]);
        $transaction = Transaction::create([
            "daily_id" => Transaction::whereDate('created_at', now()->toDateString())->get()->count() + 1,
            "total_price" => $request->total + $request->fee,
            "owner_approved" => 1,
            "type" => "Cas",
            "cas_id" => $cas->id
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => CasResource::make($cas)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cas $cas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cas $cas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cas $cas)
    {
        //
    }
}
