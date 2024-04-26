<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        
        $skills = [
            [ 'skill_name' => 'Programming'],
            [ 'skill_name' => 'Database Management'],
            [ 'skill_name' => 'Design'],
            [ 'skill_name' => 'SQL proficiency'],
            [ 'skill_name' => 'Scripting Languages'],
            [ 'skill_name' => 'Data Migration'],
            [ 'skill_name' => 'Database Optimization'],
            [ 'skill_name' => 'Version Control Systems'],
            [ 'skill_name' => 'Data Security'],
            [ 'skill_name' => 'Data Validation and Testing'],
            [ 'skill_name' => 'Backup and Recovery'],
            [ 'skill_name' => 'Performance Tuning'],
            [ 'skill_name' => 'Cloud Platforms'],
            [ 'skill_name' => 'Data Privacy Regulations'],
            [ 'skill_name' => 'Troubleshooting Skills'],
            // Add more skills as needed
        ];

        // Insert the array of skills into the skills table
        DB::table('skills')->insert($skills);
    }
}
