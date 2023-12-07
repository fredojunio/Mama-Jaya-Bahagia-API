<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RitResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\TransactionCompleteResource;
use App\Http\Resources\TransactionResource;
use App\Mail\NotificationMail;
use App\Models\Cas;
use App\Models\CasDeposit;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Rit;
use App\Models\RitBranch;
use App\Models\RitHistory;
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

    public function get_owner_transactions()
    {
        $transactions = Transaction::where('owner_approved', 0)
            ->where('type', 'Owner')
            ->get();

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

    public function get_requested_revisions()
    {
        $transactions = Transaction::where('revision_requested', 1)
            ->where('revision_allowed', 0)
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
            ->where("daily_id", "<", 90000)
            ->get();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionCompleteResource::collection($transactions)
        ];
        return SuccessResource::make($return);
    }

    public function get_completed_owner_transactions(Request $request)
    {
        $transactions = Transaction::where("created_at", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
            ->where("created_at", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
            ->where("owner_approved", 1)
            ->where("type", "Owner")
            ->get();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionCompleteResource::collection($transactions)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customer = Customer::find($request->customer_id);
        $hasTransactionToday = $customer->transactions()
            ->whereDate('created_at', Carbon::today())
            ->exists();
        if (!$hasTransactionToday) {
            $customer->update([
                "cashback_days" => $customer->cashback_days + 1
            ]);
        }
        $customer = Customer::find($request->customer_id);
        $trip = null;
        if ($customer->type == "Kiriman" && $request->vehicle_id) {
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
            "daily_id" => Transaction::whereDate('created_at', now()->toDateString())->where('daily_id', '<', 90000)->get()->count() + 1,
            "tb" => $request->tb,
            "tw" => $request->tw,
            "thr" => $request->thr,
            "sack" => $request->sack,
            "sack_free" => $request->sack_free,
            "sack_price" => $request->sack * 1500,
            "other" => $request->other,
            "item_price" => $request->item_prices,
            "discount" => $request->discount ?? 0,
            "ongkir" => $request->ongkir,
            "total_price" => $request->total_price,
            "owner_approved" => $customer->type == "Kiriman" ? 0 : 1,
            "customer_id" => $request->customer_id,
            "trip_id" => $trip ? $trip->id : null,
            "type" => $customer->type,
            "created_at" => $customer->type != "Kiriman" ? $request->date : Carbon::now()
        ]);
        $remainingSacks = $transaction->sack + $transaction->sack_free;
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
                "transaction_id" => $transaction->id,
                "created_at" => $transaction->created_at
            ]);
            $rite->update([
                'tonnage_left' => $rit_transaction->tonnage_left,
            ]);
            RitHistory::create([
                "info" => "Rit dibeli oleh: {$customer->nickname}, Jumlah tonase: " . ($rit["tonnage"] * $rit["masak"]) . " Tonase sisa: {$rite->tonnage_left}",
                "rit_id" => $rite->id
            ]);
            if ($rite->tonnage_left == 0) {
                $rite->update([
                    "sold_date" => Carbon::now()
                ]);
                RitHistory::create([
                    "info" => "Rit habis terjual.",
                    "rit_id" => $rite->id
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
        $customer = Customer::find($request->new_transaction["customer_id"]);
        if ($transaction->trip_id && $customer->type == "Kiriman") {
            // Sebelumnya kiriman, sekarang tetep kiriman
            $trip = Trip::find($transaction->trip_id);
            $vehicle = Vehicle::find($trip->vehicle_id);
            $vehicle->update([
                "toll" => $vehicle->toll - $trip->toll + $request->new_transaction["toll"]
            ]);
            $trip->update([
                "allowance" => $request->new_transaction["allowance"],
                "toll" => $request->new_transaction["toll"],
                "gas" => $request->new_transaction["gas"],
            ]);
            if ($trip->finance_approved == 1) {
                $trip->expense->update([
                    "amount" => $trip->allowance + $trip->toll + $trip->gas,
                ]);
            }
        } else if ($transaction->trip_id && $customer->type != "Kiriman") {
            // Sebelumnya kiriman, sekarang BUKAN kiriman
            $trip = Trip::find($transaction->trip_id);
            $vehicle = Vehicle::find($trip->vehicle_id);
            $transaction->update([
                "trip_id" => null,
            ]);
            $vehicle->update([
                "toll" => $vehicle->toll - $trip->toll
            ]);
            if ($trip->finance_approved == 1) {
                $trip->expense->delete();
            }
            $trip->delete();
        }
        // NOTE - Ini jalan kalo financenya udah di approve & customernya berubah
        if ($transaction->finance_approved == 1 && $transaction->customer_id != $request->new_transaction["customer_id"]) {
            //NOTE - ini ngurangin tabungan customer sebelumnya
            $old_customer = Customer::find($transaction->customer_id);
            $old_customer->update([
                "tb" => $old_customer->tb - $transaction->tb,
                "tw" => $old_customer->tw - $transaction->tw,
                "thr" => $old_customer->thr - $transaction->thr,
                "tonnage" => $old_customer->tonnage - $transaction->rits->sum("tonnage"),
            ]);
            // NOTE - Ini nambahin tabungan customer yang baru
            $newTonnage = 0;
            foreach ($request->new_transaction["rits"] as $item) {
                if (isset($item['tonnage'])) {
                    $newTonnage += $item['tonnage'];
                }
            }
            $customer->update([
                "tb" => $customer->tb + $request->new_transaction["tb"],
                "tw" => $customer->tw + $request->new_transaction["tw"],
                "thr" => $customer->thr + $request->new_transaction["thr"],
                "tonnage" => $customer->tonnage + $newTonnage,
            ]);
            // NOTE - Ini kalo financenya udah di approve tapi customernya sama
        } else if ($transaction->finance_approved == 1 && $transaction->customer_id == $request->new_transaction["customer_id"]) {
            //NOTE - ini ngurangin tabungan customer sebelumnya
            $newTonnage = 0;
            foreach ($request->new_transaction["rits"] as $item) {
                if (isset($item['tonnage'])) {
                    $newTonnage += $item['tonnage'];
                }
            }
            $old_customer = Customer::find($transaction->customer_id);
            $customer->update([
                "tb" => $old_customer->tb - $transaction->tb + $request->new_transaction["tb"],
                "tw" => $old_customer->tw - $transaction->tw + $request->new_transaction["tw"],
                "thr" => $old_customer->thr - $transaction->thr + $request->new_transaction["thr"],
                "tonnage" => $old_customer->tonnage - $transaction->rits->sum("tonnage") + $newTonnage,
            ]);
        }
        $transaction->update([
            "tb" => $request->new_transaction["tb"],
            "tw" => $request->new_transaction["tw"],
            "thr" => $request->new_transaction["thr"],
            "sack" => $request->new_transaction["sack"],
            "sack_free" => $request->new_transaction["sack_free"],
            "sack_price" => $request->new_transaction["sack"] * 1500,
            "other" => $request->new_transaction["other"],
            "item_price" => $request->new_transaction["item_prices"],
            "discount" => $request->new_transaction["discount"],
            "ongkir" => $request->new_transaction["ongkir"],
            "total_price" => $request->new_transaction["total_price"],
            "customer_id" => $request->new_transaction["customer_id"],
            "trip_id" => $customer->type == "Kiriman" ? $transaction->trip_id : null,
            "type" => $customer->type,
            "revision_requested" => 0,
            "revision_allowed" => 0,
        ]);

        // NOTE - Ini update yang dilakuin kalo udah di approve sama finance
        if ($transaction->finance_approved == 1) {
            // NOTE - Ini ngebalikin stok rit yang sebelumnya terjual
            foreach ($transaction->rits as $key => $rit) {
                $rite = Rit::find($rit['rit_id']);
                $rite->update([
                    "tonnage_left" => $rite->tonnage_left + ($rit["tonnage"] * $rit["masak"]),
                ]);
                RitHistory::create([
                    "info" => "Stok rit kembali karena nota di edit oleh finance, Tonase asli: {$rite->tonnage_left}, Tambahan tonase karena direvisi: " . ($rit["tonnage"] * $rit["masak"]),
                    "rit_id" => $rite->id
                ]);
                if ($rite->tonnage_left != 0) {
                    $rite->update([
                        "sold_date" => null
                    ]);
                    RitHistory::create([
                        "info" => "Rit tidak jadi terjual karena nota di edit oleh finance, Tonase asli: {$rite->tonnage_left}, Tambahan tonase karena direvisi: " . ($rit["tonnage"] * $rit["masak"]),
                        "rit_id" => $rite->id
                    ]);
                }
                $rit->delete();
            }

            // NOTE - Ini nguranginya stok rit yang baru
            foreach ($request->new_transaction["rits"] as $key => $rit) {
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
                    "transaction_id" => $transaction->id,
                    "created_at" => $transaction->created_at
                ]);
                $rite->update([
                    'tonnage_left' => $rit_transaction->tonnage_left,
                ]);
                RitHistory::create([
                    "info" => "Rit dibeli oleh: {$customer->nickname}, Jumlah tonase: " . ($rit["tonnage"] * $rit["masak"]) . " Tonase sisa: {$rite->tonnage_left}",
                    "rit_id" => $rite->id
                ]);
                if ($rite->tonnage_left == 0) {
                    $rite->update([
                        "sold_date" => Carbon::now()
                    ]);
                    RitHistory::create([
                        "info" => "Rit habis terjual.",
                        "rit_id" => $rite->id
                    ]);
                }
            }
            //NOTE - Ini update data tabungan yang sebelumnya jadi ke yang baru + id customer yang baru
            $tonnage_transaction = 0;
            foreach ($request->new_transaction["rits"] as $key => $rit) {
                $tonnage_transaction += $rit["tonnage"];
            }
            $old_savings = $transaction->savings;
            $old_savings->update([
                "tb" => $transaction->tb ?? 0,
                "tw" => $transaction->tw ?? 0,
                "thr" => $transaction->thr ?? 0,
                "tonnage" => $tonnage_transaction,
                "total_tb" => $transaction->customer->tb,
                "total_tw" => $transaction->customer->tw,
                "total_thr" => $transaction->customer->thr,
                "total_tonnage" => $transaction->customer->tonnage + $tonnage_transaction,
                "customer_id" => $transaction->customer_id,
            ]);

            // NOTE - Ini update data payment yang sebelumnya jadi ke id customer yang baru
            $old_payments = $transaction->payments;
            foreach ($old_payments as $key => $old_payment) {
                $old_payment->update([
                    "amount" => $transaction->total_price,
                    "customer_id" => $transaction->customer_id,
                ]);
            }
        };
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
        // $transaction->delete();
        return SuccessResource::make($return);
    }

    public function approve_finance(Transaction $transaction, Request $request)
    {
        $customer = Customer::find($transaction->customer_id);
        $payment = Payment::create([
            'amount' => $request->amount,
            'type' => $request->transfer ? 'Transfer' : 'Cash',
            'customer_id' => $customer ? $customer->id : null,
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

            if ($transaction->type != "Cas") {
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
        }

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::make($transaction)
        ];
        return SuccessResource::make($return);
    }

    public function reject_finance(Transaction $transaction)
    {
        if ($transaction->type == "Cas") {
            $cas = Cas::find($transaction->cas_id);
            $deposit = CasDeposit::first();
            $deposit->update([
                "koin" => $deposit["koin"] + $cas["koin"],
                "seribu" => $deposit["seribu"] + $cas["seribu"],
                "duaribu" => $deposit["duaribu"] + $cas["duaribu"],
                "limaribu" => $deposit["limaribu"] + $cas["limaribu"],
                "sepuluhribu" => $deposit["sepuluhribu"] + $cas["sepuluhribu"],
                "duapuluhribu" => $deposit["duapuluhribu"] + $cas["duapuluhribu"],
            ]);
            $cas->delete();
        } else {
            if ($transaction->trip_id) {
                //NOTE - Ini kalo tipenya tadi buat nota
                $trip = Trip::find($transaction->trip_id);
                $vehicle = Vehicle::find($trip->vehicle_id);
                $vehicle->update([
                    "trip_count" => $vehicle->trip_count - 1,
                    "toll" => $vehicle->toll - $trip->toll
                ]);
                $trip->expense->delete();
                $trip->delete();
            }
            $remainingSacks = $transaction->sack + $transaction->sack_free;
            $sack = Sack::where('amount', '>', 0)
                ->orderBy('created_at', 'asc')
                ->first();
            $sack->update([
                "amount" => $sack->amount + $remainingSacks
            ]);

            foreach ($transaction->rits as $key => $rit) {
                $rite = Rit::find($rit->rit_id);
                if ($rite->tonnage_left == 0) {
                    $rite->update([
                        "sold_date" => null
                    ]);
                    RitHistory::create([
                        "info" => "Rit tidak jadi habis terjual karena nota di reject oleh finance.",
                        "rit_id" => $rite->id
                    ]);
                }
                RitHistory::create([
                    "info" => "Rit di reject oleh finance, Tonase asli: {$rite->tonnage_left}, Tambahan tonase karena direject: " . ($rit["tonnage"] * $rit["masak"]),
                    "rit_id" => $rite->id
                ]);
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

        $transaction->delete();
        return SuccessResource::make($return);
    }

    public function approve_nota(Transaction $transaction, Request $request)
    {
        if ($request->owner_approved == 1) {
            //NOTE - Approved
            if ($transaction->trip_id) {
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
                    "time" => Carbon::now(),
                    "type" => "Kendaraan",
                    "trip_id" => $trip->id
                ]);
            }
            $transaction->update([
                "owner_approved" => 1,
            ]);
            $users = User::where("role_id", 1)->get();
            $emailArray = $users->pluck('email')->toArray();
            Mail::to($emailArray)->send(new NotificationMail("Input Pemasukan", "Ada penjualan yang sudah dikirim namun pemasukan yang didapat belum dicatat."));
            $remainingSacks = $transaction->sack + $transaction->sack_free;
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
                    RitHistory::create([
                        "info" => "Rit tidak jadi habis terjual karena nota di reject oleh owner.",
                        "rit_id" => $rite->id
                    ]);
                }
                RitHistory::create([
                    "info" => "Rit di reject oleh owner, Tonase asli: {$rite->tonnage_left}, Tambahan tonase karena direject: " . ($rit["tonnage"] * $rit["masak"]),
                    "rit_id" => $rite->id
                ]);
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

    public function approve_owner(Transaction $transaction, Request $request)
    {
        $customer = Customer::find($request->customer_id);
        $transaction->update([
            "item_price" => $request->item_prices,
            "ongkir" => $request->ongkir,
            "total_price" => $request->total_price,
            "owner_approved" => 1,
        ]);
        $users = User::where("role_id", 1)->get();
        $emailArray = $users->pluck('email')->toArray();
        Mail::to($emailArray)->send(new NotificationMail("Input Pemasukan", "Ada penjualan yang sudah dikirim namun pemasukan yang didapat belum dicatat."));
        foreach ($request->rits as $key => $rit) {
            $rite = Rit::find($rit['item']['id']);
            $rite->update([
                "customer_transaction_id" => $transaction->id,
            ]);
            RitHistory::create([
                "info" => "Rit untuk customer sudah terjual. Harga: " . $request->item_prices,
                "rit_id" => $rite->id
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

    public function reject_owner(Transaction $transaction)
    {
        foreach ($transaction->rits as $key => $ritTransaction) {
            RitHistory::create([
                "info" => "Penjualan rit customer di reject.",
                "rit_id" => $ritTransaction->rit_id
            ]);
            $rite = Rit::find($ritTransaction->rit_id);
            $rite->update([
                "customer_transaction_id" => null,
            ]);
            $ritTransaction->delete();
        }
        $transaction->update([
            "item_price" => null,
            "ongkir" => null,
            "total_price" => null,
            "owner_approved" => 0,
        ]);
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
                "daily_id" => Transaction::whereDate('created_at', now()->toDateString())->where('daily_id', '>=', 90000)->get()->count() + 90000,
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

    public function request_revision(Transaction $transaction, Request $request)
    {
        $transaction->update([
            "revision_requested" => 1,
            "revision_note" => $request->note,
        ]);

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TransactionResource::make($transaction)
        ];
        return SuccessResource::make($return);
    }

    public function approve_revision(Transaction $transaction)
    {
        $transaction->update([
            "revision_allowed" => 1
        ]);
        if ($transaction->owner_approved == 1) {
            $sack = Sack::where('amount', '>', 0)
                ->orderBy('created_at', 'asc')
                ->first();
            $sack->update([
                'amount' => $sack->amount + $transaction->sack
            ]);
        }
        foreach ($transaction->rits as $key => $rit) {
            $rite = Rit::find($rit->rit_id);
            if ($rite->tonnage_left == 0) {
                $rite->update([
                    "sold_date" => null
                ]);
                RitHistory::create([
                    "info" => "Rit tidak jadi habis terjual karena di approve untuk revisi.",
                    "rit_id" => $rite->id
                ]);
            }
            RitHistory::create([
                "info" => "Rit di approve untuk revisi, Tonase asli: {$rite->tonnage_left}, Tambahan tonase karena direvisi: " . ($rit["tonnage"] * $rit["masak"]),
                "rit_id" => $rite->id
            ]);
            $rite->update([
                'tonnage_left' => $rite->tonnage_left + ($rit["tonnage"] * $rit["masak"]),
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
}
