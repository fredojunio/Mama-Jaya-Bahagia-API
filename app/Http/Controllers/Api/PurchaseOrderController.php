<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PurchaseOrder;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $pos = PurchaseOrder::with(['item', 'grabs.rit.trip.vehicle'])->orderBy('created_at', 'desc')->get();

        foreach ($pos as $po) {
            $po->rits_sum_expected_tonnage = $po->grabs->sum(function($grab) {
                return $grab->rit ? $grab->rit->expected_tonnage : 0;
            });
        }

        return response()->json([
            'status' => 'success',
            'data' => $pos
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'tonnage' => 'required|numeric|min:1',
            'buy_price' => 'required|numeric|min:0',
        ]);

        $po = PurchaseOrder::create([
            'po_code' => 'PO-' . time(),
            'item_id' => $request->item_id,
            'tonnage' => $request->tonnage,
            'buy_price' => $request->buy_price,
            'status' => 'pending'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Purchase Order created',
            'data' => $po
        ]);
    }

    public function update(Request $request, PurchaseOrder $purchase_order)
    {
        $request->validate([
            'tonnage' => 'required|numeric|min:1',
            'buy_price' => 'required|numeric|min:0',
        ]);

        $purchase_order->update([
            'tonnage' => $request->tonnage,
            'buy_price' => $request->buy_price,
        ]);

        // Check if it should be completed
        $totalFulfilled = $purchase_order->grabs->sum(function($grab) {
            return $grab->rit ? $grab->rit->expected_tonnage : 0;
        });
        
        if ($totalFulfilled >= $purchase_order->tonnage && $purchase_order->status == 'pending') {
            $purchase_order->update(['status' => 'completed']);
        } elseif ($totalFulfilled < $purchase_order->tonnage && $purchase_order->status == 'completed') {
            $purchase_order->update(['status' => 'pending']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Purchase Order updated',
            'data' => $purchase_order
        ]);
    }

    public function ambil(Request $request, PurchaseOrder $purchase_order)
    {
        $request->validate([
            'vehicle_id' => 'required',
            'do_code' => 'required|string',
            'expected_tonnage' => 'required|numeric|min:1',
            'delivery_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $customer = null;
        if ($request->send_to_customer) {
            $customer = \App\Models\Customer::find($request->customer_id);
        }

        $trip = \App\Models\Trip::create([
            "allowance" => $request->allowance ?? 0,
            "toll" => $request->toll ?? 0,
            "gas" => $request->gas ?? 0,
            "note" => "Pengambilan Rit PO " . $purchase_order->po_code,
            "vehicle_id" => $request->vehicle_id,
            "finance_approved" => 1
        ]);

        $vehicle = \App\Models\Vehicle::find($trip->vehicle_id);
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

        \App\Models\Expense::create([
            "amount" => $trip->allowance + $trip->toll + $trip->gas,
            "note" => "Pengambilan Rit PO " . $purchase_order->po_code,
            "time" => \Carbon\Carbon::now(),
            "type" => "Kendaraan",
            "trip_id" => $trip->id
        ]);

        $rit = \App\Models\Rit::create([
            "do_code" => $request->do_code,
            "expected_tonnage" => $request->expected_tonnage,
            "customer_tonnage" => $request->send_to_customer ? $request->customer['tonnage'] : null,
            "main_tonnage" => $request->expected_tonnage,
            "item_id" => $purchase_order->item_id,
            "trip_id" => $trip->id,
            "customer_id" => $request->send_to_customer ? $request->customer_id : null,
            "finance_approved" => 1,
            "delivery_date" => $request->delivery_date,
            "buy_price" => $purchase_order->buy_price,
            "tonnage_left" => 0,
            "is_hold" => 0
        ]);

        \App\Models\RitHistory::create([
            "info" => "Buat rit dari PO Ambil. ID: " . $rit->id,
            "rit_id" => $rit->id
        ]);

        if ($rit->customer_tonnage > 0) {
            \App\Models\Transaction::create([
                "daily_id" => \App\Models\Transaction::whereDate('created_at', now()->toDateString())->where('daily_id', '>=', 90000)->get()->count() + 90000,
                "owner_approved" => 0,
                "customer_id" => $rit->customer_id,
                "trip_id" => $trip->id,
                "type" => "Owner"
            ]);
        }

        \App\Models\PurchaseOrderGrab::create([
            'purchase_order_id' => $purchase_order->id,
            'rit_id' => $rit->id,
            'description' => $request->description
        ]);

        $totalFulfilled = $purchase_order->grabs->sum(function($grab) {
            return $grab->rit ? $grab->rit->expected_tonnage : 0;
        });

        if ($totalFulfilled >= $purchase_order->tonnage && $purchase_order->status == 'pending') {
            $purchase_order->update(['status' => 'completed']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Rit created from Purchase Order and Grab registered',
            'data' => $rit
        ]);
    }

    public function updateGrab(Request $request, $id)
    {
        $grab = \App\Models\PurchaseOrderGrab::findOrFail($id);

        $request->validate([
            'delivery_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        if ($grab->rit) {
            $grab->rit->update([
                'delivery_date' => $request->delivery_date
            ]);
        }

        $grab->update([
            'description' => $request->description
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Grab updated successfully',
            'data' => $grab->load('rit')
        ]);
    }
}
