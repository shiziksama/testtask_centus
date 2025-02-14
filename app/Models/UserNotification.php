<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\WeatherNotification;

class UserNotification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'city'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sendNotificationIfNeed($res)
    {
        if ($res['uvi'] > 0.3 || $res['pop'] > 0.5) {
            Mail::to($this->user->email)->send(new WeatherNotification($res));
        }
    }
}
