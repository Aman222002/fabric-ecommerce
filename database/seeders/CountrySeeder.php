<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['user_id' => 1, 'country' => 'Afghanistan', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 1, 'country' => 'Albania', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'Algeria', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'Brazil', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'Belgium', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'Canada', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'China', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'Denmark', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'Dominican Republic', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'Egypt', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'France', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'Germany', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'Hungary', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'India', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'Indonesia', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'Albania', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'Albania', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'Albania', 'created_at' => now(), 'updated_at' => now()],
            // ['user_id' => 1, 'name' => 'Zimbabwe', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('country')->insert($countries);
    }
}