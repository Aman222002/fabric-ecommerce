<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobType;
class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $jobTypes = [
            'Full Time',
            'Part Time',
            'Remote',
            'Freelencer',
        ];
        foreach ($jobTypes as $type) {
            JobType::updateOrCreate(['name' => $type]);
        }
    }
}
