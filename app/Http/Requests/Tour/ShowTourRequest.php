<?php

namespace App\Http\Requests\Travel;

use App\Models\Travel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

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
        $travel = $this->route('travel');
        return $user->can('view', $travel);
    }
}
