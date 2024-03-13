<?php

namespace App\Http\Controllers;

use App\Http\Requests\Travel\DeleteTravelRequest;
use App\Http\Requests\Travel\ShowTravelRequest;
use App\Http\Requests\Travel\StoreTravelRequest;
use App\Http\Requests\Travel\UpdateTravelRequest;
use App\Http\Resources\TravelResource;
use App\Models\Travel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TravelController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTravelRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $travel = Travel::query()->create($validated)->refresh();

        return response()->json(new TravelResource($travel));
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowTravelRequest $request, Travel $travel): JsonResponse
    {
        $request->validated();

        return response()->json(new TravelResource($travel));
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws \Throwable
     */
    public function update(UpdateTravelRequest $request, Travel $travel): JsonResponse
    {
        $validated = $request->validated();
        $travel->updateOrFail($validated);

        return response()->json(new TravelResource($travel->refresh()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \Throwable
     */
    public function destroy(DeleteTravelRequest $request, Travel $travel): Response
    {
        $request->validated();
        $travel->deleteOrFail();

        return response()->noContent();
    }
}
