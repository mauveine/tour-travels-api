<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

describe(\App\Models\Tour::class, function () {
    it('has travel relationship model', function () {
        $tour = \App\Models\Tour::factory()
            ->has(\App\Models\Travel::factory(), 'travel')
            ->create();
        $tourLoaded = \App\Models\Tour::query()->with('travel')->find($tour->id);
        expect($tourLoaded)->not()->toBeNull();

        $travel = $tourLoaded->travel;
        expect($travel)->not()->toBeNull()
            ->and($travel)->toBeInstanceOf(\App\Models\Travel::class);
    });
});
