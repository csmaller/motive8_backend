<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\VelocityClassController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
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

// Auth routes
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::post('/auth/login', [AuthController::class, 'adminLogin']); // Alias
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('/', [ApiController::class, 'index']);
Route::get('/data', [ApiController::class, 'getData']);

Route::post('/news/{news}/publish', [NewsController::class, 'publish']);
Route::apiResource('news', NewsController::class);
Route::apiResource('events', EventController::class);
Route::apiResource('people', PersonController::class);
Route::get('/coaches', [PersonController::class, 'getCoaches']);
Route::apiResource('users', UserController::class);
Route::apiResource('velocity-classes', VelocityClassController::class);
Route::apiResource('products', ProductController::class);

// Contact form
Route::post('/contact', [ContactController::class, 'submit']);