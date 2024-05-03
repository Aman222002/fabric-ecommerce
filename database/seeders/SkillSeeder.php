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
       
        
        $skills = [
            [ 'id' => 1, 'skill_name' => 'Programming'],
            [ 'id' => 2, 'skill_name' => 'Database Management'],
            [ 'id' => 3, 'skill_name' => 'Design'],
            [ 'id' => 4, 'skill_name' => 'SQL proficiency'],
            [ 'id' => 5, 'skill_name' => 'Scripting Languages'],
            [ 'id' => 6, 'skill_name' => 'Data Migration'],
            [ 'id' => 7, 'skill_name' => 'Database Optimization'],
            [ 'id' => 8, 'skill_name' => 'Version Control Systems'],
            [ 'id' => 9, 'skill_name' => 'Data Security'],
            [ 'id' => 10, 'skill_name' => 'Data Validation and Testing'],
            [ 'id' => 11, 'skill_name' => 'Backup and Recovery'],
            [ 'id' => 12, 'skill_name' => 'Performance Tuning'],
            [ 'id' => 13, 'skill_name' => 'Cloud Platforms'],
            [ 'id' => 14, 'skill_name' => 'Data Privacy Regulations'],
            [ 'id' => 15, 'skill_name' => 'Troubleshooting Skills'],
        ];

        DB::table('skills')->upsert(
            $skills,
            ['id'],
            ['skill_name']
        );
    }
}
