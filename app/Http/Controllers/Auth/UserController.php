<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Models\User;

class UserController extends Controller
{

    public function getCurrentUser()
    {

        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Not logged in'], 401);
        }
        return response()->json($user);
    }
    public function getUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user);
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

        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $hash = hash_file('sha256', $file->getRealPath());
            $extension = $file->getClientOriginalExtension();
            $imageName = "{$hash}.{$extension}";
            $file->storeAs('public/images', $imageName);
            $user->picture = asset("storage/images/{$imageName}");
        }

        // Save the user back to the database
        if ($user instanceof User) {
            $user->save();
        }

        // Return the updated user as a JSON response
        return $user;
    }
}
