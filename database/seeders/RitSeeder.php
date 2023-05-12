<?php

namespace Database\Seeders;

use App\Models\Rit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Belum di approve finance
        $data = new Rit();
        $data->do_code = "Importir ABC";
        $data->expected_tonnage = 7000;
        $data->customer_tonnage = 2000;
        $data->branch_tonnage = 200;
        $data->main_tonnage = 4800;
        // $data->retur_tonnage = "";
        // $data->arrived_tonnage = "";
        // $data->tonnage_left = "";
        // $data->delivery_date = "";
        // $data->arrival_date = "";
        // $data->sold_date = "";
        // $data->sell_price = "";
        // $data->buy_price = "";
        $data->sack = 100;
        // $data->finance_approved = "";
        // $data->is_hold = "";
        $data->item_id = 1;
        $data->trip_id = 1;
        // $data->retur_trip_id = "";
        $data->customer_id = 1;
        $data->save();

        //Masih otw
        $data = new Rit();
        $data->do_code = "Importir ABC";
        $data->expected_tonnage = 7000;
        $data->customer_tonnage = 2000;
        $data->branch_tonnage = 200;
        $data->main_tonnage = 4800;
        // $data->retur_tonnage = "";
        // $data->arrived_tonnage = "";
        // $data->tonnage_left = "";
        $data->delivery_date = "2022-12-30";
        // $data->arrival_date = "";
        // $data->sold_date = "";
        // $data->sell_price = "";
        // $data->buy_price = "";
        $data->sack = 100;
        $data->finance_approved = 1;
        // $data->is_hold = "";
        $data->item_id = 1;
        $data->trip_id = 2;
        // $data->retur_trip_id = "";
        $data->customer_id = 1;
        $data->save();

        //Sampe - pusat, customer, branch - belum ada harga
        $data = new Rit();
        $data->do_code = "Importir ABC";
        $data->expected_tonnage = 7000;
        $data->customer_tonnage = 2000;
        $data->branch_tonnage = 200;
        $data->main_tonnage = 4800;
        // $data->retur_tonnage = "";
        $data->arrived_tonnage = 4780;
        $data->tonnage_left = 4780;
        $data->delivery_date = "2022-12-30";
        $data->arrival_date = "2023-01-01";
        // $data->sold_date = "";
        // $data->sell_price = "";
        // $data->buy_price = "";
        $data->sack = 100;
        $data->finance_approved = 1;
        // $data->is_hold = "";
        $data->item_id = 1;
        $data->trip_id = 3;
        // $data->retur_trip_id = "";
        $data->customer_id = 1;
        $data->save();

        //Sampe - pusat, customer, branch
        $data = new Rit();
        $data->do_code = "Importir ABC";
        $data->expected_tonnage = 7000;
        $data->customer_tonnage = 2000;
        $data->branch_tonnage = 200;
        $data->main_tonnage = 4800;
        // $data->retur_tonnage = "";
        $data->arrived_tonnage = 4780;
        $data->tonnage_left = 4780;
        $data->delivery_date = "2022-12-30";
        $data->arrival_date = "2023-01-01";
        // $data->sold_date = "";
        $data->sell_price = 1000;
        $data->buy_price = 980;
        $data->sack = 100;
        $data->finance_approved = 1;
        // $data->is_hold = "";
        $data->item_id = 1;
        $data->trip_id = 4;
        // $data->retur_trip_id = "";
        $data->customer_id = 1;
        $data->save();

        //Sampe - pusat, customer
        $data = new Rit();
        $data->do_code = "Importir ABC";
        $data->expected_tonnage = 7000;
        $data->customer_tonnage = 2000;
        // $data->branch_tonnage = 200;
        $data->main_tonnage = 5000;
        // $data->retur_tonnage = "";
        $data->arrived_tonnage = 4980;
        $data->tonnage_left = 4980;
        $data->delivery_date = "2022-12-30";
        $data->arrival_date = "2023-01-01";
        // $data->sold_date = "";
        $data->sell_price = 2000;
        $data->buy_price = 1980;
        $data->sack = 100;
        $data->finance_approved = 1;
        $data->customer_tonnage_sold = 1;
        // $data->is_hold = "";
        $data->item_id = 1;
        $data->trip_id = 5;
        // $data->retur_trip_id = "";
        $data->customer_id = 1;
        $data->save();

        //Sampe - pusat, branch
        $data = new Rit();
        $data->do_code = "Importir ABC";
        $data->expected_tonnage = 7000;
        // $data->customer_tonnage = 2000;
        $data->branch_tonnage = 200;
        $data->main_tonnage = 6800;
        // $data->retur_tonnage = "";
        $data->arrived_tonnage = 6780;
        $data->tonnage_left = 6780;
        $data->delivery_date = "2022-12-30";
        $data->arrival_date = "2023-01-01";
        // $data->sold_date = "";
        $data->sell_price = 3000;
        $data->buy_price = 1980;
        $data->sack = 100;
        $data->finance_approved = 1;
        // $data->is_hold = "";
        $data->item_id = 1;
        $data->trip_id = 6;
        // $data->retur_trip_id = "";
        $data->save();

        //Sampe - pusat
        $data = new Rit();
        $data->do_code = "Importir ABC";
        $data->expected_tonnage = 7000;
        // $data->customer_tonnage = 2000;
        // $data->branch_tonnage = 200;
        $data->main_tonnage = 7000;
        // $data->retur_tonnage = "";
        $data->arrived_tonnage = 6980;
        $data->tonnage_left = 6880;
        $data->delivery_date = "2022-12-30";
        $data->arrival_date = "2023-01-01";
        // $data->sold_date = "";
        $data->sell_price = 4000;
        $data->buy_price = 1980;
        $data->sack = 100;
        $data->finance_approved = 1;
        // $data->is_hold = "";
        $data->item_id = 2;
        $data->trip_id = 7;
        // $data->retur_trip_id = "";
        $data->save();

        //Sampe - pusat - habis
        $data = new Rit();
        $data->do_code = "Importir ABC";
        $data->expected_tonnage = 7000;
        // $data->customer_tonnage = 2000;
        // $data->branch_tonnage = 200;
        $data->main_tonnage = 7000;
        // $data->retur_tonnage = "";
        $data->arrived_tonnage = 6980;
        $data->tonnage_left = 0;
        $data->delivery_date = "2022-12-30";
        $data->arrival_date = "2023-01-01";
        $data->sold_date = "2023-01-02";
        $data->sell_price = 5000;
        $data->buy_price = 1980;
        $data->sack = 100;
        $data->finance_approved = 1;
        // $data->is_hold = "";
        $data->item_id = 1;
        $data->trip_id = 8;
        // $data->retur_trip_id = "";
        $data->save();

        //Sampe - diretur
        $data = new Rit();
        $data->do_code = "Importir ABC";
        $data->expected_tonnage = 7000;
        // $data->customer_tonnage = 2000;
        // $data->branch_tonnage = 200;
        $data->main_tonnage = 7000;
        $data->retur_tonnage = 6980;
        $data->arrived_tonnage = 6980;
        $data->tonnage_left = 6980;
        $data->delivery_date = "2022-12-30";
        $data->arrival_date = "2023-01-01";
        // $data->sold_date = "";
        $data->sell_price = 6000;
        $data->buy_price = 1980;
        $data->sack = 100;
        $data->finance_approved = 1;
        // $data->is_hold = "";
        $data->item_id = 1;
        $data->trip_id = 9;
        $data->retur_trip_id = 10;
        $data->save();

        //Sampe - pusat - di hold
        $data = new Rit();
        $data->do_code = "Importir ABC";
        $data->expected_tonnage = 7000;
        // $data->customer_tonnage = 2000;
        // $data->branch_tonnage = 200;
        $data->main_tonnage = 7000;
        // $data->retur_tonnage = "";
        $data->arrived_tonnage = 6980;
        $data->tonnage_left = 6980;
        $data->delivery_date = "2022-12-30";
        $data->arrival_date = "2023-01-01";
        // $data->sold_date = "";
        $data->sell_price = 7000;
        $data->buy_price = 1980;
        $data->sack = 100;
        $data->finance_approved = 1;
        $data->is_hold = 1;
        $data->item_id = 1;
        $data->trip_id = 11;
        // $data->retur_trip_id = "";
        $data->save();
    }
}
