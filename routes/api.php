<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonController;
use App\Models\News;

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

Route::apiResource('news', NewsController::class);
Route::apiResource('events', EventController::class);
Route::apiResource('people', PersonController::class);
Route::apiResource('users', UserController::class);