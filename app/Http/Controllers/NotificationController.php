<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function saveToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user) {
            $user->update([
                'fcm_token' => $request->token,
                'notification_enabled' => true
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
