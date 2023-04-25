<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RitBranchResource;
use App\Http\Resources\SuccessResource;
use App\Models\RitBranch;
use Illuminate\Http\Request;

class RitBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rit_branchs = RitBranch::all();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitBranchResource::collection($rit_branchs)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rit_branch = RitBranch::create([
            "name" => $request->name,
            "sent_tonnage" => $request->sent_tonnage,
            "income" => $request->income,
            "delivery_date" => $request->delivery_date,
            "rit" => $request->rit,
            "trip" => $request->trip,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitBranchResource::make($rit_branch)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(RitBranch $rit_branch)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitBranchResource::make($rit_branch)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RitBranch $rit_branch)
    {
        $rit_branch->update([
            "name" => $request->name,
            "sent_tonnage" => $request->sent_tonnage,
            "income" => $request->income,
            "delivery_date" => $request->delivery_date,
            "rit" => $request->rit,
            "trip" => $request->trip,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitBranchResource::make($rit_branch)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RitBranch $rit_branch)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses Terhapus.',
            'api_results' => RitBranchResource::make($rit_branch)
        ];
        $rit_branch->delete();
        return SuccessResource::make($return);
    }
}
