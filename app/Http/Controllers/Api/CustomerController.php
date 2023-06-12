<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerLeanResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\SavingResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\TransactionCompleteResource;
use App\Http\Resources\TransactionResource;
use App\Models\Cashback;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Saving;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => CustomerResource::collection($customers)
        ];
        return SuccessResource::make($return);
    }

    public function get_lean_data()
    {
        $customers = Customer::all();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => $customers
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customer = Customer::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'nickname' => $request->nickname,
            'address' => $request->address,
            'phone' => $request->phone,
            'ongkir' => $request->ongkir,
            'birthdate' => $request->birthdate,
            'type' => $request->type,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => CustomerResource::make($customer)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => CustomerLeanResource::make($customer)
        ];
        return SuccessResource::make($return);
    }

    public function get_customer_transactions(Request $request, Customer $customer)
    {
        $transactions = Transaction::where("created_at", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
            ->where("created_at", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
            ->where("customer_id", $customer->id)
            ->get();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::collection($transactions)
        ];
        return SuccessResource::make($return);
    }

    public function get_customer_savings(Request $request, Customer $customer)
    {
        $savings = Saving::where("created_at", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
            ->where("created_at", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
            ->where("customer_id", $customer->id)
            ->get();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => SavingResource::collection($savings)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $customer->update([
            'nik' => $request->nik,
            'name' => $request->name,
            'nickname' => $request->nickname,
            'address' => $request->address,
            'phone' => $request->phone,
            'ongkir' => $request->ongkir,
            'birthdate' => $request->birthdate,
            'type' => $request->type,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => CustomerResource::make($customer)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses Terhapus.',
            'api_results' => CustomerResource::make($customer)
        ];
        $customer->delete();
        return SuccessResource::make($return);
    }
    public function search(Request $request)
    {
        $customers = Customer::where('name', 'like', '%' . $request->search . '%')
            ->orWhere('nickname', 'like', '%' . $request->search . '%')->get();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => CustomerResource::collection($customers)
        ];
        return SuccessResource::make($return);
    }

    public function deposit_savings(Request $request, Customer $customer)
    {
        $saving = Saving::create([
            "tb" => $request->tb ?? 0,
            "tw" => $request->tw ?? 0,
            "thr" => $request->thr ?? 0,
            "tonnage" => 0,
            "total_tw" => $customer->tw + $request->tw,
            "total_tb" => $customer->tb + $request->tb,
            "total_thr" => $customer->thr + $request->thr,
            "total_tonnage" => $customer->tonnage,
            "type" => "Pemasukan",
            "customer_id" => $customer->id,
        ]);
        $customer->update([
            "tb" => $saving->total_tb,
            "tw" => $saving->total_tw,
            "thr" => $saving->total_thr,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => CustomerResource::make($customer)
        ];
        return SuccessResource::make($return);
    }

    public function withdraw_savings(Request $request, Customer $customer)
    {
        $saving = Saving::create([
            "tb" => $request->tb ?? 0,
            "tw" => $request->tw ?? 0,
            "thr" => $request->thr ?? 0,
            "tonnage" => 0,
            "total_tw" => $customer->tw - $request->tw,
            "total_tb" => $customer->tb - $request->tb,
            "total_thr" => $customer->thr - $request->thr,
            "total_tonnage" => $customer->tonnage,
            "type" => "Penarikan",
            "customer_id" => $customer->id,
        ]);
        $type = "tb";
        if ($request->tb != 0) {
            $type = "TB";
        } else if ($request->tw != 0) {
            $type = "TW";
        } else if ($request->thr != 0) {
            $type = "THR";
        }
        $expense = Expense::create([
            "amount" => $request->tw + $request->tb + $request->thr,
            "note" => "Penarikan " . $type,
            "name" => $customer->name,
            "time" => Carbon::now(),
            "type" => $type,
        ]);
        $customer->update([
            "tb" => $saving->total_tb,
            "tw" => $saving->total_tw,
            "thr" => $saving->total_thr,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => CustomerResource::make($customer)
        ];
        return SuccessResource::make($return);
    }

    public function approve_cashback(Request $request, Customer $customer)
    {
        if ($customer->cashback_approved != 1) {
            $cashback = Cashback::create([
                'amount' => $request->amount,
                'customer_id' => $customer->id,
            ]);
            $customer->update([
                'cashback_approved' => 1,
            ]);
        }
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => CustomerResource::make($customer)
        ];
        return SuccessResource::make($return);
    }
}
