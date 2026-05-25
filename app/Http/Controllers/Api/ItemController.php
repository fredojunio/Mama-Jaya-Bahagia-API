<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessResource;
use App\Models\Item;
use App\Models\Rit;
use App\Models\RitHistory;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => $items
        ];
        return SuccessResource::make($return);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $item = Item::create([
            'code' => $request->code,
            'brand' => $request->brand,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => $item
        ];
        return SuccessResource::make($return);
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => $item
        ];
        return SuccessResource::make($return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $item->update([
            'code' => $request->code,
            'brand' => $request->brand,
        ]);
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => $item
        ];
        return SuccessResource::make($return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses Terhapus.',
            'api_results' => $item
        ];
        $item->delete();
        return SuccessResource::make($return);
    }

    public function update_rit_prices(Request $request, Item $item)
    {
        $itemIds = Item::where('code', $item->code)->pluck('id');
        $rits = Rit::whereIn('item_id', $itemIds)->whereNull('sold_date')->get();

        foreach ($rits as $rit) {
            $rit->update([
                'sell_price' => $request->sell_price
            ]);
            // RitHistory::create([
            //     "info" => "Harga jual diupdate secara masal dari item code. Harga Jual baru: {$request->sell_price}",
            //     "rit_id" => $rit->id
            // ]);
        }

        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => true
        ];
        return SuccessResource::make($return);
    }
}
