<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CasDepositSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cas_deposits')->insert([
            "koin" => 0,
            "seribu" => 0,
            "duaribu" => 0,
            "limaribu" => 0,
            "sepuluhribu" => 0,
            "duapuluhribu" => 0,
        ]);
    }
}
