<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {


        $this->call([
			RoleSeeder::class,
			AdminSeeder::class,
			CategorySeeder::class,
			DatabaseSeeder::class,
			JobPostingPlansTableSeeder::class,
			JobTypeSeeder::class,
			PartnerSeeder::class,
			PermissionSeeder::class,
			SettingSeeder::class,
			SkillSeeder::class,
			SubscriptionPlansTableSeeder::class,
			UserSkillSeeder::class
        ]);

    }
}
