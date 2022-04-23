<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;

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
        Route::get('/', [AuthController::class, "getAllUsers"]);
        Route::post('/sign-up', [AuthController::class, "signUp"]);
        Route::post('/login', [AuthController::class, "login"]);
        Route::post('/token/refresh', [AuthController::class, "refresh"])->middleware(['refresh']);
        Route::get('/profile', [AuthController::class, "profile"])->middleware(['jwt.verify']);
        Route::post('/logout', [AuthController::class, "logout"])->middleware(['jwt.verify']);

        Route::post('/forgot-password', [ForgotPasswordController::class, "forgotPassword"]);
        Route::post('/reset-password', [ForgotPasswordController::class, "resetPassword"]);


    });
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('posts', PostController::class)->middleware(['jwt.verify']);
});
