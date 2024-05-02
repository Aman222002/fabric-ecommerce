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
        // Insert or update Premium Plan
        DB::table('plans')->upsert([
            [
                'id' => 1,
                'name' => 'Premium',
                'duration' => '2Month',
                'Posts_Allowed' => 50,
                'price' => 70.00,
                'interval_unit' => 'monthly',
                'interval' => 1.0,
                'feature_id' => 1
            ]
        ], ['id'], [
            'name',
            'duration',
            'Posts_Allowed',
            'price',
            'interval_unit',
            'interval',
            'feature_id'
        ]);

        // Insert or update Standard Plan
        DB::table('plans')->upsert([
            [
                'id' => 2,
                'name' => 'Standard',
                'duration' => '1Month',
                'Posts_Allowed' => 30,
                'price' => 50.00,
                'interval_unit' => 'monthly',
                'interval' => 1.0,
                'feature_id' => 2
            ]
        ], ['id'], [
            'name',
            'duration',
            'Posts_Allowed',
            'price',
            'interval_unit',
            'interval',
            'feature_id'
        ]);

        // Insert or update Basic Plan
        DB::table('plans')->upsert([
            [
                'id' => 3,
                'name' => 'Basic',
                'duration' => '3Week',
                'Posts_Allowed' => 20,
                'price' => 30.00,
                'interval_unit' => 'weekly',
                'interval' => 1.0,
                'feature_id' => 3
            ]
        ], ['id'], [
            'name',
            'duration',
            'Posts_Allowed',
            'price',
            'interval_unit',
            'interval',
            'feature_id'
        ]);
    }
}
