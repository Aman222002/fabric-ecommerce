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
            // Add more skills as needed
        ];

        // Insert the array of skills into the skills table
        DB::table('skills')->insert($skills);
    }
}
