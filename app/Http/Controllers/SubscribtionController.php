<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserNotification;

class SubscribtionController extends Controller
{
    public function index()
    {
        return view('subscription');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'city' => 'required|string|max:255',
        ]);

        $user = User::create([
            'email' => $request->input('email'),
        ]);

        UserNotification::create([
            'user_id' => $user->id,
            'city' => $request->input('city'),
            'city_id' => 0, // Assuming city_id is not provided and defaulting to 0
        ]);

        return redirect()->back()->with('success', 'Subscription successful!');
    }
}
