<?php

namespace Database\Factories;

use App\Models\Data\TravelMoods;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Travel>
 */
class TravelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->sentence(),
            'slug' => fn($attributes) => Str::slug($attributes['name']),
            'description' => $this->faker->paragraphs(3, true),
            'numberOfDays' => $this->faker->numberBetween(1, 14),
            'moods' => new TravelMoods(
                $this->faker->numberBetween(0, 100), // nature
                $this->faker->numberBetween(0, 100), // relax
                $this->faker->numberBetween(0, 100), // history
                $this->faker->numberBetween(0, 100), // culture
                $this->faker->numberBetween(0, 100)  // party
            ),
            'public' => true,
            'created_at' => $this->faker->dateTimeBetween('-6 months'),
            'updated_at' => fn($attributes) => $attributes['created_at']
        ];
    }
}
