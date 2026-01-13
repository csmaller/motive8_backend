<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EventController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'Laravel backend is running',
        'timestamp' => now()
    ]);
});

Route::get('/', [ApiController::class, 'index']);
Route::get('/data', [ApiController::class, 'getData']);

Route::apiResource('blogs', BlogController::class);
Route::apiResource('events', EventController::class);