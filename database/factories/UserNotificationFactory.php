<?php

namespace Database\Factories;

use App\Models\UserNotification;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserNotificationFactory extends Factory
{
    protected $model = UserNotification::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'city' => $this->faker->city,
        ];
    }
}
