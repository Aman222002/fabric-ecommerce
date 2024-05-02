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
                Permission::updateOrCreate(['name' => 'View Users']);
                Permission::updateOrCreate(['name' => 'Create Users']);
                Permission::updateOrCreate(['name' => 'Post Job']);
                Permission::updateOrCreate(['name' => 'Edit Job']);
                Permission::updateOrCreate(['name' => 'Buy Subscription']);
                Permission::updateOrCreate(['name' => 'Change Plan']);
              
        }
}
