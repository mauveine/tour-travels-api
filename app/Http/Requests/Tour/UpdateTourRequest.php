<?php

namespace App\Http\Requests\Tour;

use Illuminate\Support\Facades\Auth;

class UpdateTourRequest extends BaseTourRequest
{
    protected array $assignedMethod = ['PATCH', 'PUT'];

    protected array $requiredAttributes = [];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $tour = $this->route('tour');

        return $user->can('update', $tour);
    }
}
