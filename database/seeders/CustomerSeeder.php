<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = new Customer();
        $role->nik = "11111111111111";
        $role->name = "Supardi";
        $role->nickname = "Pardi";
        $role->address = "Jl. Mawar 123";
        $role->ongkir = 24000;
        $role->birthdate = "2022-12-30";
        $role->type = "Owner";
        $role->save();

        $role = new Customer();
        $role->nik = "2222222222222";
        $role->name = "Supaijo";
        $role->nickname = "Paijo";
        $role->address = "Jl. Mawar 124";
        $role->ongkir = 2000;
        $role->birthdate = "2022-12-30";
        $role->type = "Kiriman";
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "33333333333333";
        $role->name = "Tukimin";
        $role->nickname = "Kimin";
        $role->address = "Jl. Mawar 231";
        $role->ongkir = 500;
        $role->birthdate = "2022-12-30";
        $role->type = "Eceran";
        $role->tb = 6000;
        $role->tw = 6000;
        $role->thr = 3000;
        $role->save();
    }
}
