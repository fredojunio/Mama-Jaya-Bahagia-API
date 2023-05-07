<?php

namespace Database\Seeders;

use App\Models\RitTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RitTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new RitTransaction();
        $data->daily_id = 1;
        $data->customer_name = "Tukimin";
        $data->tonnage = 1000;
        $data->masak = 1;
        $data->item_price = 2000;
        $data->total_price = 2000000;
        $data->tonnage_left = 5980;
        $data->rit_id = 8;
        $data->transaction_id = 1;
        $data->save();

        $data = new RitTransaction();
        $data->daily_id = 2;
        $data->customer_name = "Tukimin";
        $data->tonnage = 500;
        $data->masak = 2;
        $data->item_price = 2000;
        $data->total_price = 2000000;
        $data->tonnage_left = 5480;
        $data->rit_id = 8;
        $data->transaction_id = 2;
        $data->save();

        $data = new RitTransaction();
        $data->daily_id = 2;
        $data->customer_name = "Tukimin";
        $data->tonnage = 100;
        $data->masak = 20;
        $data->item_price = 2000;
        $data->total_price = 2000000;
        $data->tonnage_left = 6880;
        $data->rit_id = 7;
        $data->transaction_id = 2;
        $data->save();

        $data = new RitTransaction();
        $data->daily_id = 3;
        $data->customer_name = "Tukimin";
        $data->tonnage = 2740;
        $data->masak = 1;
        $data->item_price = 2000;
        $data->total_price = 5480000;
        $data->tonnage_left = 0;
        $data->rit_id = 8;
        $data->transaction_id = 3;
        $data->save();

        $data = new RitTransaction();
        $data->daily_id = 4;
        $data->customer_name = "Supaijo";
        $data->tonnage = 2740;
        $data->masak = 1;
        $data->item_price = 2000;
        $data->total_price = 5480000;
        $data->tonnage_left = 0;
        $data->rit_id = 8;
        $data->transaction_id = 4;
        $data->save();

        //langsung ke customer
        $data = new RitTransaction();
        $data->daily_id = 5;
        $data->customer_name = "Supaijo";
        $data->tonnage = 2000;
        $data->masak = 1;
        $data->item_price = 2000;
        $data->total_price = 4000000;
        // $data->tonnage_left = 0;
        $data->rit_id = 5;
        $data->transaction_id = 5;
        $data->save();
    }
}
