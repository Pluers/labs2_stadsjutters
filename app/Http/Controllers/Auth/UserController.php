<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function show()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Return the user as a JSON response
        return response()->json($user);
    }
}
