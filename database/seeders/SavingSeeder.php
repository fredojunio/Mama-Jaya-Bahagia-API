<?php

namespace Database\Seeders;

use App\Models\Saving;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SavingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new Saving();
        $data->tb = 2000;
        $data->tw = 2000;
        $data->thr = 2000;
        $data->tonnage = 1000;
        $data->total_tb = 2000;
        $data->total_tw = 2000;
        $data->total_thr = 2000;
        $data->total_tonnage = 1000;
        $data->type = "Pemasukan";
        $data->customer_id = 3;
        $data->transaction_id = 1;
        $data->save();

        $data = new Saving();
        $data->tb = 2000;
        $data->tw = 2000;
        $data->thr = 2000;
        $data->tonnage = 600;
        $data->total_tb = 4000;
        $data->total_tw = 4000;
        $data->total_thr = 4000;
        $data->total_tonnage = 1600;
        $data->type = "Pemasukan";
        $data->customer_id = 3;
        $data->transaction_id = 2;
        $data->save();

        $data = new Saving();
        $data->tb = 2000;
        $data->tw = 2000;
        $data->thr = 2000;
        $data->tonnage = 2740;
        $data->total_tb = 6000;
        $data->total_tw = 6000;
        $data->total_thr = 6000;
        $data->total_tonnage = 4340;
        $data->type = "Pemasukan";
        $data->customer_id = 3;
        $data->transaction_id = 3;
        $data->save();

        $data = new Saving();
        $data->tb = 2000;
        $data->tw = 2000;
        $data->thr = 2000;
        $data->tonnage = 2470;
        $data->total_tb = 2000;
        $data->total_tw = 2000;
        $data->total_thr = 2000;
        $data->total_tonnage = 2470;
        $data->type = "Pemasukan";
        $data->customer_id = 2;
        $data->transaction_id = 4;
        $data->save();
    }
}
