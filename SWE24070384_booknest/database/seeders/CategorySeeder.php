<?php
/**
 * Student Name : Najmi
 * Student ID   : SWE24070384
 */

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Fiction',
        ]);

        Category::create([
            'name' => 'Technology',
        ]);

        Category::create([
            'name' => 'Biography',
        ]);
    }
}