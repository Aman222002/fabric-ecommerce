<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SubscriptionPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('plans')->insert([
            'name' => 'Premium',
            'duration' => '2Month',
            'Posts_Allowed' => 50,
            'price' => 70.00,
            'interval_unit' => 'monthly',
            'interval' => 1.0,
            'feature_id' => 1
        ]);

        // Insert Standard Plan
        DB::table('plans')->insert([
            'name' => 'Standard',
            'duration' => '1Month',
            'Posts_Allowed' => 30,
            'price' => 50.00,
            'interval_unit' => 'monthly',
            'interval' => 1.0,
            'feature_id' => 2
        ]);

        // Insert Basic Plan
        DB::table('plans')->insert([
            'name' => 'Basic',
            'duration' => '3Week',
            'Posts_Allowed' => 20,
            'price' => 30.00,
            'interval_unit' => 'weekly',
            'interval' => 1.0,
            'feature_id' => 3
        ]);
    }
}
