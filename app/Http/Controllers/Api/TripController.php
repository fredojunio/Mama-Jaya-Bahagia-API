<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips = Trip::all();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TripResource::collection($trips)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $trip = Trip::create([
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
            'api_results' => TripResource::make($trip)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TripResource::make($trip)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trip $trip)
    {
        $trip->update([
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
            'api_results' => TripResource::make($trip)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses Terhapus.',
            'api_results' => TripResource::make($trip)
        ];
        $trip->delete();
        return SuccessResource::make($return);
    }
}
