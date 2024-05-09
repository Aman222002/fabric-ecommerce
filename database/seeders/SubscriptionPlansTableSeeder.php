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
        DB::table('plans')->upsert([
            [
                'id' => 1, 
                'name' => 'Premium',
                'duration' => '2Month',
                'posts_allowed' => 50,
                'price' => 70.00,
                'interval_unit' => 'monthly',
                'interval' => 1.0,
                'feature_id' => 1
            ],
            [
                'id' => 2,
                'name' => 'Standard',
                'duration' => '1Month',
                'posts_allowed' => 30,
                'price' => 50.00,
                'interval_unit' => 'monthly',
                'interval' => 1.0,
                'feature_id' => 2
            ],
            [
                'id' => 3,
                'name' => 'Basic',
                'duration' => '3Week',
                'posts_allowed' => 20,
                'price' => 30.00,
                'interval_unit' => 'weekly',
                'interval' => 1.0,
                'feature_id' => 3
            ]
        ], ['id'], [ 
            'name','duration','posts_allowed','price','interval_unit','interval','feature_id'
        ]);
    }
}
