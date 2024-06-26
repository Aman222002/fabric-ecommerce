<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('setting')->insert([
            'contact' => '1234567890',
            'email' => 'jobssupport@yopmail.com',
            'address' => '123 Main St, City, Country',
            'website_address' => 'https://www.example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
