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
        $role->birthdate = "21/03/1980";
        $role->type = "Owner";
        $role->save();

        $role = new Customer();
        $role->nik = "2222222222222";
        $role->name = "Supaijo";
        $role->nickname = "Paijo";
        $role->address = "Jl. Mawar 124";
        $role->ongkir = 2000;
        $role->birthdate = "21/03/1980";
        $role->type = "Kiriman";
        $role->save();

        $role = new Customer();
        $role->nik = "33333333333333";
        $role->name = "Tukimin";
        $role->nickname = "Kimin";
        $role->address = "Jl. Mawar 231";
        $role->ongkir = 0;
        $role->birthdate = "21/03/1980";
        $role->type = "Eceran";
        $role->save();
    }
}
