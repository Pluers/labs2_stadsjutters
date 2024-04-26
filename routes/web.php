<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get("/settings", function () {
    return view('settings');
});

Route::get('/post/create', function () {
    return view('post.create');
});

Route::post('/post/store', 'PostController@store');
