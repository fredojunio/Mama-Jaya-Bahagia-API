<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportLeanResource;
use App\Http\Resources\ReportResource;
use App\Http\Resources\SuccessResource;
use App\Models\Cas;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Item;
use App\Models\Payment;
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
            'api_results' => ReportLeanResource::collection($reports)
        ];
        return SuccessResource::make($return);
    }

    public function check_daily_report()
    {
        $report = Report::whereDate('created_at', Carbon::today())
            ->first();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ReportLeanResource::make($report)
        ];
        return SuccessResource::make($return);
    }

    public function create_daily_report(Request $request)
    {
        $old_report = Report::whereDate('created_at', Carbon::today())
            ->first();
        if ($old_report) {
            $old_report->delete();
        }
        $income = Payment::whereDate('created_at', Carbon::today())
            ->where('type', 'Cash')
            ->sum('amount');
        $allincome = Transaction::whereDate('created_at', Carbon::today())
            ->whereNotIn('type', ['Owner', 'Cabang'])
            ->sum('total_price');
        $expense = Expense::whereDate('time', Carbon::today())->sum('amount');
        $tonnage = Transaction::whereDate('created_at', Carbon::today())
            ->whereNotIn('type', ['Owner', 'Cabang'])
            ->with('rits')
            ->get()
            ->pluck('rits')
            ->flatten()
            ->sum('tonnage');
        $item_income = Transaction::where('owner_approved', 1)
            ->whereDate('created_at', Carbon::today())
            ->whereNotIn('type', ['Owner', 'Cabang'])
            ->sum('item_price');
        $tb_income = Transaction::where('owner_approved', 1)
            ->whereDate('created_at', Carbon::today())
            ->sum('tb');
        $tb_savings = Saving::whereNull('transaction_id')
            ->whereDate('created_at', Carbon::today())
            ->sum('tb');
        $tw_income = Transaction::where('owner_approved', 1)
            ->whereDate('created_at', Carbon::today())
            ->sum('tw');
        $tw_savings = Saving::whereNull('transaction_id')
            ->whereDate('created_at', Carbon::today())
            ->sum('tw');
        $thr_income = Transaction::where('owner_approved', 1)
            ->whereDate('created_at', Carbon::today())
            ->sum('thr');
        $thr_savings = Saving::whereNull('transaction_id')
            ->whereDate('created_at', Carbon::today())
            ->sum('thr');
        $sack_income = Transaction::where('owner_approved', 1)
            ->whereDate('created_at', Carbon::today())
            ->sum('sack_price');
        $cas_income = Cas::whereDate('created_at', Carbon::today())
            ->sum('fee');
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
        $vehicle_expense = Expense::whereDate('time', Carbon::today())
            ->where('type', "Kendaraan")
            ->sum('amount');
        $report = Report::create([
            "money" => $income - $expense,
            "income" => $allincome,
            "real_income" => $request->real_income,
            "expense" => $expense,
            "tonnage" => $tonnage,
            "item_income" => $item_income,
            "tb_income" => $tb_income + $tb_savings,
            "tw_income" => $tw_income + $tw_savings,
            "thr_income" => $thr_income + $thr_savings,
            "other_income" => $sack_income + $cas_income,
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
                ->whereNotIn('transactions.type', ['Owner', 'Cabang'])
                ->join('rit_transactions', 'transactions.id', '=', 'rit_transactions.transaction_id')
                ->where('rit_transactions.rit_id', $rit->id)
                ->select(DB::raw('SUM(rit_transactions.tonnage * rit_transactions.masak) AS total_tonnage_times_masak'))
                ->first();
            $totalTonnageTimesMasakToday = $todayTransactions->total_tonnage_times_masak;
            $totalItemPrice = RitTransaction::where('rit_id', $rit->id)
                ->whereHas('transaction', function ($query) {
                    $query->whereNotIn('type', ['Owner', 'Cabang']);
                })
                ->whereDate('created_at', Carbon::today())
                ->sum('total_price');
            $transactions = DB::table('transactions')
                ->whereNotIn('transactions.type', ['Owner', 'Cabang'])
                ->join('rit_transactions', 'transactions.id', '=', 'rit_transactions.transaction_id')
                ->where('rit_transactions.rit_id', $rit->id)
                ->select(DB::raw('SUM(rit_transactions.tonnage * rit_transactions.masak) AS total_tonnage_times_masak'))
                ->first();
            $totalTonnageTimesMasak = $transactions->total_tonnage_times_masak;

            $report_rit = ReportRit::create([
                "tonnage_left" => $rit->tonnage_left,
                "tonnage_sold" => $totalTonnageTimesMasakToday,
                "tonnage_sold_price" => $totalItemPrice,
                "real_tonnage" => $request->rits[$key]["real_tonnage"],
                "total_tonnage_sold" => $totalTonnageTimesMasak,
                "rit_id" => $rit->id,
                "report_id" => $report->id
            ]);
        }
        $transactions = Transaction::whereNull("settled_date")
            ->where(function ($query) {
                $query
                    ->where('owner_approved', '<>', 2)
                    ->where('owner_approved', '<>', 3)
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
        ReportRit::whereNull('report_id')->delete();
        ReportTransaction::whereNull('report_id')->delete();
        $income = Payment::whereDate('created_at', Carbon::today())
            ->where('type', 'Cash')
            ->sum('amount');
        $allincome = Transaction::whereDate('created_at', Carbon::today())
            ->whereNotIn('type', ['Owner', 'Cabang'])
            ->sum('total_price');
        $expense = Expense::whereDate('time', Carbon::today())->sum('amount');
        $tonnage = Transaction::whereDate('created_at', Carbon::today())
            ->whereNotIn('type', ['Owner', 'Cabang'])
            ->with('rits')
            ->get()
            ->pluck('rits')
            ->flatten()
            ->sum('tonnage');
        $item_income = Transaction::where('owner_approved', 1)
            ->whereDate('created_at', Carbon::today())
            ->whereNotIn('type', ['Owner', 'Cabang'])
            ->sum('item_price');
        $tb_income = Transaction::where('owner_approved', 1)
            ->whereDate('created_at', Carbon::today())
            ->sum('tb');
        $tb_savings = Saving::whereNull('transaction_id')
            ->whereDate('created_at', Carbon::today())
            ->sum('tb');
        $tw_income = Transaction::where('owner_approved', 1)
            ->whereDate('created_at', Carbon::today())
            ->sum('tw');
        $tw_savings = Saving::whereNull('transaction_id')
            ->whereDate('created_at', Carbon::today())
            ->sum('tw');
        $thr_income = Transaction::where('owner_approved', 1)
            ->whereDate('created_at', Carbon::today())
            ->sum('thr');
        $thr_savings = Saving::whereNull('transaction_id')
            ->whereDate('created_at', Carbon::today())
            ->sum('thr');
        $sack_income = Transaction::where('owner_approved', 1)
            ->whereDate('created_at', Carbon::today())
            ->sum('sack_price');
        $cas_income = Cas::whereDate('created_at', Carbon::today())
            ->sum('fee');
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
        $vehicle_expense = Expense::whereDate('time', Carbon::today())
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
        $report->other_income = $sack_income + $cas_income;
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
                ->whereNotIn('transactions.type', ['Owner', 'Cabang'])
                ->join('rit_transactions', 'transactions.id', '=', 'rit_transactions.transaction_id')
                ->where('rit_transactions.rit_id', $rit->id)
                ->select(DB::raw('SUM(rit_transactions.tonnage * rit_transactions.masak) AS total_tonnage_times_masak'))
                ->first();
            $totalTonnageTimesMasakToday = $todayTransactions->total_tonnage_times_masak;
            $totalItemPrice = RitTransaction::where('rit_id', $rit->id)
                ->whereHas('transaction', function ($query) {
                    $query->whereNotIn('type', ['Owner', 'Cabang']);
                })
                ->whereDate('created_at', Carbon::today())
                ->sum('total_price');
            $transactions = DB::table('transactions')
                ->whereNotIn('transactions.type', ['Owner', 'Cabang'])
                ->join('rit_transactions', 'transactions.id', '=', 'rit_transactions.transaction_id')
                ->where('rit_transactions.rit_id', $rit->id)
                ->select(DB::raw('SUM(rit_transactions.tonnage * rit_transactions.masak) AS total_tonnage_times_masak'))
                ->first();
            $totalTonnageTimesMasak = $transactions->total_tonnage_times_masak;

            $item = Item::find($rit->item_id);

            $report_rit = new ReportRit;
            $report_rit->tonnage_left = $rit->tonnage_left;
            $report_rit->tonnage_sold = $totalTonnageTimesMasakToday;
            $report_rit->tonnage_sold_price = $totalItemPrice;
            $report_rit->real_tonnage = null;
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

    public function get_previous_report(Request $request)
    {
        ReportRit::whereNull('report_id')->delete();
        ReportTransaction::whereNull('report_id')->delete();
        $income = Payment::whereDate('created_at', Carbon::now()->subDays($request->days))
            ->where('type', 'Cash')
            ->sum('amount');
        $transactions = Transaction::whereDate('created_at', Carbon::now()->subDays($request->days))->get();
        $allincome = Transaction::whereDate('created_at', Carbon::now()->subDays($request->days))
            ->sum('total_price');
        $expense = Expense::whereDate('time', Carbon::now()->subDays($request->days))->sum('amount');
        $tonnage = Transaction::whereDate('created_at', Carbon::now()->subDays($request->days))
            ->with('rits')
            ->get()
            ->pluck('rits')
            ->flatten()
            ->sum('tonnage');
        $item_income = Transaction::where('owner_approved', 1)
            ->whereDate('created_at', Carbon::now()->subDays($request->days))
            ->sum('item_price');
        $tb_income = Transaction::where('owner_approved', 1)
            ->whereDate('created_at', Carbon::now()->subDays($request->days))
            ->sum('tb');
        $tb_savings = Saving::whereNull('transaction_id')
            ->whereDate('created_at', Carbon::now()->subDays($request->days))
            ->sum('tb');
        $tw_income = Transaction::where('owner_approved', 1)
            ->whereDate('created_at', Carbon::now()->subDays($request->days))
            ->sum('tw');
        $tw_savings = Saving::whereNull('transaction_id')
            ->whereDate('created_at', Carbon::now()->subDays($request->days))
            ->sum('tw');
        $thr_income = Transaction::where('owner_approved', 1)
            ->whereDate('created_at', Carbon::now()->subDays($request->days))
            ->sum('thr');
        $thr_savings = Saving::whereNull('transaction_id')
            ->whereDate('created_at', Carbon::now()->subDays($request->days))
            ->sum('thr');
        $sack_income = Transaction::where('owner_approved', 1)
            ->whereDate('created_at', Carbon::now()->subDays($request->days))
            ->sum('sack_price');
        $cas_income = Cas::whereDate('created_at', Carbon::now()->subDays($request->days))
            ->sum('fee');
        $tb_expense = Expense::whereDate('time', Carbon::now()->subDays($request->days))
            ->where('type', "TB")
            ->sum('amount');
        $tw_expense = Expense::whereDate('time', Carbon::now()->subDays($request->days))
            ->where('type', "TW")
            ->sum('amount');
        $thr_expense = Expense::whereDate('time', Carbon::now()->subDays($request->days))
            ->where('type', "THR")
            ->sum('amount');
        $salary_expense = Expense::whereDate('time', Carbon::now()->subDays($request->days))
            ->where('type', "Gaji")
            ->sum('amount');
        $operational_expense = Expense::whereDate('time', Carbon::now()->subDays($request->days))
            ->where('type', "Operasional")
            ->sum('amount');
        $vehicle_expense = Expense::whereDate('time', Carbon::now()->subDays($request->days))
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
        $report->other_income = $sack_income + $cas_income;
        $report->tb_expense = $tb_expense;
        $report->tw_expense = $tw_expense;
        $report->thr_expense = $thr_expense;
        $report->salary_expense = $salary_expense;
        $report->operational_expense = $operational_expense + $vehicle_expense;

        $rits = Rit::where("tonnage_left", ">", 0)->orWhere("sold_date", Carbon::now()->subDays($request->days))->get();
        $report_rits = [];
        foreach ($rits as $key => $rit) {
            $todayTransactions = DB::table('transactions')
                ->whereDate('transactions.created_at', Carbon::now()->subDays($request->days))
                ->join('rit_transactions', 'transactions.id', '=', 'rit_transactions.transaction_id')
                ->where('rit_transactions.rit_id', $rit->id)
                ->select(DB::raw('SUM(rit_transactions.tonnage * rit_transactions.masak) AS total_tonnage_times_masak'))
                ->first();
            $totalTonnageTimesMasakToday = $todayTransactions->total_tonnage_times_masak;
            $totalItemPrice = RitTransaction::where('rit_id', $rit->id)
                ->whereDate('created_at', Carbon::now()->subDays($request->days))
                ->sum('total_price');
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
            $report_rit->tonnage_sold_price = $totalItemPrice;
            $report_rit->real_tonnage = null;
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

    public function get_monthly_report(Request $request)
    {
        $requestedMonth = $request->input('month');

        $reports = Report::whereYear('created_at', '=', substr($requestedMonth, 0, 4))
            ->whereMonth('created_at', '=', substr($requestedMonth, 5, 2))
            ->get();

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
