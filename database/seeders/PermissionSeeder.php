<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'Post Job']);
        Permission::create(['name' => 'Edit Job']);
        Permission::create(['name' => 'Buy Subscription']);
        Permission::create(['name' => 'Change Plan']);
        Permission::create(['name' => 'Change Profile']);
    }
}
