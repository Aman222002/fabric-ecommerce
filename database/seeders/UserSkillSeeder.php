<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class UserSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $skills = [
            ['user_id' => 133, 'skill_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 131, 'skill_id' => 14, 'created_at' => now(), 'updated_at' => now()],
          
        ];
        

        // Insert the array of skills into the skills table
        DB::table('user_skills')->insert($skills);
       
    }
}
