<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = "Owner";
        $user->email = "owner@gmail.com";
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('wars1234');
        $user->role_id = 2;
        $user->save();

        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@gmail.com";
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('wars1234');
        $user->role_id = 2;
        $user->save();

        $user = new User();
        $user->name = "Finance";
        $user->email = "finance@gmail.com";
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('wars1234');
        $user->role_id = 3;
        $user->save();
    }
}
