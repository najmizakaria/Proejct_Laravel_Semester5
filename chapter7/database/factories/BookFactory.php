<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'title' => fake()->sentence(4),
            'author' => fake()->name(),
            'isbn' => fake()->unique()->isbn13(),
            'description' => fake()->paragraphs(2, true),
            'price' => fake()->randomFloat(2, 20, 250),
            'stock' => fake()->numberBetween(0, 50),
            'is_featured' => fake()->boolean(30),
        ];
    }
}
