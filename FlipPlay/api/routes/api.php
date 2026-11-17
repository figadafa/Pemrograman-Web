<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('media', MediaController::class)
    ->parameters(['media' => 'media']);

Route::get('users/{user}/collection', [UserController::class, 'collection']);
Route::post('users/{user}/collection', [UserController::class, 'addToCollection']);
Route::delete('users/{user}/collection/{media}', [UserController::class, 'removeFromCollection']);

