<?php

namespace App\Http\Requests\Tour;

use App\Http\Requests\BaseRequest;
use App\Models\Travel;
use Illuminate\Validation\Rule;

abstract class BaseTourRequest extends BaseRequest
{
    public function defaultRules(): array
    {
        return [
            'travelId' => [
                'uuid',
                Rule::exists(Travel::class, 'id'),
            ],
            'name' => [
                'string',
                'max:255',
            ],
            'startingDate' => [
                'date',
            ],
            'endingDate' => [
                'date',
            ],
            'price' => [
                'numeric',
            ],
        ];
    }
}
