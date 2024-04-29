<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            ['user_id' => 1, 'skill_name' => 'Programming', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 1, 'skill_name' => 'Database Management', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'skill_name' => 'Design', 'created_at' => now(), 'updated_at' => now()],
            // Add more skills as needed
        ];

        // Insert the array of skills into the skills table
        DB::table('skills')->insert($skills);
    }
}
