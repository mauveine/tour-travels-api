<?php

namespace App\Http\Requests\Tour;

use App\Models\Tour;
use Illuminate\Support\Facades\Auth;

class StoreTourRequest extends BaseTourRequest
{
    protected array $assignedMethod = ['POST'];

    protected array $requiredAttributes = [
        'name', 'startingDate',
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $travel = $this->route('travel');

        return $user->can('create', Tour::class, $travel);
    }
}
