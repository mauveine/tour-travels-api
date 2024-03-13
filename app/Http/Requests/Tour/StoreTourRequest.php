<?php

namespace App\Http\Requests\Travel;

use App\Models\Travel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreTourRequest extends BaseTourRequest
{
    protected array $assignedMethod = ['POST'];
    protected array $requiredAttributes = [
        'name', 'numberOfDays'
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        return $user->can('create', Travel::class);
    }
}
