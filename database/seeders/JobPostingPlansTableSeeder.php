<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobPostingPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'id' => 1,
                'Search' => 'Yes',
                'Mails' => 50,
                'Validity' => '2 Month',
                'Post Job' => 'Yes',
                'Duration of Job-Post' => '1 Month',
                'Number of Job-Post' => 50,
                'plan_id' => NULL,
                'price' => 70.00,
            ],
            [
                'id' => 2,
                'Search' => 'Yes',
                'Mails' => 25,
                'Validity' => '1 Month',
                'Post Job' => 'Yes',
                'Duration of Job-Post' => '15 Days',
                'Number of Job-Post' => 30,
                'plan_id' => NULL,
                'price' => 50.00,
            ],
            [
                'id' => 3,
                'Search' => 'Yes',
                'Mails' => 12,
                'Validity' => '3 Week',
                'Post Job' => 'Yes',
                'Duration of Job-Post' => '7 Days',
                'Number of Job-Post' => 10,
                'plan_id' => NULL,
                'price' => 20.00,
            ]
        ];
        DB::table('features')->upsert(
            $features,
            ['id'], 
            [
                'Search',
                'Mails',
                'Validity',
                'Post Job',
                'Duration of Job-Post',
                'Number of Job-Post',
                'plan_id',
                'price'
            ]
        );
    }
}