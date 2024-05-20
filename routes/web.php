<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// PostController
Route::get('/post', [PostController::class, 'index']);
Route::get('/post/show', [PostController::class, 'show']);
Route::post('/post/store', [PostController::class, 'store']);
Route::get('/post/create', [PostController::class, 'create']);
Route::get('/post/update', [PostController::class, 'update']);

// Set the logged in user information in an url to retrieve in vue components
Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

// General auth routes
Auth::routes();

// Catch-all route
Route::get('/{any}', [HomeController::class, 'index'])->where('any', '.*')->middleware('auth')->name('main-routes');
