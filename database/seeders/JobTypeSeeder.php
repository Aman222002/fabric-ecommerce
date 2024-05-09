<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobType;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobTypes = [
            'Full Time',
            'Part Time',
            'Remote',
            'Freelancer',
        ];

      
        collect($jobTypes)->map(function ($type) {
            JobType::updateOrCreate(['name' => $type]);
        });
    }
}
