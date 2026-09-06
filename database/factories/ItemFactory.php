<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'item_condition' => fake()->randomElement(['NEW', 'EXCELLENT', 'GOOD', 'FAIR']),
            'size' => fake()->randomElement(['XS', 'S', 'M', 'L', 'XL', 'Única']),
            'type' => fake()->randomElement(['CLOTHES', 'ACCESSORIES']),
            'offer_type' => fake()->randomElement(['TRADE', 'GIFT', 'BOTH']),
            'status' => 'AVAILABLE',
        ];
    }
}
