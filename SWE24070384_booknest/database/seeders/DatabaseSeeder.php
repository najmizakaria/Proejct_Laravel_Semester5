<?php
/**
 * Student Name : Najmi
 * Student ID   : SWE24070384
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            BookSeeder::class,
        ]);
    }
}