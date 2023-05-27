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
                ->where("created_at", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
                ->where("created_at", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
                ->get();
        } else if ($request->filter == "Tabungan") {
            $expenses = Expense::where("type", "TW")
                ->orWhere("type", "TB")
                ->orWhere("type", "THR")
                ->where("created_at", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
                ->where("created_at", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
                ->get();
        } else if ($request->filter == "Cashback") {
            $expenses = Expense::where("type", "Cashback")
                ->where("created_at", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
                ->where("created_at", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
                ->get();
        } else if ($request->filter == "Operasional") {
            $expenses = Expense::where("type", "Operasional")
                ->where("created_at", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
                ->where("created_at", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
                ->get();
        } else if ($request->filter == "Gaji") {
            $expenses = Expense::where("type", "Gaji")
                ->where("created_at", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
                ->where("created_at", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
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
        $expense->update([
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
