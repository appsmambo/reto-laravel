<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\DeezerController;

Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);

Route::middleware('auth:sanctum')->group( function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('album/{id}', [DeezerController::class, 'albumSearch']);
    Route::get('artist/{id}', [DeezerController::class, 'artistSearch']);
    Route::get('search', [DeezerController::class, 'songSearch']);
});
