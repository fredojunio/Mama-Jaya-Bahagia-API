<?php

namespace Database\Seeders;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RealSeeder_2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = new Customer();
        $role->nik = "xxxxxxxxxxxxxxxx";
        $role->name = "Desuki";
        $role->nickname = "DESUKI";
        $role->address = "xxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = Carbon::now();
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 3784000;
        $role->cashback_days = 19;
        $role->tonnage = 608;
        $role->save();

        $role = new Customer();
        $role->nik = "xxxxxxxxxxxxxxxx";
        $role->name = "Herman";
        $role->nickname = "HERMAN";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx ";
        $role->phone = "08123123123";
        $role->birthdate = Carbon::now();
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 580000;
        $role->cashback_days = 12;
        $role->tonnage = 600;
        $role->save();

        $role = new Customer();
        $role->nik = "xxxxxxxxxxxxxxxx";
        $role->name = "Imron";
        $role->nickname = "IMRON";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = Carbon::now();
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 385000;
        $role->cashback_days = 3;
        $role->tonnage = 65;
        $role->save();

        $role = new Customer();
        $role->nik = "xxxxxxxxxxxxxxxx";
        $role->name = "ABD. Latif";
        $role->nickname = "ABD LATIF";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = Carbon::now();
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 350000;
        $role->cashback_days = 2;
        $role->tonnage = 100;
        $role->save();

        $role = new Customer();
        $role->nik = "xxxxxxxxxxxxxxxx";
        $role->name = "Sodikan";
        $role->nickname = "SODIKAN";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = Carbon::now();
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 80000;
        $role->cashback_days = 6;
        $role->tonnage = 176;
        $role->save();
    }
}
