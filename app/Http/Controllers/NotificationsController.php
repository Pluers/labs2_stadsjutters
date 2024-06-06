<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

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

    public function destroy($id)
    {
        $notification = Notification::find($id);
        $notification->delete();
        return response()->json(['notification' => $notification, 'message' => 'Notification deleted'], 204);
    }
}
