<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()
            ->count(4)
            ->has(
                Destination::factory()->count(5)
            )
            ->create();
    }
}