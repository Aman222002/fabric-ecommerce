<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $skills = [
            ['user_id' => 1, 'skill_name' => 'PHP'],
            ['user_id' => 1, 'skill_name' => 'JavaScript'],
            ['user_id' => 2, 'skill_name' => 'HTML'],
            ['user_id' => 2, 'skill_name' => 'CSS'],
            // Add more skills and user_id as needed
        ];

        // Insert the skills data into the 'skills' table
        DB::table('skills')->insert($skills);
    }
}
