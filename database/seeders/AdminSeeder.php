<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update or create the admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin1@gmail.com'], 
            [
                'name' => 'Admin',
                'phone' => '9583080519',
                'password' =>  Hash::make('Admin@1234'),
            ]
        );

       
        $admin->assignRole('Admin');
    }
}
