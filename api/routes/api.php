<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StreamController;
use App\Http\Controllers\Api\VodController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/refresh', [AuthController::class, 'refresh'])
        ->name('auth.refresh');
        //->middleware('refresh.rotator');
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth:sanctum');
});

Route::prefix('/streams')->group(function () {
    Route::post('/start', [StreamController::class, 'start']);
    Route::post('/stop', [StreamController::class, 'stop']);

    Route::get('/{stream}/master.m3u8', [StreamController::class, 'master']);
    Route::get('/{alias}/{quality}/main_stream.m3u8', [StreamController::class, 'serve']);
    Route::get('/{alias}/{quality}/{file}', [StreamController::class, 'serve']);

    Route::middleware('auth:sanctum')->group(function () {
//        Route::get('/{alias}', [StreamController::class, 'getLiveStream']);
        Route::get('/', [StreamController::class, 'index']);
        Route::post('/', [StreamController::class, 'create']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/vods', [VodController::class, 'index']);

//    Route::post('/publish', [MercureController::class, 'publish']);
//    Route::get('/subscriber-token', [MercureController::class, 'subscriberToken']);

//    Route::post('/streams/{id}/start', [StreamController::class, 'start']);
//    Route::post('/streams/{id}/end', [StreamController::class, 'end']);

    // chat
//    Route::post('/streams/{id}/chat', [ChatController::class, 'sendMessage']);
//    Route::get('/streams/{id}/chat', [ChatController::class, 'getMessages']);

    // followers
//    Route::post('/users/{id}/follow', [FollowerController::class, 'follow']);
//    Route::delete('/users/{id}/unfollow', [FollowerController::class, 'unfollow']);
});
