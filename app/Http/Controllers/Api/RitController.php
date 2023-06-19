<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RitResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\TripResource;
use App\Mail\NotificationMail;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Item;
use App\Models\Rit;
use App\Models\RitBranch;
use App\Models\Sack;
use App\Models\Transaction;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get_all_stock()
    {
        $rits = Rit::whereNotNull("arrival_date")->where("sell_price", ">", 0)->where("is_hold", 0)->whereNull("sold_date")->get();

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::collection($rits)
        ];
        return SuccessResource::make($return);
    }
    public function get_sell_owner_stock()
    {
        $rits = Rit::whereNotNull('arrival_date')
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('customer_tonnage', '>', 0)
                        ->whereNull('customer_transaction_id');
                })->orWhere(function ($query) {
                    $query->where('branch_tonnage', '>', 0)
                        ->whereHas('branches', function ($query) {
                            $query->whereNull('income');
                        });
                });
            })
            ->get();

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::collection($rits)
        ];
        return SuccessResource::make($return);
    }
    public function get_created_stock()
    {
        $rits = Rit::whereNull("arrival_date")->where("finance_approved", 0)->get();

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::collection($rits)
        ];
        return SuccessResource::make($return);
    }

    public function get_otw_stock()
    {
        $rits = Rit::whereNull("arrival_date")->where("finance_approved", 1)->get();

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::collection($rits)
        ];
        return SuccessResource::make($return);
    }
    public function get_owner_stock()
    {
        $rits = Rit::whereNull("sold_date")
            ->where("finance_approved", 1)
            ->where(function ($query) {
                $query->whereNull("tonnage_left")
                    ->orWhere("tonnage_left", ">", 0);
            })
            ->get();

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::collection($rits)
        ];
        return SuccessResource::make($return);
    }
    public function get_hold_stock()
    {
        $rits = Rit::whereNull("sold_date")->where("is_hold", 1)->get();

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::collection($rits)
        ];
        return SuccessResource::make($return);
    }
    public function get_empty_stock(Request $request)
    {
        if ($request->item_id) {
            $rits = Rit::whereNotNull("sold_date")
                ->where("arrival_date", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
                ->where("arrival_date", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
                ->where("item_id", $request->item_id)
                ->get();
        } else {
            // NOTE - Owner - Laba Rugi
            $rits = Rit::whereNotNull("sold_date")
                ->where("sold_date", ">=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->start_date)->toDateTimeString())
                ->where("sold_date", "<=", Carbon::createFromFormat('D M d Y H:i:s e+', $request->end_date)->toDateTimeString())
                ->get();
        }

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::collection($rits)
        ];
        return SuccessResource::make($return);
    }

    public function index()
    {
        $rits = Rit::all();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::collection($rits)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vehicle = Vehicle::find($request->vehicle_id);
        $item = Item::find($request->item_id);
        $customer = null;
        if ($request->send_to_customer) {
            $customer = Customer::find($request->customer_id);
        }

        $trip = Trip::create([
            "allowance" => $request->allowance,
            "toll" => $request->toll,
            "gas" => $request->gas,
            "note" => "Pengambilan Rit " . $item->code,
            "vehicle_id" => $request->vehicle_id,
        ]);

        $rit = Rit::create([
            "do_code" => $request->do_code,
            "expected_tonnage" => $request->tonnage + ($request->send_to_customer ?  $request->customer["tonnage"] : 0),
            "customer_tonnage" => $request->send_to_customer ? $request->customer["tonnage"] : null,
            "main_tonnage" => $request->tonnage,
            "item_id" => $request->item_id,
            "trip_id" => $trip->id,
            "customer_id" => $request->send_to_customer ? $request->customer_id : null
        ]);

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::make($rit)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rit $rit)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::make($rit)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rit $rit)
    {
        $rit->update([
            "expected_tonnage" => $request->expected_tonnage,
            "customer_tonnage" => $request->customer_tonnage,
            "branch_tonnage" => $request->branch_tonnage,
            "main_tonnage" => $request->main_tonnage,
            "retur_tonnage" => $request->retur_tonnage,
            "arrived_tonnage" => $request->arrived_tonnage,
            "tonnage_left" => $request->tonnage_left,
            "delivery_date" => $request->delivery_date,
            "arrival_date" => $request->arrival_date,
            "sold_date" => $request->sold_date,
            "sell_price" => $request->sell_price,
            "buy_price" => $request->buy_price,
            "sack" => $request->sack,
            "finance_approved" => $request->finance_approved,
            "is_hold" => $request->is_hold,
            "item_id" => $request->item_id,
            "trip_id" => $request->trip_id,
            "retur_trip_id" => $request->retur_trip_id,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::make($rit)
        ];
        return SuccessResource::make($return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rit $rit)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses Terhapus.',
            'api_results' => RitResource::make($rit)
        ];
        $rit->delete();
        return SuccessResource::make($return);
    }

    public function approve_finance(Rit $rit)
    {
        $rit->update([
            'finance_approved' => 1,
            'delivery_date' => Carbon::now()
        ]);
        $trip = Trip::find($rit->trip_id);
        $trip->update([
            "finance_approved" => 1
        ]);
        $vehicle = Vehicle::find($trip->vehicle_id);
        $vehicle->update([
            "toll" => $vehicle->toll + $trip->toll
        ]);
        if ($trip->gas > 0) {
            $vehicle->update([
                "trip_count" => 1,
            ]);
        } else {
            $vehicle->update([
                "trip_count" => $vehicle->trip_count + 1,
            ]);
        }
        Expense::create([
            "amount" => $trip->allowance + $trip->toll + $trip->gas,
            "note" => "Pengambilan Rit " . $rit->item->code,
            "time" => Carbon::now(),
            "type" => "Kendaraan",
            "trip_id" => $trip->id
        ]);
        if ($rit->customer_tonnage > 0) {
            $transaction = Transaction::create([
                "daily_id" => Transaction::whereDate('created_at', now()->toDateString())->get()->count() + 1,
                "owner_approved" => 0,
                "customer_id" => $rit->customer_id,
                "trip_id" => $trip->id,
                "type" => "Owner"
            ]);
        }
        $users = User::where("role_id", 1)->get();
        $emailArray = $users->pluck('email')->toArray();
        Mail::to($emailArray)->send(new NotificationMail("Barang Dalam Perjalanan", "Ada barang yang sedang dalam perjalanan. Pastikan sudah dimasukan jumlah tonase yang datang."));
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::make($rit)
        ];
        return SuccessResource::make($return);
    }

    public function reject_finance(Rit $rit)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::make($rit)
        ];
        $trip = Trip::find($rit->trip_id);
        $trip->delete();
        $rit->delete();
        return SuccessResource::make($return);
    }

    public function arrived(Request $request, Rit $rit)
    {
        $rit->update([
            'sack' => $request->sack,
            'arrival_date' => Carbon::now(),
            'arrived_tonnage' => $request->tonnage,
            'tonnage_left' => $request->tonnage,
        ]);
        if ($rit->customer_tonnage) {
            $users = User::where("role_id", 1)->get();
            $emailArray = $users->pluck('email')->toArray();
            Mail::to($emailArray)->send(new NotificationMail("Penjualan Customer", "Ada penjualan customer yang belum di input!"));
        }
        $trip = Trip::find($rit->trip_id);
        $trip->update([
            "toll_used" => $request->toll_used
        ]);
        $vehicle = Vehicle::find($trip->vehicle_id);
        $vehicle->update([
            "toll" => $vehicle->toll - $request->toll_used
        ]);
        $sack = Sack::create([
            "amount" => $request->sack,
            "rit_id" => $rit->id,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::make($rit)
        ];
        return SuccessResource::make($return);
    }

    public function priced(Request $request, Rit $rit)
    {
        $rit->update([
            "tonnage_left" => $request->tonnage,
            "sell_price" => $request->sell_price,
            "buy_price" => $request->buy_price,
            "is_hold" => $request->is_hold ? 1 : 0
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::make($rit)
        ];
        return SuccessResource::make($return);
    }

    public function transfer_to_branch(Request $request)
    {
        $trip = Trip::create([
            "allowance" => $request->allowance ?? 0,
            "toll" => $request->toll ?? 0,
            "gas" => $request->gas ?? 0,
            "note" => "Pengiriman ke " . $request->branch_name,
            "finance_approved" => 1,
            "vehicle_id" => $request->vehicle_id,
            "plate_number" => $request->plate_number
        ]);
        $vehicle = Vehicle::find($request->vehicle_id);
        $vehicle->update([
            "toll" => $vehicle->toll + $request->toll
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

        Expense::create([
            "amount" => $request->allowance + $request->toll + $request->gas,
            "note" => "Pengiriman ke " . $request->branch_name,
            "time" => Carbon::now(),
            "type" => "Kendaraan",
            "trip_id" => $trip->id
        ]);

        foreach ($request->rits as $key => $rit) {
            RitBranch::create([
                "name" => $request->branch_name,
                "address" => $request->branch_address,
                "sent_tonnage" => $rit["amount"],
                "delivery_date" => Carbon::now(),
                "rit_id" => $rit["id"],
                "trip_id" => $trip->id,
            ]);
            $rite = Rit::find($rit["id"]);
            $rite->update([
                "branch_tonnage" => $rite->branch_tonnage ? $rite->branch_tonnage + $rit["amount"] : $rit["amount"],
                "tonnage_left" => $rite->tonnage_left - $rit["amount"],
                "sold_date" => $rite->tonnage_left == $rit["amount"] ? Carbon::now() : $rite->sold_date
            ]);
            if ($rite->sold_date) {
                $users = User::where("role_id", 1)->get();
                $emailArray = $users->pluck('email')->toArray();
                Mail::to($emailArray)->send(new NotificationMail("Barang Cabang", "Ada barang cabang yang belum terjual!"));
            }
        }
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => TripResource::make($trip)
        ];
        return SuccessResource::make($return);
    }

    public function return(Request $request, Rit $rit)
    {
        $trip = Trip::create([
            "allowance" => $request->allowance,
            "toll" => $request->toll,
            "gas" => $request->gas,
            "note" => "Retur Rit " . $rit->item->code,
            "finance_approved" => 1,
            "vehicle_id" => $request->vehicle_id,
        ]);
        $vehicle = Vehicle::find($trip->vehicle_id);
        $vehicle->update([
            "toll" => $vehicle->toll + $request->toll
        ]);
        if ($trip->gas > 0) {
            $vehicle->update([
                "trip_count" => 1,
            ]);
        } else {
            $vehicle->update([
                "trip_count" => $vehicle->trip_count + 1,
            ]);
        }

        Expense::create([
            "amount" => $request->allowance + $request->toll + $request->gas,
            "note" => "Retur Rit " . $rit->item->code,
            "time" => Carbon::now(),
            "type" => "Kendaraan",
            "trip_id" => $trip->id
        ]);

        $rit->update([
            'retur_tonnage' => $request->tonnage,
            'tonnage_left' => $rit->tonnage_left - $request->tonnage,
            'retur_trip_id' => $trip->id
        ]);

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::make($rit)
        ];
        return SuccessResource::make($return);
    }
    public function transfer_from_branch(Request $request, Rit $rit)
    {
        $rit->update([
            "branch_tonnage" => $rit->branch_tonnage - $request->tonnage,
            "tonnage_left" => $request->tonnage + $rit->tonnage_left,
            "sold_date" => $rit->sold_date ? null : $rit->sold_date,
            "is_hold" => $rit->sold_date ? 1 : $rit->is_hold,
        ]);
        $amount = $request->tonnage;
        foreach ($rit->branches as $key => $ritBranch) {
            $original_tonnage = $ritBranch->sent_tonnage;
            $ritBranch->update([
                "sent_tonnage" => $ritBranch->sent_tonnage < $amount ? 0 : $ritBranch->sent_tonnage - $amount
            ]);
            if ($amount < $original_tonnage) {
                $amount = 0;
            } else {
                $amount -= $original_tonnage;
            }
        }
        $trip = Trip::create([
            "note" => "Pengiriman ke Pusat dari Cabang",
            "finance_approved" => 1,
            "vehicle_id" => $request->vehicle_id,
        ]);
        $vehicle = Vehicle::find($trip->vehicle_id);
        $vehicle->update([
            "trip_count" => $vehicle->trip_count + 1,
        ]);

        Expense::create([
            "amount" => 0,
            "note" => "Pengiriman ke Pusat dari Cabang",
            "time" => Carbon::now(),
            "type" => "Kendaraan",
            "trip_id" => $trip->id
        ]);

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::make($rit)
        ];
        return SuccessResource::make($return);
    }
}
