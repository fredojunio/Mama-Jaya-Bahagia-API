<?php

namespace Database\Seeders;

use App\Models\RitBranch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RitBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Sampe - belum kejual
        $data = new RitBranch();
        $data->name = "Cabang A";
        $data->sent_tonnage = 200;
        // $data->income = "";
        $data->delivery_date = "2022-12-30";
        $data->rit_id = 3;
        $data->trip_id = 3;
        $data->save();

        //Sampe - belum kejual
        $data = new RitBranch();
        $data->name = "Cabang A";
        $data->sent_tonnage = 100;
        // $data->income = "";
        $data->delivery_date = "2022-12-30";
        $data->rit_id = 4;
        $data->trip_id = 4;
        $data->save();

        //Sampe - belum kejual
        $data = new RitBranch();
        $data->name = "Cabang A";
        $data->sent_tonnage = 100;
        // $data->income = "";
        $data->delivery_date = "2022-12-30";
        $data->rit_id = 4;
        $data->trip_id = 16;
        $data->save();

        //Sampe - belum kejual
        $data = new RitBranch();
        $data->name = "Cabang A";
        $data->sent_tonnage = 200;
        // $data->income = "";
        $data->delivery_date = "2022-12-30";
        $data->rit_id = 6;
        $data->trip_id = 16;
        $data->save();
    }
}
