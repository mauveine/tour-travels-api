<?php

namespace Database\Factories;

use App\Models\Travel;
use Carbon\Carbon;
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
            'startingDate' => function ($attributes) {
                $travel = Travel::query()->find($attributes['travelId']);

                return Carbon::createFromTimestamp(($this->faker->dateTimeBetween($travel->created_at))->getTimestamp());
            },
            'endingDate' => function ($attributes) {
                $travel = Travel::query()->find($attributes['travelId']);
                /** @var Carbon $startDate */
                $startDate = $attributes['startingDate'];

                return $startDate->addDays($travel->numberOfDays);
            },
            'price' => $this->faker->numberBetween(10000, 500000),
        ];
    }
}
