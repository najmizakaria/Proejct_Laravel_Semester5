<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $beach = Category::create(['name' => 'Beach']);
        $nature = Category::create(['name' => 'Nature']);
        $culture = Category::create(['name' => 'Culture']);
        $city = Category::create(['name' => 'City']);

        $beach->destinations()->createMany([
            [
                'name' => 'Langkawi Island', 'country' => 'Malaysia', 'price' => 450,
                'image' => 'images/langkawi.avif', 'is_featured' => true, 'rating' => 4.9,
                'description' => 'Pristine white-sand beaches, lush rainforest cable car rides, and duty-free shopping.',
            ],
            [
                'name' => 'Phuket', 'country' => 'Thailand', 'price' => 550,
                'image' => 'images/phuket.webp', 'is_featured' => true, 'rating' => 4.8,
                'description' => 'Crystal-clear waters, vibrant night markets, and iconic Phi Phi island tours.',
            ],
        ]);

        $nature->destinations()->createMany([
            [
                'name' => 'Cliffs of Moher', 'country' => 'Ireland', 'price' => 1100,
                'image' => 'images/cliffs-of-moher.jpg', 'is_featured' => false, 'rating' => 4.7,
                'description' => 'Dramatic ocean cliffs, breathtaking Atlantic views, and rich Celtic heritage.',
            ],
            [
                'name' => 'Banff National Park', 'country' => 'Canada', 'price' => 1500,
                'image' => 'images/banff_canada.jfif', 'is_featured' => true, 'rating' => 4.9,
                'description' => 'Turquoise glacial lakes, towering Rocky Mountain peaks, and wildlife at every turn.',
            ],
        ]);

        $culture->destinations()->create([
            'name' => 'Kyoto', 'country' => 'Japan', 'price' => 1300,
            'image' => 'images/31-The-Ultimate-Kyoto-3-Day-Itinerary-body.jpg', 'is_featured' => false, 'rating' => 4.8,
            'description' => 'Ancient temples, traditional tea houses, and the timeless beauty of Gion.',
        ]);

        // Extra dummy data via the factory, spread across the existing categories
        Destination::factory(3)
            ->recycle(collect([$beach, $nature, $culture, $city]))
            ->create();
    }
}
