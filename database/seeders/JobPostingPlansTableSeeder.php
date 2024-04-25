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
        //
        DB::table('features')->insert([
            'Search' => 'Yes',
            'Mails' => 50,
            'Validity' => '2 Month',
            'Post Job' => 'Yes',
            'Duration of Job-Post' => '1 Month',
            'Number of Job-Post' => 50,
            'plan_id' => NULL,
            'price' => 70.00,
        ]);

        // Insert second job posting plan
        DB::table('features')->insert([
            'Search' => 'Yes',
            'Mails' => 25,
            'Validity' => '1 Month',
            'Post Job' => 'Yes',
            'Duration of Job-Post' => '15 Days',
            'Number of Job-Post' => 30,
            'plan_id' => NULL,
            'price' => 50.00,
        ]);

        // Insert third job posting plan
        DB::table('features')->insert([
            'Search' => 'Yes',
            'Mails' => 12,
            'Validity' => '15 Days',
            'Post Job' => 'Yes',
            'Duration of Job-Post' => '7 Days',
            'Number of Job-Post' => 10,
            'plan_id' => NULL,
            'price' => 20.00,
        ]);
    }
}
