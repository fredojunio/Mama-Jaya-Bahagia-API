<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RitResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\TripResource;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Item;
use App\Models\Rit;
use App\Models\RitBranch;
use App\Models\Trip;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
            "sack" => $request->sack,
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
        if ($trip->gas > 0) {
            $vehicle->update([
                "trip_count" => 1,
            ]);
        } else {
            $vehicle->update([
                "trip_count" => $vehicle->trip_count + 1,
            ]);
        }
        //NOTE - Expense
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => RitResource::make($rit)
        ];
        return SuccessResource::make($return);
    }

    public function arrived(Request $request, Rit $rit)
    {
        $rit->update([
            'arrival_date' => Carbon::now(),
            'arrived_tonnage' => $request->tonnage,
            'tonnage_left' => $request->tonnage,
        ]);
        $trip = Trip::find($rit->trip_id);
        $trip->update([
            "toll_used" => $request->toll_used
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
        //NOTE - ini mungkin perlu di pastiin langsung di approve finance atau ga
        $trip = Trip::create([
            "allowance" => $request->allowance,
            "toll" => $request->toll,
            "gas" => $request->gas,
            "note" => "Pengiriman ke " . $request->branch_name,
            "finance_approved" => 1,
            "vehicle_id" => $request->vehicle_id,
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
            "type" => "Kendaraan",
            "trip_id" => $trip->id
        ]);

        foreach ($request->rits as $key => $rit) {
            RitBranch::create([
                "name" => $request->branch_name,
                "sent_tonnage" => $rit["amount"],
                "delivery_date" => Carbon::now(),
                "rit_id" => $rit["id"],
                "trip_id" => $trip->id,
            ]);
            $rite = Rit::find($rit["id"]);
            $rite->update([
                "tonnage_left" => $rite->tonnage_left - $rit["amount"],
                "sold_date" => $rite->tonnage_left == $rit["amount"] ? Carbon::now() : $rite->sold_date
            ]);
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
}
