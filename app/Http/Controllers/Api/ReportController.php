<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Http\Resources\SuccessResource;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::all();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ReportResource::collection($reports)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $report = Report::create([
            "money" => $request->money,
            "income" => $request->income,
            "expense" => $request->expense,
            "tonnage" => $request->tonnage,
            "item_income" => $request->item_income,
            "tb_income" => $request->tb_income,
            "tw_income" => $request->tw_income,
            "thr_income" => $request->thr_income,
            "tb_expense" => $request->tb_expense,
            "tw_expense" => $request->tw_expense,
            "thr_expense" => $request->thr_expense,
            "salary_expense" => $request->salary_expense,
            "operational_expense" => $request->operational_expense,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ReportResource::make($report)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ReportResource::make($report)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        $report->update([
            "money" => $request->money,
            "income" => $request->income,
            "expense" => $request->expense,
            "tonnage" => $request->tonnage,
            "item_income" => $request->item_income,
            "tb_income" => $request->tb_income,
            "tw_income" => $request->tw_income,
            "thr_income" => $request->thr_income,
            "tb_expense" => $request->tb_expense,
            "tw_expense" => $request->tw_expense,
            "thr_expense" => $request->thr_expense,
            "salary_expense" => $request->salary_expense,
            "operational_expense" => $request->operational_expense,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ReportResource::make($report)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses Terhapus.',
            'api_results' => ReportResource::make($report)
        ];
        $report->delete();
        return SuccessResource::make($return);
    }
}
