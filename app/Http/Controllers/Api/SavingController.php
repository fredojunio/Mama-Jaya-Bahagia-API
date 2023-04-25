<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SavingResource;
use App\Http\Resources\SuccessResource;
use App\Models\Saving;
use Illuminate\Http\Request;

class SavingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $savings = Saving::all();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => SavingResource::collection($savings)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saving = Saving::create([
            "tb" => $request->tb,
            "tw" => $request->tw,
            "thr" => $request->thr,
            "tonnage" => $request->tonnage,
            "total_tw" => $request->total_tw,
            "total_tb" => $request->total_tb,
            "total_thr" => $request->total_thr,
            "total_tonnage" => $request->total_tonnage,
            "type" => $request->type,
            "customer_id" => $request->customer_id,
            "transaction_id" => $request->transaction_id,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => SavingResource::make($saving)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(Saving $saving)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => SavingResource::make($saving)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Saving $saving)
    {
        $saving->update([
            "tb" => $request->tb,
            "tw" => $request->tw,
            "thr" => $request->thr,
            "tonnage" => $request->tonnage,
            "total_tw" => $request->total_tw,
            "total_tb" => $request->total_tb,
            "total_thr" => $request->total_thr,
            "total_tonnage" => $request->total_tonnage,
            "type" => $request->type,
            "customer_id" => $request->customer_id,
            "transaction_id" => $request->transaction_id,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => SavingResource::make($saving)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Saving $saving)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses Terhapus.',
            'api_results' => SavingResource::make($saving)
        ];
        $saving->delete();
        return SuccessResource::make($return);
    }
}
