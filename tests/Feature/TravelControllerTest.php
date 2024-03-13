<?php

use App\Models\Travel;

describe('Travel API', function () {
    it('is protected from unauthenticated requests', function () {
        $travel = Travel::factory()->make();

        $response = $this->json('POST', 'api/travel', $travel->toArray());
        $response->assertUnauthorized();

        $travel->save();
        $travel->refresh();
        $response = $this->json('GET', sprintf('api/travel/%s', $travel->slug));
        $response->assertUnauthorized();

        $response = $this->json('PATCH', sprintf('api/travel/%s', $travel->slug), ['name' => 'test name']);
        $response->assertUnauthorized();

        $response = $this->json('DELETE', sprintf('api/travel/%s', $travel->slug));
        $response->assertUnauthorized();
    });

    it('can create model', function () {
        $this->seed();
        $adminUser = generateUser(\App\Enums\UserRoles::Admin->value);
        \Laravel\Sanctum\Sanctum::actingAs($adminUser);

        $travel = Travel::factory()->make();

        $response = $this->json('POST', 'api/travel', $travel->toArray());
        $response->assertOk();
        expect($response->getContent())->toBeJson();

        $response->assertJson([
            'slug' => $travel->slug,
            'name' => $travel->name,
            'description' => $travel->description,
            'numberOfDays' => $travel->numberOfDays,
            'numberOfNights' => $travel->numberOfNights,
            'moods' => $travel->moods->toArray(),
        ]);
    });

    it('can view model', function () {
        $this->seed();
        $adminUser = generateUser(\App\Enums\UserRoles::Admin->value);
        \Laravel\Sanctum\Sanctum::actingAs($adminUser);

        $travel = Travel::factory()->create();

        $response = $this->json('GET', sprintf('api/travel/%s', $travel->slug));
        $response->assertOk();
        expect($response->getContent())->toBeJson();

        $response->assertJson([
            'slug' => $travel->slug,
            'name' => $travel->name,
            'description' => $travel->description,
            'numberOfDays' => $travel->numberOfDays,
            'numberOfNights' => $travel->numberOfNights,
            'moods' => $travel->moods->toArray(),
        ]);
    });

    it('can update models', function () {
        $this->seed();
        $editorUser = generateUser(\App\Enums\UserRoles::Editor->value);
        \Laravel\Sanctum\Sanctum::actingAs($editorUser);

        $travel = Travel::factory()->create();

        $description = fake()->sentence();
        $response = $this->json('PATCH', sprintf('api/travel/%s', $travel->slug), [
            'description' => $description,
        ]);
        $response->assertOk();
        expect($response->getContent())->toBeJson();

        $response->assertJson([
            'slug' => $travel->slug,
            'name' => $travel->name,
            'description' => $description,
            'numberOfDays' => $travel->numberOfDays,
            'numberOfNights' => $travel->numberOfNights,
            'moods' => $travel->moods->toArray(),
        ]);
    });

    it('can delete model', function () {
        $this->seed();
        $adminUser = generateUser(\App\Enums\UserRoles::Admin->value);
        \Laravel\Sanctum\Sanctum::actingAs($adminUser);

        $travel = Travel::factory()->create();

        $response = $this->json('DELETE', sprintf('api/travel/%s', $travel->slug));
        $response->assertNoContent();

        $loadedTravel = Travel::query()->find($travel->id);
        expect($loadedTravel)->toBeNull();
    });
});
