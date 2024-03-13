<?php

use App\Models\Tour;
use App\Models\Travel;

describe('Tour Travel API', function () {
    it('is protected from unauthenticated requests', function () {
        $travel = Travel::factory()->create();
        $tour = Tour::factory()->state([
            'travelId' => $travel->id,
        ])->make();

        $response = $this->json('POST', sprintf('api/travel/%s/tour', $travel->slug), $tour->toArray());
        $response->assertUnauthorized();

        $tour->save();
        $tour->load('travel')->refresh();
        $response = $this->json('GET', sprintf('api/travel/%s/tour/%s', $travel->slug, $tour->id));
        $response->assertUnauthorized();

        $response = $this->json('PATCH', sprintf('api/travel/%s/tour/%s', $travel->slug, $tour->id), ['name' => 'test name']);
        $response->assertUnauthorized();

        $response = $this->json('DELETE', sprintf('api/travel/%s/tour/%s', $travel->slug, $tour->id));
        $response->assertUnauthorized();
    });

    it('can create model', function () {
        $this->seed();
        $adminUser = generateUser(\App\Enums\UserRoles::Admin->value);
        \Laravel\Sanctum\Sanctum::actingAs($adminUser);

        $travel = Travel::factory()->create();
        $tour = Tour::factory()->state([
            'travelId' => $travel->id,
        ])->make();
        $tourArray = $tour->toArray();

        $response = $this->json('POST', sprintf('api/travel/%s/tour', $travel->slug), $tour->toArray());
        $response->assertOk();
        expect($response->getContent())->toBeJson();

        $response->assertJson([
            'name' => $tour->name,
            'startingDate' => $tourArray['startingDate'],
        ]);
    });

    it('can view model', function () {
        $this->seed();
        $adminUser = generateUser(\App\Enums\UserRoles::Admin->value);
        \Laravel\Sanctum\Sanctum::actingAs($adminUser);

        $tour = Tour::factory()->create()->load('travel');
        $tourJson = (new \App\Http\Resources\TourResource($tour))->response()->getData(true)['data'];

        $response = $this->json('GET', sprintf('api/travel/%s/tour/%s', $tour->travel->slug, $tour->id));
        $response->assertOk();
        expect($response->getContent())->toBeJson();

        $response->assertJson($tourJson);

    });

    it('can update models', function () {
        $this->seed();
        $adminUser = generateUser(\App\Enums\UserRoles::Admin->value);
        \Laravel\Sanctum\Sanctum::actingAs($adminUser);

        $name = fake()->unique()->word();
        $tour = Tour::factory()->create();
        $tour->name = $name;
        $tourJson = (new \App\Http\Resources\TourResource($tour))->response()->getData(true)['data'];

        $response = $this->json('PATCH', sprintf('api/travel/%s/tour/%s', $tour->travel->slug, $tour->id), [
            'name' => $name,
        ]);
        $response->assertOk();
        expect($response->getContent())->toBeJson();

        $response->assertJson($tourJson);
    });

    it('can delete model', function () {
        $this->seed();
        $adminUser = generateUser(\App\Enums\UserRoles::Admin->value);
        \Laravel\Sanctum\Sanctum::actingAs($adminUser);

        $tour = Tour::factory()->create();

        $response = $this->json('DELETE', sprintf('api/travel/%s/tour/%s', $tour->travel->slug, $tour->id));
        $response->assertNoContent();

        $loadedTour = Tour::query()->find($tour->id);
        expect($loadedTour)->toBeNull();
    });

    it('public url accessible', function () {
        $travel = Travel::factory()->create();
        $tour = Tour::factory()->state([
            'travelId' => $travel->id,
        ])->make();

        $response = $this->json('GET', sprintf('api/travel/%s/tour', $travel->slug));
        $response->assertOk();
    });

    it('lists tours by travel slug', function () {
        $this->seed();
        $travel = Travel::query()->first();
        $response = $this->json('GET', sprintf('api/travel/%s/tour', $travel->slug));

        expect($response)->toMatchSnapshot();
        $response->assertJsonStructure([
            'data' => [],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
                'path',
                'per_page',
                'to',
                'total',
            ],
        ]);
    });

    it('lists tours by travel slug with filters', function () {
        $this->seed();
        $travel = Travel::query()->where('slug', 'jordan-360')->first();

        $params = [
            'filter' => [
                'dateFrom' => '2021-11-01',
                'dateTo' => '2021-11-09',
                'priceFrom' => '2000',
            ],
        ];
        $response = $this->json('GET', sprintf('api/travel/%s/tour', $travel->slug), $params);
        expect($response->json('data'))->toHaveCount(0)
            ->and($response)->toMatchSnapshot();

        $params = [
            'filter' => [
                'dateFrom' => '2021-11-01',
                'dateTo' => '2021-11-09',
                'priceFrom' => '1999',
            ],
        ];
        $response = $this->json('GET', sprintf('api/travel/%s/tour', $travel->slug), $params);
        expect($response->json('data'))->toHaveCount(1)
            ->and($response)->toMatchSnapshot();
    });

    it('lists tours by travel slug with sorting', function () {
        $this->seed();
        $travel = Travel::query()->where('slug', 'jordan-360')->first();

        $params = [
            'sort' => '-price',
        ];
        $response = $this->json('GET', sprintf('api/travel/%s/tour', $travel->slug), $params);
        expect($response->json('data'))->toHaveCount(3)
            ->and($response)->toMatchSnapshot();

        $data = $response->json('data');
        expect($data[0]['price'])->toBeGreaterThanOrEqual($data[1]['price']);

        $params = [
            'sort' => 'price',
        ];
        $response = $this->json('GET', sprintf('api/travel/%s/tour', $travel->slug), $params);
        expect($response->json('data'))->toHaveCount(3)
            ->and($response)->toMatchSnapshot();

        $data = $response->json('data');
        expect($data[0]['price'])->not()->toBeGreaterThan($data[1]['price']);
    });
});
