<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportRitResource;
use App\Http\Resources\SuccessResource;
use App\Models\ReportRit;
use Illuminate\Http\Request;

class ReportRitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $report_rits = ReportRit::all();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ReportRitResource::collection($report_rits)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $report_rit = ReportRit::create([
            "tonnage_left" => $request->tonnage_left,
            "tonnage_sold" => $request->tonnage_sold,
            "total_tonnage_sold" => $request->total_tonnage_sold,
            "rit" => $request->rit,
            "report_id" => $request->report_id
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ReportRitResource::make($report_rit)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(ReportRit $report_rit)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ReportRitResource::make($report_rit)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReportRit $report_rit)
    {
        $report_rit->update([
            "tonnage_left" => $request->tonnage_left,
            "tonnage_sold" => $request->tonnage_sold,
            "total_tonnage_sold" => $request->total_tonnage_sold,
            "rit" => $request->rit,
            "report_id" => $request->report_id
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ReportRitResource::make($report_rit)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReportRit $report_rit)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses Terhapus.',
            'api_results' => ReportRitResource::make($report_rit)
        ];
        $report_rit->delete();
        return SuccessResource::make($return);
    }
}
