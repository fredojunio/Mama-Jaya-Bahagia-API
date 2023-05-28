<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RitResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\TransactionResource;
use App\Mail\NotificationMail;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Rit;
use App\Models\RitBranch;
use App\Models\RitTransaction;
use App\Models\Sack;
use App\Models\Saving;
use App\Models\Transaction;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::collection($transactions)
        ];
        return SuccessResource::make($return);
    }

    public function get_owner_nota()
    {
        $transactions = Transaction::where('owner_approved', 0)
            ->where('type', 'Kiriman')
            ->get();

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::collection($transactions)
        ];
        return SuccessResource::make($return);
    }

    public function get_nota(Request $request)
    {
        $transactions = Transaction::where("created_at", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
            ->where("created_at", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
            ->where("owner_approved", "!=", 0)
            ->where("owner_approved", "!=", 3)
            ->where("type", "Kiriman")
            ->get();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::collection($transactions)
        ];
        return SuccessResource::make($return);
    }

    public function get_completed_transactions(Request $request)
    {
        $transactions = Transaction::where("created_at", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
            ->where("created_at", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
            ->where("owner_approved", 1)
            ->get();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::collection($transactions)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //NOTE - ini itu kalo misal dia nembak APInya lewat revisian ada variable old_id, yang buat ngeindikasi bahwa sudah di revisi
        if ($request->old_id) {
            $transaction = Transaction::find($request->old_id);
            $transaction->owner_approved = 3;
            $transaction->save();
        }
        $customer = Customer::find($request->customer_id);
        $trip = null;
        if ($customer->type == "Kiriman") {
            $trip = Trip::create([
                "allowance" => $request->allowance,
                "toll" => $request->toll,
                "gas" => $request->gas,
                "note" => "Penjualan ke " . $customer->name,
                "vehicle_id" => $request->vehicle_id,
            ]);
            $vehicle = Vehicle::find($trip->vehicle_id);
            $vehicle->update([
                "toll" => $vehicle->toll + $request->toll
            ]);
        }
        $transaction = Transaction::create([
            "daily_id" => Transaction::whereDate('created_at', now()->toDateString())->get()->count() + 1,
            "tb" => $request->tb,
            "tw" => $request->tw,
            "thr" => $request->thr,
            "sack" => $request->sack,
            "sack_price" => $request->sack_fee ? $request->sack * 1000 : 0,
            "item_price" => $request->item_prices,
            "discount" => $request->discount ?? 0,
            "ongkir" => $request->ongkir,
            "total_price" => $request->total_price,
            "owner_approved" => $trip ? 0 : 1,
            "customer_id" => $request->customer_id,
            "trip_id" => $trip ? $trip->id : null,
            "type" => $customer->type
        ]);
        $remainingSacks = $transaction->sack;
        if (!$trip) {
            while ($remainingSacks > 0) {
                $sack = Sack::where('amount', '>', 0)
                    ->orderBy('created_at', 'asc')
                    ->first();
                if ($sack->amount < $remainingSacks) {
                    $remainingSacks -= $sack->amount;
                    $sack->amount = 0;
                    $sack->save();
                } else {
                    $sack->amount = $sack->amount - $remainingSacks;
                    $remainingSacks = 0;
                    $sack->save();
                }
            }
        }
        foreach ($request->rits as $key => $rit) {
            $rite = Rit::find($rit['item']['id']);
            $rit_transaction = RitTransaction::create([
                "daily_id" => $transaction->daily_id,
                "customer_name" => $customer->nickname,
                "tonnage" => $rit["tonnage"],
                "masak" => $rit["masak"],
                "item_price" => $rit["price"],
                "total_price" => $rit["total_price"],
                "tonnage_left" => $rite->tonnage_left - ($rit["tonnage"] * $rit["masak"]),
                "actual_tonnage" => $rit["real_tonnage"],
                "rit_id" => $rit["item"]["id"],
                "transaction_id" => $transaction->id
            ]);
            $rite->update([
                'tonnage_left' => $rit_transaction->tonnage_left,
            ]);
            if ($rite->tonnage_left == 0) {
                $rite->update([
                    "sold_date" => Carbon::now()
                ]);
            }
        }
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::make($transaction)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::make($transaction)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $transaction->update([
            "daily_id" => $request->daily_id,
            "tb" => $request->tb,
            "tw" => $request->tw,
            "thr" => $request->thr,
            "sack" => $request->sack,
            "sack_price" => $request->sack_price,
            "item_price" => $request->item_price,
            "discount" => $request->discount,
            "ongkir" => $request->ongkir,
            "total_price" => $request->total_price,
            "settled_date" => $request->settled_date,
            "owner_approved" => $request->owner_approved,
            "finance_approved" => $request->finance_approved,
            "customer_id" => $request->customer_id,
            "trip_id" => $request->trip_id,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::make($transaction)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses Terhapus.',
            'api_results' => TransactionResource::make($transaction)
        ];
        $transaction->delete();
        return SuccessResource::make($return);
    }

    public function approve_finance(Transaction $transaction, Request $request)
    {
        $customer = Customer::find($transaction->customer_id);
        $payment = Payment::create([
            'amount' => $request->amount,
            'customer_id' => $customer->id,
            'transaction_id' => $transaction->id
        ]);
        $total_payments = Payment::where("transaction_id", $transaction->id)
            ->sum("amount");
        if ($total_payments == $transaction->total_price) {
            $transaction->update([
                "finance_approved" => 1,
                "settled_date" => Carbon::now(),
            ]);
            $tonnage_transaction = 0;
            foreach ($transaction->rits as $key => $rit_transaction) {
                $tonnage_transaction += $rit_transaction->tonnage;
            }

            $saving = Saving::create([
                "tb" => $transaction->tb ?? 0,
                "tw" => $transaction->tw ?? 0,
                "thr" => $transaction->thr ?? 0,
                "tonnage" => $tonnage_transaction,
                "total_tw" => $customer->tw + $transaction->tw,
                "total_tb" => $customer->tb + $transaction->tb,
                "total_thr" => $customer->thr + $transaction->thr,
                "total_tonnage" => $customer->tonnage + $tonnage_transaction,
                "type" => "Pemasukan",
                "customer_id" => $transaction->customer_id,
                "transaction_id" => $transaction->id,
            ]);

            $customer->update([
                "tb" => $saving->total_tb,
                "tw" => $saving->total_tw,
                "thr" => $saving->total_thr,
                "tonnage" => $saving->total_tonnage,
            ]);
        }

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::make($transaction)
        ];
        return SuccessResource::make($return);
    }

    public function approve_nota(Transaction $transaction, Request $request)
    {
        if ($request->owner_approved == 1) {
            //NOTE - Approved
            $trip = Trip::find($transaction->trip_id);
            $trip->update([
                "finance_approved" => 1
            ]);
            $vehicle = Vehicle::find($trip->vehicle_id);
            if ($trip->gas > 0) {
                $vehicle->update([
                    "trip_count" => 1,
                ]);
            } else {
                $vehicle->update([
                    "trip_count" => $vehicle->trip_count + 1,
                ]);
            }
            $customer = Customer::find($transaction->customer_id);
            Expense::create([
                "amount" => $trip->allowance + $trip->toll + $trip->gas,
                "note" => "Penjualan Ke " . $customer->name,
                "type" => "Kendaraan",
                "trip_id" => $trip->id
            ]);
            $transaction->update([
                "owner_approved" => 1,
            ]);
            $users = User::where("role_id", 1)->get();
            $emailArray = $users->pluck('email')->toArray();
            Mail::to($emailArray)->send(new NotificationMail("Input Pemasukan", "Ada penjualan yang sudah dikirim namun pemasukan yang didapat belum dicatat."));
            $remainingSacks = $transaction->sack;
            while ($remainingSacks > 0) {
                $sack = Sack::where('amount', '>', 0)
                    ->orderBy('created_at', 'asc')
                    ->first();
                if ($sack->amount < $remainingSacks) {
                    $remainingSacks -= $sack->amount;
                    $sack->update([
                        "amount" => 0
                    ]);
                } else {
                    $sack->update([
                        "amount" => $sack->amount - $remainingSacks
                    ]);
                    $remainingSacks = 0;
                }
            }
        } else if ($request->owner_approved == 2) {
            //NOTE - Rejected
            $transaction->update([
                "owner_approved" => 2,
            ]);
            foreach ($transaction->rits as $key => $rit) {
                $rite = Rit::find($rit->rit_id);
                if ($rite->tonnage_left == 0) {
                    $rite->update([
                        "sold_date" => null
                    ]);
                }
                $rite->update([
                    'tonnage_left' => $rite->tonnage_left + ($rit["tonnage"] * $rit["masak"]),
                ]);
            }
        }
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::make($transaction)
        ];
        return SuccessResource::make($return);
    }

    public function customer(Transaction $transaction, Request $request)
    {
        $customer = Customer::find($request->customer_id);
        $transaction->update([
            "item_price" => $request->item_prices,
            "ongkir" => $request->ongkir,
            "total_price" => $request->total_price,
            "owner_approved" => 1,
            "customer_id" => $request->customer_id,
            "trip_id" => $transaction->trip_id,
            "type" => "Owner"
        ]);
        $users = User::where("role_id", 1)->get();
        $emailArray = $users->pluck('email')->toArray();
        Mail::to($emailArray)->send(new NotificationMail("Input Pemasukan", "Ada penjualan yang sudah dikirim namun pemasukan yang didapat belum dicatat."));
        foreach ($request->rits as $key => $rit) {
            $rite = Rit::find($rit['item']['id']);
            $rite->update([
                "customer_transaction_id" => $transaction->id,
            ]);
            $rit_transaction = RitTransaction::create([
                "daily_id" => $transaction->daily_id,
                "customer_name" => $customer->nickname,
                "tonnage" => $rit["tonnage"],
                "masak" => $rit["masak"],
                "item_price" => $rit["price"],
                "total_price" => $rit["total_price"],
                "rit_id" => $rit["item"]["id"],
                "transaction_id" => $transaction->id
            ]);
        }
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::make($transaction)
        ];
        return SuccessResource::make($return);
    }

    public function branch(Rit $rit, Request $request)
    {
        foreach ($request->branches as $key => $branch) {
            $ritBranch = RitBranch::find($branch["id"]);
            $ritBranch->update([
                "income" => $branch["income"] ?? 0
            ]);
            $transaction = Transaction::create([
                "daily_id" => Transaction::whereDate('created_at', now()->toDateString())->get()->count() + 1,
                "total_price" => $branch["income"],
                "owner_approved" => 1,
                "finance_approved" => 1,
                "settled_date" => Carbon::now(),
                "trip_id" => $branch["trip"]["id"],
                "type" => "Cabang"
            ]);
            $rit_transaction = RitTransaction::create([
                "daily_id" => $transaction->daily_id,
                "customer_name" => $branch["name"],
                "tonnage" => $branch["sent_tonnage"],
                "item_price" => 0,
                "total_price" => $branch["income"] ?? 0,
                "tonnage_left" => 0,
                "rit_id" => $request->id,
                "transaction_id" => $transaction->id
            ]);
        }
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::make($rit)
        ];
        return SuccessResource::make($return);
    }

    public function get_remaining_sack()
    {
        $totalAmount = Sack::sum('amount');
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => $totalAmount
        ];
        return SuccessResource::make($return);
    }
}
