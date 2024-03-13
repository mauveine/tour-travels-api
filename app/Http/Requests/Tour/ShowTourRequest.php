<?php

namespace App\Http\Requests\Tour;

use Illuminate\Support\Facades\Auth;

class ShowTourRequest extends BaseTourRequest
{
    protected array $assignedMethod = ['GET'];

    protected array $requiredAttributes = [];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $tour = $this->route('tour');

        return $user->can('view', $tour);
    }
}
