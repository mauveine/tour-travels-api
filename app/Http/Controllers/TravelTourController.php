<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tour\DeleteTourRequest;
use App\Http\Requests\Tour\ShowTourRequest;
use App\Http\Requests\Tour\StoreTourRequest;
use App\Http\Requests\Tour\UpdateTourRequest;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TravelTourController extends Controller
{
    public function index(Request $request, Travel $travel)
    {
        return TourResource::collection(
            QueryBuilder::for(Tour::class)
                ->where('travelId', $travel->id)
                ->allowedFilters([
                    AllowedFilter::scope('priceFrom'),
                    AllowedFilter::scope('priceTo'),
                    AllowedFilter::scope('dateFrom'),
                    AllowedFilter::scope('dateTo'),
                ])
                ->defaultSort('startingDate')
                ->allowedSorts('price')
                ->jsonPaginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTourRequest $request, Travel $travel): JsonResponse
    {
        $validated = $request->validated();
        $tour = Tour::query()->create($validated)->refresh();

        return response()->json(new TourResource($tour));
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowTourRequest $request, Travel $travel, Tour $tour): JsonResponse
    {
        $request->validated();

        return response()->json(new TourResource($tour->load('travel')));
    }

    /**
     * Updated the specific resource
     *
     * @throws \Throwable
     */
    public function update(UpdateTourRequest $request, Travel $travel, Tour $tour): JsonResponse
    {
        $validated = $request->validated();
        $tour->updateOrFail($validated);

        return response()->json(new TourResource($tour));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \Throwable
     */
    public function destroy(DeleteTourRequest $request, Travel $travel, Tour $tour): Response
    {
        $request->validated();
        $travel->deleteOrFail();

        return response()->noContent();
    }
}
