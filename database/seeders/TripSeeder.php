<?php

namespace Database\Seeders;

use App\Models\Trip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new Trip();
        $data->allowance = 10000;
        $data->toll = 10000;
        $data->gas = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        // $data->toll_used = "";
        // $data->branch_to_main_tonnage = "";
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();

        $data = new Trip();
        $data->allowance = 10000;
        // $data->toll = 10000;
        // $data->gas = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        // $data->toll_used = "";
        // $data->branch_to_main_tonnage = "";
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();

        $data = new Trip();
        $data->allowance = 10000;
        // $data->toll = 10000;
        // $data->gas = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->toll_used = 1000;
        // $data->branch_to_main_tonnage = "";
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();

        $data = new Trip();
        $data->allowance = 10000;
        // $data->toll = 10000;
        // $data->gas = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        // $data->toll_used = "";
        // $data->branch_to_main_tonnage = "";
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();

        $data = new Trip();
        $data->allowance = 10000;
        // $data->toll = 10000;
        // $data->gas = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->toll_used = 1000;
        // $data->branch_to_main_tonnage = "";
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();

        $data = new Trip();
        $data->allowance = 10000;
        // $data->toll = 10000;
        // $data->gas = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->toll_used = 1000;
        // $data->branch_to_main_tonnage = "";
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();

        $data = new Trip();
        $data->allowance = 10000;
        // $data->toll = 10000;
        // $data->gas = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->toll_used = 1000;
        // $data->branch_to_main_tonnage = "";
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();

        $data = new Trip();
        $data->allowance = 10000;
        // $data->toll = 10000;
        // $data->gas = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->toll_used = 1000;
        // $data->branch_to_main_tonnage = "";
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();

        $data = new Trip();
        $data->allowance = 10000;
        // $data->toll = 10000;
        // $data->gas = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->toll_used = 1000;
        // $data->branch_to_main_tonnage = "";
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();

        $data = new Trip();
        $data->allowance = 10000;
        // $data->toll = 10000;
        // $data->gas = 10000;
        $data->note = "Retur Rit K-ABC";
        $data->toll_used = 1000;
        $data->branch_to_main_tonnage = 6980;
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();

        $data = new Trip();
        $data->allowance = 10000;
        // $data->toll = 10000;
        // $data->gas = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->toll_used = 1000;
        // $data->branch_to_main_tonnage = "";
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();

        $data = new Trip();
        $data->allowance = 10000;
        // $data->toll = 10000;
        // $data->gas = 10000;
        $data->note = "Penjualan ke Supaijo";
        $data->toll_used = 1000;
        // $data->branch_to_main_tonnage = "";
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();

        $data = new Trip();
        $data->allowance = 10000;
        // $data->toll = 10000;
        // $data->gas = 10000;
        $data->note = "Penjualan ke Supaijo";
        $data->toll_used = 1000;
        // $data->branch_to_main_tonnage = "";
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();

        $data = new Trip();
        $data->allowance = 10000;
        // $data->toll = 10000;
        // $data->gas = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->toll_used = 1000;
        // $data->branch_to_main_tonnage = "";
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();

        $data = new Trip();
        $data->allowance = 10000;
        // $data->toll = 10000;
        // $data->gas = 10000;
        $data->note = "Penjualan ke Supaijo";
        $data->toll_used = 1000;
        // $data->branch_to_main_tonnage = "";
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();

        $data = new Trip();
        $data->allowance = 10000;
        // $data->toll = 10000;
        // $data->gas = 10000;
        $data->note = "Pengiriman ke Cabang A";
        $data->toll_used = 1000;
        // $data->branch_to_main_tonnage = "";
        $data->finance_approved = 1;
        $data->vehicle_id = 1;
        $data->save();
    }
}
