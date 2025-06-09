<?php

use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/tokens', [TokenController::class, 'store'])->name('token.store');
Route::delete('/tokens', [TokenController::class, 'destroy'])
    ->middleware('auth:sanctum')
    ->name('token.destroy');

Route::get('/profiles', [ProfileController::class, 'index'])->name('profiles.index');
Route::put('/profiles/{profile}', [ProfileController::class, 'update'])->name('profiles.update')
    ->middleware('auth:sanctum');
Route::delete('/profiles/{profile}', [ProfileController::class, 'destroy'])->name('profiles.destroy')
    ->middleware('auth:sanctum');

Route::post('/profiles/{profile}/comments', [CommentController::class, 'store'])
    ->name('profiles.comments.store')
    ->middleware('auth:sanctum');
