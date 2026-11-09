<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\SuccessResource;
use App\Models\Coa;
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
        $expenses = Expense::with('coa')->get();
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
        $start = Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString();
        $end = Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString();

        $query = Expense::with('coa')
            ->where("time", ">=", $start)
            ->where("time", "<=", $end);

        if ($request->filled('coa_id')) {
            $query->where('coa_id', $request->coa_id);

            // Keep the existing Gaji tab behaviour: hide monthly salary rows.
            if (Coa::where('id', $request->coa_id)->value('code') === Coa::GAJI) {
                $this->hideMonthlySalary($query);
            }
        } else {
            switch ($request->filter) {
                case "Kendaraan":
                    $query->where("type", "Kendaraan");
                    break;
                case "Tabungan":
                    $query->whereIn("type", ["TW", "TB", "THR"]);
                    break;
                case "Cashback":
                    $query->where("type", "Cashback");
                    break;
                case "Operasional":
                    $query->where("type", "Operasional");
                    break;
                case "Gaji":
                    $query->where("type", "Gaji");
                    $this->hideMonthlySalary($query);
                    break;
                case "All":
                    break;
                default:
                    // Unknown filter: return nothing rather than every expense.
                    $query->whereRaw('1 = 0');
                    break;
            }
        }

        $expenses = $query->get();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => ExpenseResource::collection($expenses),
        ];
        return SuccessResource::make($return);
    }

    private function hideMonthlySalary($query): void
    {
        $query->whereRaw('(LOWER(note) != ? OR note IS NULL)', ['bulanan']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $coaId = $request->coa_id;

        if (!$coaId) {
            $defaultCoaCode = [
                'Kendaraan' => Coa::KENDARAAN,
                'Gaji' => Coa::GAJI,
                'Operasional' => Coa::OPERASIONAL,
            ][$request->type] ?? null;

            if ($defaultCoaCode) {
                $coaId = Coa::idFor($defaultCoaCode);
            }
        }

        $expense = Expense::create([
            "amount" => $request->amount,
            "note" => $request->note,
            "name" => $request->name,
            "time" => $request->time,
            "type" => $request->type,
            "coa_id" => $coaId,
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
                "tb" => $expense->type == "TB" ? $customer->tb - $amount_difference : $customer->tb,
                "tw" => $expense->type == "TW" ? $customer->tw - $amount_difference : $customer->tw,
                "thr" => $expense->type == "THR" ? $customer->thr - $amount_difference : $customer->thr,
            ]);
        } else {
            $expense->update([
                "amount" => $request->expense["amount"],
                "note" => $request->expense["note"],
                "name" => $request->expense["name"],
                "time" => $request->expense["time"],
                "coa_id" => $request->expense["coa_id"] ?? $expense->coa_id,
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
