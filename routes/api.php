<?php

use App\Http\Controllers\TravelController;
use App\Http\Controllers\TravelTourController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('auth', [\App\Http\Controllers\AuthController::class, 'auth']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('travel', TravelController::class)->except(['index']);
    Route::apiResource('travel/{travel}/tour', TravelTourController::class)->except(['index']);
});

Route::get('travel/{travel}/tour', [TravelTourController::class, 'index']);
