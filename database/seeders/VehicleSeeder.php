<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = new Vehicle();
        $role->name = 'Truk A';
        $role->type_id = 1;
        $role->save();

        $role = new Vehicle();
        $role->name = 'Pickup A';
        $role->type_id = 2;
        $role->save();
    }
}
