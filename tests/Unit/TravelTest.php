<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);
use function Pest\Faker\fake;

describe(\App\Models\Travel::class, function () {

    it('has correct number of nights', function () {
        $numberOfDays = fake()->numberBetween(1, 20);
        $travel = \App\Models\Travel::factory()->create();
        $travel->refresh();
        expect($travel->numberOfNights)->toBe($travel->numberOfDays - 1);
    });

    it('has tours relationship model', function () {
        $toursCount = fake()->numberBetween(1,5);

        $travel = \App\Models\Travel::factory()->has(\App\Models\Tour::factory()->count($toursCount), 'tours')->create();
        $travelLoaded = \App\Models\Travel::query()->with('tours')->find($travel->id);
        $tours = $travelLoaded->tours;
        expect($travelLoaded)->not()->toBeNull()
            ->and($tours)->toHaveCount($toursCount);
    });

    it('has createdBy relationship model', function () {
        $travel = \App\Models\Travel::factory()->has(\App\Models\User::factory(), 'createdBy')->create();
        $travelLoaded = \App\Models\Travel::query()->with('createdBy')->find($travel->id);
        expect($travelLoaded->createdBy)->not()->toBeNull()->and($travelLoaded->createdBy)->toBeInstanceOf(\App\Models\User::class);
    });
});
