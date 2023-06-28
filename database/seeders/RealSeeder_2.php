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
        $role->nik = "3326191702830006";
        $role->name = "Slamet Waluyo";
        $role->nickname = "TIO WALUYO";
        $role->address = "Semut RT.03/RW.01, Wonokerto";
        $role->phone = "08123123123";
        $role->birthdate = "1983-02-17";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 1800000;
        $role->cashback_days = 26;
        $role->tonnage = 1500;
        $role->save();

        $role = new Customer();
        $role->nik = "3326193001750006";
        $role->name = "Edi Waluyo";
        $role->nickname = "WWALUYO";
        $role->address = "Dk. Keludan RT 02/ RW 01, Werdi- Wonokerto";
        $role->phone = "08123123123";
        $role->birthdate = "1975-01-30";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 1590000;
        $role->cashback_days = 24;
        $role->tonnage = 937;
        $role->save();
    }
}
