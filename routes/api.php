<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecordController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(["prefix" => "auth"], function() {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register'])->middleware(["auth:sanctum", "admin"]);
});

Route::middleware(["auth:sanctum"])->group(function() {
    Route::group(["prefix" => "merchants"], function () {
        Route::middleware(["admin"])->group(function() {
            Route::get("", [MerchantController::class, "index"]);
            Route::post("", [MerchantController::class, "store"]);
            Route::put("{uuid}", [MerchantController::class, "update"]);
            Route::delete("{uuid}", [MerchantController::class, "destroy"]);
            Route::get("{uuid}", [MerchantController::class, "show"]);
        });

        Route::group(["middleware" => "validmerchantuuid", "prefix" => "{merchant_uuid}/products"], function() {
            Route::get("", [ProductController::class, "index"]);
            Route::post("", [ProductController::class, "store"]);
            Route::put("{uuid}", [ProductController::class, "update"]);
            Route::delete("{uuid}", [ProductController::class, "destroy"]);
            Route::get("{uuid}", [ProductController::class, "show"]);
        });
    });
});
