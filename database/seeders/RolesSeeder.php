<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        Role::create(['id' => 1, 'name' => 'guest']);
        Role::create(['id' => 2, 'name' => 'user']);
        Role::create(['id' => 3, 'name' => 'admin']);
    }
}

