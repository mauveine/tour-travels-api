<?php

namespace App\Http\Requests\Travel;

use App\Http\Requests\BaseRequest;

abstract class BaseTravelRequest extends BaseRequest
{
    public function defaultRules(): array
    {
        return [
            'slug' => [
                'string',
                'max:255',
            ],
            'name' => [
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'numberOfDays' => [
                'numeric',
                'gt:0',
            ],
            'moods' => [
                'array:nature,relax,history,culture,party',
            ],
        ];
    }
}
