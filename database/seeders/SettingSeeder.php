<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('setting')->updateOrInsert(
            [
                'contact' => '1234567890'
            ],
            [
                'contact' => '1234567890',
                'email' => 'jobssupport@yopmail.com',
                'address' => '123 Main St, City, Country',
                'website_address' => 'https://www.example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
