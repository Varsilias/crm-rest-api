<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    "prefix" => "v1"
], function () {
    Route::group(["prefix" => "users"], function() {
        Route::post('/sign-up', [AuthController::class, "signUp"]);
        Route::post('/login', [AuthController::class, "login"])->middleware(['jwt.verify']);
        Route::post('/token/refresh', [AuthController::class, "refresh"])->middleware(['refresh']);
    });
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('posts', PostController::class);
});
