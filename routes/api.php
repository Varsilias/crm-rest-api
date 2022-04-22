<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

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

Route::group(["prefix" => "v1"], function () {
    Route::group(["prefix" => "categories"], function() {
        Route::get('/', [CategoryController::class, "index"]);
        Route::post('/', [CategoryController::class, "store"]);
        Route::get('/{category}', [CategoryController::class, "show"]);
        Route::put('/{category}', [CategoryController::class, "update"]);
        Route::delete('/{category}', [CategoryController::class, "destroy"]);
    });

    Route::group(["prefix" => "posts"], function() {
        Route::get('/', [PostController::class, "index"]);
        Route::post('/', [PostController::class, "store"]);
        Route::get('/{post}', [PostController::class, "show"]);
        Route::put('/{post}', [PostController::class, "update"]);
        Route::delete('/{post}', [PostController::class, "destroy"]);
    });
});
