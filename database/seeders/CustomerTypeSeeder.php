<?php

namespace Database\Seeders;

use App\Models\CustomerType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = new CustomerType();
        $role->name = 'Owner';
        $role->save();

        $role = new CustomerType();
        $role->name = 'Kiriman';
        $role->save();

        $role = new CustomerType();
        $role->name = 'Eceran';
        $role->save();
    }
}
