<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = new UserRole();
        $role->name = 'Owner';
        $role->save();

        $role = new UserRole();
        $role->name = 'Admin';
        $role->save();

        $role = new UserRole();
        $role->name = 'Finance';
        $role->save();
    }
}
