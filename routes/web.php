<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

// PostController
Route::get('/post', [PostController::class, 'index']);
Route::get('/post/show', [PostController::class, 'show']);
Route::post('/post/store', [PostController::class, 'store']);
Route::get('/post/create', [PostController::class, 'create']);
Route::get('/post/update', [PostController::class, 'update']);

// Catch-all route
Route::get('/{any}', [HomeController::class, 'index'])->where('any', '.*')->name('home');
