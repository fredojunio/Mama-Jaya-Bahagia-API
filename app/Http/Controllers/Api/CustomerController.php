<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\SuccessResource;
use App\Models\Customer;
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
            'api_results' => CustomerResource::make($customer)
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
}