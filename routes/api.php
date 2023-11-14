<?php

use \App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// LOGGED USER
Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [V1\AuthController::class, 'logout']);
    
    Route::apiResource('/provinces', V1\ProvinceController::class)->only([
        'index', 'show', 'store'
    ]);

    Route::apiResource('/city', V1\CityController::class)->only([
        'index', 'show', 'store'
    ]);
});

// PUBLIC USER
Route::prefix('auth')->group(function() {
    Route::post('/register', [V1\AuthController::class, 'register']);
    Route::post('/login', [V1\AuthController::class, 'login']);
});
