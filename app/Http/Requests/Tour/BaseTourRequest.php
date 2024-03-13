<?php

namespace App\Http\Requests\Tour;

use App\Http\Requests\BaseRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

abstract class BaseTourRequest extends BaseRequest
{
    public function defaultRules(): array
    {
        return [
            'slug' => [
                'string',
                'max:255'
            ],
            'name' => [
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string'
            ],
            'numberOfDays' => [
                'numeric',
                'gt:0'
            ],
            'moods' => [
                'array:nature,relax,history,culture,party'
            ]
        ];
    }
}
