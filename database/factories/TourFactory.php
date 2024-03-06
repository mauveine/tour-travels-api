<?php

namespace Database\Factories;

use App\Models\Travel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'travelId' => Travel::factory(),
            'name' => $this->faker->unique()->word,
            'startingDate' => $this->faker->date(),
            'endingDate' => $this->faker->date(),
            'price' => $this->faker->numberBetween(10000, 500000),
        ];
    }
}
