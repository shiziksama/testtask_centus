<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\WeatherNotification;

class UserNotification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'city','uvi','pop'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sendNotificationIfNeed($res)
    {
        if ($res['uvi'] > $this->uvi || $res['pop'] > $this->pop) {
            Mail::to($this->user->email)->send(new WeatherNotification($res));
        }
    }
}
