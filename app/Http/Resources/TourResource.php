<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TourResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'travel' => new TravelResource($this->whenLoaded('travel')),
            'name' => $this->name,
            'startingDate' => $this->startingDate,
            'endingDate' => $this->endingDate,
            'price' => round($this->price / 100, 2)
        ];
    }
}
