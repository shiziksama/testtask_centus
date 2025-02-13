<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\WeatherNotification;


class UserNotification extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','city'];
    public function sendNotificationIfNeed($res){
        if($res->uv>3||$res->pop>50){
            Mail::to($this->user->email)->send(new WeatherNotification($res));
        }
    }
}
