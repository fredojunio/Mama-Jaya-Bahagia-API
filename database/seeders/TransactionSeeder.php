<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Belum di approve finance
        $data = new Transaction();
        $data->daily_id = 1;
        $data->tb = 2000;
        $data->tw = 2000;
        $data->thr = 2000;
        $data->sack = 2;
        $data->sack_price = 0;
        $data->item_price = 2000000;
        $data->discount = 0;
        $data->ongkir = 2000;
        $data->total_price = 2008000;
        // $data->settled_date = "";
        // $data->owner_approved = "";
        // $data->finance_approved = "";
        $data->customer_id = 3;
        $data->trip_id = 12;
        $data->save();

        //Udah di approve finance untuk jalan
        $data = new Transaction();
        $data->daily_id = 2;
        $data->tb = 2000;
        $data->tw = 2000;
        $data->thr = 2000;
        $data->sack = 2;
        $data->sack_price = 0;
        $data->item_price = 4000000;
        $data->discount = 0;
        $data->ongkir = 2000;
        $data->total_price = 4008000;
        // $data->settled_date = "";
        // $data->owner_approved = "";
        $data->finance_approved = 1;
        $data->customer_id = 3;
        $data->trip_id = 13;
        $data->save();

        //Udah di approve finance LUNAS
        $data = new Transaction();
        $data->daily_id = 3;
        $data->tb = 2000;
        $data->tw = 2000;
        $data->thr = 2000;
        $data->sack = 2;
        $data->sack_price = 0;
        $data->item_price = 5480000;
        $data->discount = 0;
        $data->ongkir = 2000;
        $data->total_price = 5488000;
        $data->settled_date = "2022-01-02";
        // $data->owner_approved = "";
        $data->finance_approved = 1;
        $data->customer_id = 3;
        $data->trip_id = 14;
        $data->save();

        //Udah di approve finance dan owner - ini kiriman
        $data = new Transaction();
        $data->daily_id = 4;
        $data->tb = 2000;
        $data->tw = 2000;
        $data->thr = 2000;
        $data->sack = 2;
        $data->sack_price = 0;
        $data->item_price = 5480000;
        $data->discount = 0;
        $data->ongkir = 2000;
        $data->total_price = 5488000;
        $data->settled_date = "2022-01-02";
        $data->owner_approved = 1;
        $data->finance_approved = 1;
        $data->customer_id = 2;
        $data->trip_id = 15;
        $data->save();

        //Kiriman langsung ke customer owner - udah di masukin sama owner
        $data = new Transaction();
        $data->daily_id = 7;
        // $data->tb = 2000;
        // $data->tw = 2000;
        // $data->thr = 2000;
        // $data->sack = 2;
        // $data->sack_price = 0;
        // $data->item_price = 2000000;
        // $data->discount = 0;
        $data->ongkir = 2000;
        $data->total_price = 4000000;
        // $data->settled_date = "2022-01-02";
        $data->owner_approved = 1;
        $data->finance_approved = 1;
        $data->customer_id = 2;
        $data->trip_id = 5;
        $data->save();
    }
}
