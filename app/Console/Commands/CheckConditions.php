<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Weather\WeatherService;
use   App\Models\UserNotification;

class CheckConditions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conditions:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check weather conditions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $weatherService = app(WeatherService::class);
        $userNotifications = UserNotification::all();
        foreach($userNotifications as $notify){
            //TODO cache results
            $res=$weatherService->getWeatherByCity($notify->city);
            $notify->sendNotificationIfNeed($res);
        }
    }
}
