<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

describe('Travel', function () {

    it('can be created with moods data object', function () {
        $travel = \App\Models\Travel::factory()->create();
        /** @var \App\Models\Data\TravelMoods $moods */
        $moods = $travel->moods;
        $travelLoaded = \App\Models\Travel::query()->find($travel->id);
        /** @var \App\Models\Data\TravelMoods $loadedMoods */
        $loadedMoods = $travelLoaded->moods;
        expect($travelLoaded)->not()->toBeNull()->and($loadedMoods->toArray())->toEqual($moods->toArray());
    });
});
