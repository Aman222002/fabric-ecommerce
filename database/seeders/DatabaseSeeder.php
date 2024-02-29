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
    /**
     * Seed the application's database.
     */
    // private $permissions = [
    //     'role-list',
    //     'role-create',
    //     'role-edit',
    //     'role-delete',
    //     'product-list',
    //     'product-create',
    //     'product-edit',
    //     'product-delete'
    // ];

    // public function run(): void
    // {
    //     $permissionName = 'role-list';
    //     $guardName = 'web';
    //     if (!Permission::where('name', 'role-list')->where('guard_name', 'web')->exists()) {
    //         Permission::create(['name' => 'role-list', 'guard_name' => 'web']);
    //     }
    //     foreach ($this->permissions as $permission) {
    //         Permission::create(['name' => $permission]);
    //     }
    //     $user = User::create([
    //         'name' => 'Prevail Ejimadu',
    //         'email' => 'test@example.com',
    //         'password' => Hash::make('password')
    //     ]);
    //     $role = Role::create(['name' => 'Admin']);
    //     $permissions = Permission::pluck('id', 'id')->all();
    //     $role->syncPermissions($permissions);
    //     $user->assignRole([$role->id]);
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\Category::factory(4)->create();
        \App\Models\JobType::factory(4)->create();

        //  $this->call([
        //     RoleSeeder::class,
        // ]);

    }
}
