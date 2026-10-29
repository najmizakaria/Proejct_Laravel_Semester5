<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class DestinationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),

            'name' => fake()->city() . ' Adventure',

            'location' => fake()->city(),

            'description' => fake()->paragraph(),

            'image' => fake()->randomElement([
                'beach.jfif',
                'mountain.jfif',
                'city.jfif',
            ]),

            'price' => fake()->randomFloat(2, 100, 1000),

            'featured' => fake()->boolean(40),
        ];
    }
}