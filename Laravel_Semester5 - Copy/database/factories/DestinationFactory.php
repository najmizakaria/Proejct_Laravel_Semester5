<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Destination> */
class DestinationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(), // smart reference, not ->create()
            'name' => fake()->city(),
            'country' => fake()->country(),
            'price' => fake()->numberBetween(200, 3000),
            'image' => fake()->randomElement([
                'images/langkawi.avif',
                'images/phuket.webp',
                'images/cliffs-of-moher.jpg',
                'images/banff_canada.jfif',
                'images/31-The-Ultimate-Kyoto-3-Day-Itinerary-body.jpg',
            ]),
            'description' => fake()->paragraph(),
            'is_featured' => fake()->boolean(30),
            'rating' => fake()->randomFloat(1, 3.5, 5),
        ];
    }
}
