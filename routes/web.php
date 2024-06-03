<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Auth;

// PostController
Route::get('/api/post/get/{id}', [PostController::class, 'show']);
Route::get('/api/post/getall', [PostController::class, 'getPosts']);
Route::post('/api/post/store', [PostController::class, 'store']);
Route::get('/post/new', [PostController::class, 'create']);
Route::put('/api/post/update/{id}', [PostController::class, 'update']);


// Set the logged in user information in an url to retrieve in vue components
Route::middleware('auth')->group(function () {
    Route::get('/api/user', [UserController::class, 'getCurrentUser']);
    Route::get('/api/user/getall', [UserController::class, 'getAllUsers']);
    Route::get('/api/user/{id}', [UserController::class, 'getUser']);
    Route::put('/api/user/update', [UserController::class, 'editProfile']);
});

// General auth routes
Auth::routes();

// Catch-all route
Route::get('/{any}', [HomeController::class, 'index'])->where('any', '.*')->middleware('auth')->name('main-routes');
