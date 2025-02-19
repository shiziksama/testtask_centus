<?php

use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('can add notification', function () {
    $user = User::factory()->create();

    auth()->login($user);

    Livewire::test('user-notifications')
        ->set('newNotification.city', 'Kyiv')
        ->set('newNotification.pop', 50)
        ->set('newNotification.uvi', 5)
        ->call('addNotification');

    expect(UserNotification::where('city', 'Kyiv')->exists())->toBeTrue();
});

it('can update notification', function () {
    $user = User::factory()->create();
    $notification = UserNotification::factory()->create(['user_id' => $user->id]);

    auth()->login($user);

    Livewire::test('user-notifications')
        ->set("notifications.{$notification->id}.city", 'Lviv')
        ->set("notifications.{$notification->id}.pop", 60)
        ->set("notifications.{$notification->id}.uvi", 6)
        ->call('updateNotification', $notification->id);

    $notification = UserNotification::find($notification->id);

    expect($notification->city)->toBe('Lviv');
    expect((float)$notification->pop)->toBe(60.0);
    expect((float)$notification->uvi)->toBe(6.0);
});
