<?php

namespace Database\Seeders;

use App\Models\Sack;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new Sack();
        $data->amount = 100;
        $data->rit_id = 1;
        $data->save();

        $data = new Sack();
        $data->amount = 100;
        $data->rit_id = 2;
        $data->save();

        $data = new Sack();
        $data->amount = 100;
        $data->rit_id = 3;
        $data->save();

        $data = new Sack();
        $data->amount = 100;
        $data->rit_id = 4;
        $data->save();

        $data = new Sack();
        $data->amount = 100;
        $data->rit_id = 5;
        $data->save();

        $data = new Sack();
        $data->amount = 100;
        $data->rit_id = 6;
        $data->save();

        $data = new Sack();
        $data->amount = 100;
        $data->rit_id = 7;
        $data->save();

        $data = new Sack();
        $data->amount = 100;
        $data->rit_id = 8;
        $data->save();

        $data = new Sack();
        $data->amount = 100;
        $data->rit_id = 9;
        $data->save();

        $data = new Sack();
        $data->amount = 100;
        $data->rit_id = 10;
        $data->save();
    }
}
