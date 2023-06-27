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
        $role->nik = "000000000000000";
        $role->name = "Amin";
        $role->nickname = "AMIN COMONG";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "000000000000";
        $role->birthdate = "1971-10-14";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 9;
        $role->tonnage = 400;
        $role->save();

        $role = new Customer();
        $role->nik = "3515144710740002";
        $role->name = "Iin Sugiarini";
        $role->nickname = "IIN SAIMBANG";
        $role->address = "Saimbang RT 14/ RW 04, Kebon Agung - Sukodono";
        $role->phone = "08123123123";
        $role->ongkir = 100000;
        $role->birthdate = "1974-10-07";
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 6;
        $role->tonnage = 12000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326171506900002";
        $role->name = "Muhammad Roni";
        $role->nickname = "RONI";
        $role->address = "Dk. Saren RT 02/ RW 06, Blimbing Wuluh- Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1990-06-15";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 980000;
        $role->cashback_days = 26;
        $role->tonnage = 1104;
        $role->save();
    }
}
