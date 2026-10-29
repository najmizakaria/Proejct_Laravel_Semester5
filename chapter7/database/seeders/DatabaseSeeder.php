<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DemoUserSeeder::class);

        $catalog = [
            'Web Development' => ['Laravel in Practice', 'Modern PHP Foundations', 'Building Accessible Websites', 'JavaScript for Web Developers', 'CSS Layout Workshop'],
            'Databases' => ['Relational Database Design', 'Practical SQL Queries', 'MySQL Essentials', 'Data Modeling Handbook', 'Database Performance Basics'],
            'Software Engineering' => ['Clean Code Workshop', 'Testing Web Applications', 'Git for Project Teams', 'Software Architecture Basics', 'Design Patterns in PHP'],
            'Computer Science' => ['Algorithms Made Clear', 'Data Structures in Practice', 'Computer Networks Explained', 'Operating Systems Basics', 'Introduction to Cybersecurity'],
        ];

        foreach ($catalog as $name => $titles) {
            $category = Category::firstOrCreate(['name' => $name]);

            foreach ($titles as $index => $title) {
                if (! $category->books()->where('title', $title)->exists()) {
                    Book::factory()->for($category)->create([
                        'title' => $title,
                        'is_featured' => $index === 0,
                    ]);
                }
            }
        }
    }
}
