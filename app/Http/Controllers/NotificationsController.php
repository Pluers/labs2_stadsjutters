<?php

namespace App\Http\Controllers;

use App\Notifications\NewPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['index']]);
    }

    public function index()
    {
        $user = Auth::user();

        if ($user) {
            $notifications = $user->notifications;

            return response()->json($notifications);
        } else {
            return response()->json(['error' => 'Not logged in'], 401);
        }
    }

    public function create()
    {
        return null;
    }
}
