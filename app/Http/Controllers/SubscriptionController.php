<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Hash;

class SubscriptionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user ? UserNotification::where('user_id', $user->id)->get() : [];
        return view('subscription', compact('notifications')); 
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'city' => 'required|string|max:255',
        ]);

        
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            $password = Hash::make($request->input('email')); // temporary password, only for tier1

            $user = User::create([
                'email' => $request->input('email'),
                'name' => $request->input('email'),
                'password' => $password,
            ]);
        }

        $userNotification = UserNotification::where('user_id', $user->id)
            ->where('city', $request->input('city'))
            ->first();

        if (!$userNotification) {
            UserNotification::create([
                'user_id' => $user->id,
                'city' => $request->input('city',''),
                'city_id' => 0, // Assuming city_id is not provided and defaulting to 0
            ]);
        }

        return redirect()->back()->with('success', 'Subscription successful!');
    }
}
