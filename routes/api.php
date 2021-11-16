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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
