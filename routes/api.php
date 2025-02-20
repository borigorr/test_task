<?php

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

Route::post("/login", [\App\Http\Controllers\AuthController::class, "login"]);

Route::middleware("auth")->group(function () {
    Route::prefix("users")->group(function () {
        Route::get("/", [\App\Http\Controllers\UserController::class, "index"]);
        Route::get("/{id}", [\App\Http\Controllers\UserController::class, "getUser"])
            ->where('id', '[0-9]+');
        Route::delete("/{id}", [\App\Http\Controllers\UserController::class, "delete"])
            ->where('id', '[0-9]+');

        Route::put("/{id}", [\App\Http\Controllers\UserController::class, "update"])
            ->where('id', '[0-9]+');;
    });
});
