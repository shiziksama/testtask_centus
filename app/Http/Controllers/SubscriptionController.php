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

}
