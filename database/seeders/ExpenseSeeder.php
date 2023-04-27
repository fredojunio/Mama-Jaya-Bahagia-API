<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new Expense();
        $data->amount = 12000;
        $data->note = "Pembelian Pulpen";
        // $data->name = "";
        $data->time = "2022-12-30 13:32";
        $data->type = "Operasional";
        $data->save();

        $data = new Expense();
        $data->amount = 12000;
        $data->note = "Gaji Hari Pertama";
        $data->name = "Andi";
        $data->time = "2022-12-30";
        $data->type = "Gaji";
        $data->save();

        $data = new Expense();
        $data->amount = 12000;
        $data->note = "Penarikan TW";
        // $data->name = "Andi";
        $data->time = "2022-12-30";
        $data->type = "TW";
        $data->save();

        $data = new Expense();
        $data->amount = 12000;
        $data->note = "Penarikan TB";
        // $data->name = "Andi";
        $data->time = "2022-12-30";
        $data->type = "TB";
        $data->save();

        $data = new Expense();
        $data->amount = 12000;
        $data->note = "Penarikan THR";
        // $data->name = "Andi";
        $data->time = "2022-12-30";
        $data->type = "THR";
        $data->save();
    }
}
