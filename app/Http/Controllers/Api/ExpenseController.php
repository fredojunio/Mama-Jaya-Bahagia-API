<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\SuccessResource;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::all();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ExpenseResource::collection($expenses),
        ];
        return SuccessResource::make($return);
    }

    public function filter(Request $request)
    {
        if ($request->filter == "Kendaraan") {
            $expenses = Expense::where("type", "Kendaraan")
                ->where("time", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
                ->where("time", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
                ->get();
        } else if ($request->filter == "Tabungan") {
            $expenses = Expense::where(function ($query) {
                $query->where("type", "TW")
                    ->orWhere("type", "TB")
                    ->orWhere("type", "THR");
            })
                ->where("time", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
                ->where("time", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
                ->get();
        } else if ($request->filter == "Cashback") {
            $expenses = Expense::where("type", "Cashback")
                ->where("time", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
                ->where("time", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
                ->get();
        } else if ($request->filter == "Operasional") {
            $expenses = Expense::where("type", "Operasional")
                ->where("time", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
                ->where("time", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
                ->get();
        } else if ($request->filter == "Gaji") {
            $expenses = Expense::where("type", "Gaji")
                ->where("time", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
                ->where("time", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
                ->get();
        }
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ExpenseResource::collection($expenses),
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $expense = Expense::create([
            "amount" => $request->amount,
            "note" => $request->note,
            "name" => $request->name,
            "time" => $request->time,
            "type" => $request->type,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ExpenseResource::make($expense),
        ];
        return SuccessResource::make($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ExpenseResource::make($expense),
        ];
        return SuccessResource::make($return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        if ($expense->type == "Kendaraan") {
            $expense->update([
                "amount" => $request->expense["trip"]["gas"] + $request->expense["trip"]["allowance"] + $request->expense["trip"]["toll"],
                "note" => $request->expense["note"],
                "time" => $request->expense["time"],
            ]);
            $expense->trip->update([
                "gas" => $request->expense["trip"]["gas"],
                "toll" => $request->expense["trip"]["toll"],
                "allowance" => $request->expense["trip"]["allowance"],
            ]);
        } else if ($expense->type == "TB" || $expense->type == "TW" || $expense->type == "THR") {
            $saving = $expense->savings;
            $amount_difference = $request->expense["amount"] - $expense->amount;
            $expense->update([
                "amount" => $request->expense["amount"],
                "note" => $request->expense["note"],
                "time" => $request->expense["time"],
            ]);

            $saving->update([
                "tb" => $expense->type == "TB" ? $request->expense["amount"] : $saving->tb,
                "tw" => $expense->type == "TW" ? $request->expense["amount"] : $saving->tw,
                "thr" => $expense->type == "THR" ? $request->expense["amount"] : $saving->thr,
                "total_tb" => $expense->type == "TB" ? $saving->total_tb - $amount_difference : $saving->total_tb,
                "total_tw" => $expense->type == "TW" ? $saving->total_tw - $amount_difference : $saving->total_tw,
                "total_thr" => $expense->type == "THR" ? $saving->total_thr - $amount_difference : $saving->total_thr,
            ]);

            $customer = $saving->customer;

            $customer->update([
                "tb" => $saving->total_tb,
                "tw" => $saving->total_tw,
                "thr" => $saving->total_thr,
            ]);
        } else {
            $expense->update([
                "amount" => $request->expense["amount"],
                "note" => $request->expense["note"],
                "name" => $request->expense["name"],
                "time" => $request->expense["time"],
            ]);
        }
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ExpenseResource::make($expense),
        ];
        return SuccessResource::make($return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses Terhapus.',
            'api_results' => ExpenseResource::make($expense),
        ];
        $expense->delete();
        return SuccessResource::make($return);
    }
}
