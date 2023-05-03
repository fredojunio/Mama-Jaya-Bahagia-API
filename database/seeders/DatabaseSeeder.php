<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserRoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(TripSeeder::class);
        $this->call(ExpenseSeeder::class);
        $this->call(RitSeeder::class);
        $this->call(TransactionSeeder::class);
        $this->call(RitTransactionSeeder::class);
        $this->call(RitBranchSeeder::class);
        $this->call(SavingSeeder::class);
    }
}
