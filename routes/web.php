<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NotificationsController;
use Illuminate\Support\Facades\Auth;

// PostController
Route::get('/api/post/get/{id}', [PostController::class, 'show']);
Route::get('/api/post/user/get/{id}', [PostController::class, 'getPostsByUserId']);
Route::get('/api/post/getall', [PostController::class, 'getAll']);
Route::post('/api/post/store', [PostController::class, 'store']);
Route::put('/api/post/update/{id}', [PostController::class, 'update']);
Route::delete('/api/post/delete/{id}', [PostController::class, 'destroy']);

// UserController
// Set the logged in user information in an url to retrieve in vue components
Route::middleware('auth')->group(function () {
    Route::get('/api/user', [UserController::class, 'getCurrentUser']);
    Route::get('/api/user/getall', [UserController::class, 'getAllUsers']);
    Route::get('/api/user/{id}', [UserController::class, 'getUser']);
    Route::put('/api/user/update', [UserController::class, 'editProfile']);
    Route::delete('/api/user/delete/{id}', [UserController::class, 'destroy']);
});

Route::get('/api/notifications', [NotificationsController::class, 'index']);
Route::delete('/api/notifications/delete/{id}', [NotificationsController::class, 'destroy']);


// General auth routes
Auth::routes();

// Catch-all route
Route::get('/{any}', [HomeController::class, 'index'])->where('any', '.*')->middleware('auth')->name('main-routes');
