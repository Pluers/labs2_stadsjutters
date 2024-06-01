<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

// PostController
Route::get('/post/get/{id}', [PostController::class, 'show']);
Route::post('/post/store', [PostController::class, 'store']);
Route::get('/post/new', [PostController::class, 'create']);
Route::put('/post/update/{id}', [PostController::class, 'update']);


// Set the logged in user information in an url to retrieve in vue components
Route::middleware('auth')->group(function () {
    Route::get('/user', [UserController::class, 'getUser']);
    Route::put('/edit-profile', function (Request $request) {
        // Get the current user
        $user = Auth::user();

        // Update the user's properties with the request data
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        // Update more properties as needed

        // Save the user back to the database
        if ($user instanceof User) {
            $user->save();
        }

        // Return the updated user as a JSON response
        return $user;
    });
});

// General auth routes
Auth::routes();

// Catch-all route
Route::get('/{any}', [HomeController::class, 'index'])->where('any', '.*')->middleware('auth')->name('main-routes');
