<?php

namespace App\Models\Data;

use Spatie\LaravelData\Data;

class TravelMoods extends Data
{
    public function __construct(
        public int $nature = 0,
        public int $relax = 0,
        public int $history = 0,
        public int $culture = 0,
        public int $party = 0,
    ) {
    }
}
