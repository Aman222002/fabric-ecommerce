<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrCreate(['name' => 'Admin']);
        Role::updateOrCreate(['name' => 'User']);
        Role::updateOrCreate(['name' => 'Company Admin']);
        Role::updateOrCreate(['name' => 'Company Subadmin']);
    }
}
