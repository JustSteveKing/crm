<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use JustSteveKing\StatusCode\Http;

Route::get('ping', function () {
    return response()->json(
        data: ['ack' => 'pong'],
        status: Http::OK,
    );
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('contacts')->as('contacts:')->group(function () {
        Route::get('/', App\Http\Controllers\Api\Contacts\IndexController::class)->name('index');
        Route::post('/', App\Http\Controllers\Api\Contacts\StoreController::class)->name('store');
        Route::get('{uuid}', App\Http\Controllers\Api\Contacts\ShowController::class)->name('show');
        Route::put('{uuid}', App\Http\Controllers\Api\Contacts\UpdateController::class)->name('update');
        Route::delete('{uuid}', App\Http\Controllers\Api\Contacts\DeleteController::class)->name('delete');
    });

    Route::prefix('interactions')->as('interactions:')->group(function () {
        Route::get('/', App\Http\Controllers\Api\Interactions\IndexController::class)->name('index');
        Route::post('/', App\Http\Controllers\Api\Interactions\StoreController::class)->name('store');
        Route::get('{uuid}', App\Http\Controllers\Api\Interactions\ShowController::class)->name('show');
        Route::put('{uuid}', App\Http\Controllers\Api\Interactions\UpdateController::class)->name('update');
        Route::delete('{uuid}', App\Http\Controllers\Api\Interactions\DeleteController::class)->name('delete');
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
