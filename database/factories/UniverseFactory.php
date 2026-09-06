<?php

namespace Database\Factories;

use App\Models\Universe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Universe>
 */
class UniverseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $styles = ['y2k', 'cottagecore', 'grunge', 'minimalist', 'mermaidcore', 'dark academia'];

        return [
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'style' => fake()->randomElement($styles),
            'cover_img' => null,
        ];
    }
}
