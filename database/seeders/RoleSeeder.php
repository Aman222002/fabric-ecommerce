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
        $roles = [
            ['name' => 'Admin'],
            ['name' => 'User'],
            ['name' => 'Company Admin'],
            ['name' => 'Company Subadmin'],
        ];
        foreach ($roles as $role) {
            Role::updateOrCreate($role);
        }
    }
}
