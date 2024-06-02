<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Models\User;

class UserController extends Controller
{

    public function getUser()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Return the user as a JSON response
        return response()->json($user);
    }
    public function getUserApi(Request $request)
    {
        return $request->user();
    }

    public function editProfile(Request $request)
    {
        // Get the current user
        $user = Auth::user();

        // Update the user's properties with the request data
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        // Update more properties as needed

        // Save the user back to the database
        if ($user instanceof User) {
            $user->save();
        }

        // Return the updated user as a JSON response
        return $user;
    }
}
