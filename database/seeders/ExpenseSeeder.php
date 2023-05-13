<?php

namespace Database\Seeders;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new Expense();
        $data->amount = 12000;
        $data->note = "Pembelian Pulpen";
        // $data->name = "";
        $data->time = Carbon::now();
        $data->type = "Operasional";
        $data->save();

        $data = new Expense();
        $data->amount = 12000;
        $data->note = "Gaji Hari Pertama";
        $data->name = "Andi";
        $data->time = Carbon::now();
        $data->type = "Gaji";
        $data->save();

        $data = new Expense();
        $data->amount = 2000;
        $data->note = "Penarikan TB";
        $data->name = "Supaijo";
        $data->time = Carbon::now();
        $data->type = "TB";
        $data->save();

        $data = new Expense();
        $data->amount = 1000;
        $data->note = "Penarikan TW";
        $data->name = "Supaijo";
        $data->time = Carbon::now();
        $data->type = "TW";
        $data->save();

        $data = new Expense();
        $data->amount = 3000;
        $data->note = "Penarikan THR";
        $data->name = "Tukimin";
        $data->time = Carbon::now();
        $data->type = "THR";
        $data->save();

        $data = new Expense();
        $data->amount = 30000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->type = "Kendaraan";
        $data->trip_id = 1;
        $data->save();

        $data = new Expense();
        $data->amount = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->type = "Kendaraan";
        $data->trip_id = 2;
        $data->save();

        $data = new Expense();
        $data->amount = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->type = "Kendaraan";
        $data->trip_id = 3;
        $data->save();

        $data = new Expense();
        $data->amount = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->type = "Kendaraan";
        $data->trip_id = 4;
        $data->save();

        $data = new Expense();
        $data->amount = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->type = "Kendaraan";
        $data->trip_id = 5;
        $data->save();

        $data = new Expense();
        $data->amount = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->type = "Kendaraan";
        $data->trip_id = 6;
        $data->save();

        $data = new Expense();
        $data->amount = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->type = "Kendaraan";
        $data->trip_id = 7;
        $data->save();

        $data = new Expense();
        $data->amount = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->type = "Kendaraan";
        $data->trip_id = 8;
        $data->save();

        $data = new Expense();
        $data->amount = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->type = "Kendaraan";
        $data->trip_id = 9;
        $data->save();

        $data = new Expense();
        $data->amount = 10000;
        $data->note = "Retur Rit K-ABC";
        $data->type = "Kendaraan";
        $data->trip_id = 10;
        $data->save();

        $data = new Expense();
        $data->amount = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->type = "Kendaraan";
        $data->trip_id = 11;
        $data->save();

        $data = new Expense();
        $data->amount = 10000;
        $data->note = "Penjualan ke Supaijo";
        $data->type = "Kendaraan";
        $data->trip_id = 12;
        $data->save();

        $data = new Expense();
        $data->amount = 10000;
        $data->note = "Penjualan ke Supaijo";
        $data->type = "Kendaraan";
        $data->trip_id = 13;
        $data->save();

        $data = new Expense();
        $data->amount = 10000;
        $data->note = "Pengambilan Rit K-ABC";
        $data->type = "Kendaraan";
        $data->trip_id = 14;
        $data->save();

        $data = new Expense();
        $data->amount = 10000;
        $data->note = "Penjualan ke Supaijo";
        $data->type = "Kendaraan";
        $data->trip_id = 15;
        $data->save();

        $data = new Expense();
        $data->amount = 10000;
        $data->note = "Pengiriman ke Cabang A";
        $data->type = "Kendaraan";
        $data->trip_id = 16;
        $data->save();
    }
}
