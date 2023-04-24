<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $item = new Item();
        $item->code = 'K-ABC';
        $item->brand = 'Kedelai ABC';
        $item->save();

        $item = new Item();
        $item->code = 'K-DEF';
        $item->brand = 'Kedelai DEF';
        $item->save();
    }
}
