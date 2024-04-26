<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Change this to be used in a controller later
Route::get("/settings", function () {
    return view('settings');
});
Route::get("/map", function () {
    return view('map');
});
Route::get("/profile", function () {
    return view('profile');
});
Route::get("/notifications", function () {
    return view('notifications');
});

// PostController
Route::get('/post', [PostController::class, 'index']);
Route::get('/post/create', [PostController::class, 'create']);
