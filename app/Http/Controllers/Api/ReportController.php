<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Http\Resources\SuccessResource;
use App\Models\Expense;
use App\Models\Report;
use App\Models\ReportRit;
use App\Models\Rit;
use App\Models\RitTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
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

    public function create_daily_report()
    {
        $income = Transaction::where('finance_approved', 1)
            ->whereDate('settled_date', Carbon::today())
            ->sum('total_price');
        $allincome = Transaction::whereDate('settled_date', Carbon::today())
            ->sum('total_price');
        $unpaidIncome = Transaction::where('finance_approved', 0)
            ->where('owner_approved', 1)
            ->sum('total_price');
        $expense = Expense::whereDate('time', Carbon::today())->sum('amount');
        $tonnage = Transaction::whereDate('created_at', Carbon::today())
            ->with('rits')
            ->get()
            ->pluck('rits')
            ->flatten()
            ->sum('tonnage');
        $item_income = Transaction::where('finance_approved', 1)
            ->whereDate('settled_date', Carbon::today())
            ->sum('item_price');
        $tb_income = Transaction::where('finance_approved', 1)
            ->whereDate('settled_date', Carbon::today())
            ->sum('tb');
        $tw_income = Transaction::where('finance_approved', 1)
            ->whereDate('settled_date', Carbon::today())
            ->sum('tw');
        $thr_income = Transaction::where('finance_approved', 1)
            ->whereDate('settled_date', Carbon::today())
            ->sum('thr');
        $tb_expense = Expense::whereDate('time', Carbon::today())
            ->where('type', "TB")
            ->sum('amount');
        $tw_expense = Expense::whereDate('time', Carbon::today())
            ->where('type', "TW")
            ->sum('amount');
        $thr_expense = Expense::whereDate('time', Carbon::today())
            ->where('type', "THR")
            ->sum('amount');
        $salary_expense = Expense::whereDate('time', Carbon::today())
            ->where('type', "Gaji")
            ->sum('amount');
        $operational_expense = Expense::whereDate('time', Carbon::today())
            ->where('type', "Operasional")
            ->sum('amount');
        $report = Report::create([
            "money" => $income - $expense,
            "income" => $allincome,
            "expense" => $expense,
            "tonnage" => $tonnage,
            "item_income" => $item_income,
            "tb_income" => $tb_income,
            "tw_income" => $tw_income,
            "thr_income" => $thr_income,
            "tb_expense" => $tb_expense,
            "tw_expense" => $tw_expense,
            "thr_expense" => $thr_expense,
            "salary_expense" => $salary_expense,
            "operational_expense" => $operational_expense,
        ]);
        $rits = Rit::where("tonnage_left", ">", 0)->orWhere("sold_date", Carbon::today())->get();
        foreach ($rits as $key => $rit) {
            $tonnage_sold = RitTransaction::where('rit_id', $rit->id)
                ->whereDate('created_at', Carbon::today())
                ->sum('tonnage');
            $total_tonnage_sold = RitTransaction::where('rit_id', $rit->id)
                ->sum('tonnage');
            $report_rit = ReportRit::create([
                "tonnage_left" => $rit->tonnage_left,
                "tonnage_sold" => $tonnage_sold,
                "total_tonnage_sold" => $total_tonnage_sold,
                "rit_id" => $rit->id,
                "report_id" => $report->id
            ]);
        }
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ReportResource::make($report)
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
