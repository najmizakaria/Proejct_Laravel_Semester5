<?php
/**
 * Student Name : Najmi
 * Student ID   : SWE24070384
 */

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::create([
            'category_id' => 1,
            'title' => 'The Silent Patient',
            'author' => 'Alex Michaelides',
            'year_published' => 2019,
            'price' => 29.90,
        ]);

        Book::create([
            'category_id' => 2,
            'title' => 'Laravel: Up & Running',
            'author' => 'Matt Stauffer',
            'year_published' => 2022,
            'price' => 120.00,
        ]);

        Book::create([
            'category_id' => 2,
            'title' => 'Clean Code',
            'author' => 'Robert C. Martin',
            'year_published' => 2008,
            'price' => 150.50,
        ]);

        Book::create([
            'category_id' => 3,
            'title' => 'Steve Jobs',
            'author' => 'Walter Isaacson',
            'year_published' => 2011,
            'price' => 75.00,
        ]);

        Book::create([
            'category_id' => 1,
            'title' => 'Where the Crawdads Sing',
            'author' => 'Delia Owens',
            'year_published' => 2018,
            'price' => 45.00,
        ]);
    }
}