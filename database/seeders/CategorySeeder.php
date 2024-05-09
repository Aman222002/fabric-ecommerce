<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Accounts',
            'IT',
            'Fashion Designing',
            'Engineering',
            'Management',
            'Project manager',
        ];

        collect($categories)->map(function ($category) {
            Category::updateOrCreate(['name' => $category]);
        });
    }
}
