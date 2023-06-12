<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Http\Resources\SuccessResource;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Item;
use App\Models\Report;
use App\Models\ReportRit;
use App\Models\ReportTransaction;
use App\Models\Rit;
use App\Models\RitTransaction;
use App\Models\Saving;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $tb_savings = Saving::whereNull('transaction_id')
            ->whereDate('created_at', Carbon::today())
            ->sum('tb');
        $tw_income = Transaction::where('finance_approved', 1)
            ->whereDate('settled_date', Carbon::today())
            ->sum('tw');
        $tw_savings = Saving::whereNull('transaction_id')
            ->whereDate('created_at', Carbon::today())
            ->sum('tw');
        $thr_income = Transaction::where('finance_approved', 1)
            ->whereDate('settled_date', Carbon::today())
            ->sum('thr');
        $thr_savings = Saving::whereNull('transaction_id')
            ->whereDate('created_at', Carbon::today())
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
        $vehicle_expense = Expense::whereDate('created_at', Carbon::today())
            ->where('type', "Kendaraan")
            ->sum('amount');
        $report = Report::create([
            "money" => $income - $expense,
            "income" => $allincome,
            "expense" => $expense,
            "tonnage" => $tonnage,
            "item_income" => $item_income,
            "tb_income" => $tb_income + $tb_savings,
            "tw_income" => $tw_income + $tw_savings,
            "thr_income" => $thr_income + $thr_savings,
            "tb_expense" => $tb_expense,
            "tw_expense" => $tw_expense,
            "thr_expense" => $thr_expense,
            "salary_expense" => $salary_expense,
            "operational_expense" => $operational_expense + $vehicle_expense,
        ]);
        $rits = Rit::where("tonnage_left", ">", 0)->orWhere("sold_date", Carbon::today())->get();
        foreach ($rits as $key => $rit) {
            $todayTransactions = DB::table('transactions')
                ->whereDate('transactions.created_at', Carbon::today())
                ->join('rit_transactions', 'transactions.id', '=', 'rit_transactions.transaction_id')
                ->where('rit_transactions.rit_id', $rit->id)
                ->select(DB::raw('SUM(rit_transactions.tonnage * rit_transactions.masak) AS total_tonnage_times_masak'))
                ->first();
            $totalTonnageTimesMasakToday = $todayTransactions->total_tonnage_times_masak;
            $transactions = DB::table('transactions')
                ->join('rit_transactions', 'transactions.id', '=', 'rit_transactions.transaction_id')
                ->where('rit_transactions.rit_id', $rit->id)
                ->select(DB::raw('SUM(rit_transactions.tonnage * rit_transactions.masak) AS total_tonnage_times_masak'))
                ->first();
            $totalTonnageTimesMasak = $transactions->total_tonnage_times_masak;


            $report_rit = ReportRit::create([
                "tonnage_left" => $rit->tonnage_left,
                "tonnage_sold" => $totalTonnageTimesMasakToday,
                "total_tonnage_sold" => $totalTonnageTimesMasak,
                "rit_id" => $rit->id,
                "report_id" => $report->id
            ]);
        }
        $transactions = Transaction::whereNull("settled_date")
            ->where(function ($query) {
                $query->where('owner_approved', '<>', 2)->where('owner_approved', '<>', 3)
                    ->orWhereNull('owner_approved');
            })
            ->where(function ($query) {
                $query->whereNotNull('total_price');
            })
            ->get();
        foreach ($transactions as $key => $transaction) {
            ReportTransaction::create([
                "amount" => $transaction->total_price,
                "transaction_date" => $transaction->created_at,
                "settled_date" => $transaction->settled_date,
                "transaction_id" => $transaction->id,
                "report_id" => $report->id,
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
    public function get_today_report()
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
        $tb_savings = Saving::whereNull('transaction_id')
            ->whereDate('created_at', Carbon::today())
            ->sum('tb');
        $tw_income = Transaction::where('finance_approved', 1)
            ->whereDate('settled_date', Carbon::today())
            ->sum('tw');
        $tw_savings = Saving::whereNull('transaction_id')
            ->whereDate('created_at', Carbon::today())
            ->sum('tw');
        $thr_income = Transaction::where('finance_approved', 1)
            ->whereDate('settled_date', Carbon::today())
            ->sum('thr');
        $thr_savings = Saving::whereNull('transaction_id')
            ->whereDate('created_at', Carbon::today())
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
        $vehicle_expense = Expense::whereDate('created_at', Carbon::today())
            ->where('type', "Kendaraan")
            ->sum('amount');
        $report = new Report;
        $report->money = $income - $expense;
        $report->income = $allincome;
        $report->expense = $expense;
        $report->tonnage = $tonnage;
        $report->item_income = $item_income;
        $report->tb_income = $tb_income + $tb_savings;
        $report->tw_income = $tw_income + $tw_savings;
        $report->thr_income = $thr_income + $thr_savings;
        $report->tb_expense = $tb_expense;
        $report->tw_expense = $tw_expense;
        $report->thr_expense = $thr_expense;
        $report->salary_expense = $salary_expense;
        $report->operational_expense = $operational_expense + $vehicle_expense;

        $rits = Rit::where("tonnage_left", ">", 0)->orWhere("sold_date", Carbon::today())->get();
        $report_rits = [];
        foreach ($rits as $key => $rit) {
            $todayTransactions = DB::table('transactions')
                ->whereDate('transactions.created_at', Carbon::today())
                ->join('rit_transactions', 'transactions.id', '=', 'rit_transactions.transaction_id')
                ->where('rit_transactions.rit_id', $rit->id)
                ->select(DB::raw('SUM(rit_transactions.tonnage * rit_transactions.masak) AS total_tonnage_times_masak'))
                ->first();
            $totalTonnageTimesMasakToday = $todayTransactions->total_tonnage_times_masak;
            $transactions = DB::table('transactions')
                ->join('rit_transactions', 'transactions.id', '=', 'rit_transactions.transaction_id')
                ->where('rit_transactions.rit_id', $rit->id)
                ->select(DB::raw('SUM(rit_transactions.tonnage * rit_transactions.masak) AS total_tonnage_times_masak'))
                ->first();
            $totalTonnageTimesMasak = $transactions->total_tonnage_times_masak;

            $item = Item::find($rit->item_id);

            $report_rit = new ReportRit;
            $report_rit->tonnage_left = $rit->tonnage_left;
            $report_rit->tonnage_sold = $totalTonnageTimesMasakToday;
            $report_rit->total_tonnage_sold = $totalTonnageTimesMasak;
            $report_rit->rit_id = $rit->id;
            $report_rit->report_id = $report->id;
            $report_rit->report()->associate($report);
            $report_rit->rit()->associate($rit->item()->associate($item));
            $report->rits()->save($report_rit);
            $report_rits[] = $report_rit;
        }
        $transactions = Transaction::whereNull("settled_date")
            ->where(function ($query) {
                $query->where('owner_approved', '<>', 2)->where('owner_approved', '<>', 3)
                    ->orWhereNull('owner_approved');
            })
            ->where(function ($query) {
                $query->whereNotNull('total_price');
            })
            ->get();
        $report_transactions = [];
        foreach ($transactions as $key => $transaction) {
            $customer = Customer::find($transaction->customer_id);
            $report_transaction = new ReportTransaction;
            $report_transaction->amount = $transaction->total_price;
            $report_transaction->transaction_date = $transaction->created_at;
            $report_transaction->settled_date = $transaction->settled_date;
            $report_transaction->transaction_id = $transaction->id;
            $report_transaction->report_id = $report->id;
            $report_transaction->report()->associate($report);
            $report_transaction->transaction()->associate($transaction->customer()->associate($customer));
            $report->transactions()->save($report_transaction);
            $report_transactions[] = $report_transaction;
        }
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => [ReportResource::make($report), $report_rits, $report_transactions]
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
