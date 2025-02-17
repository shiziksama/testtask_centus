<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\UserNotification;

uses(RefreshDatabase::class);

it('shows the subscription page', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertViewIs('subscription');
});

it('subscribes a new user', function () {
    $response = $this->post('/', [
        'email' => 'test@example.com',
        'city' => 'Test City',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Subscription successful!');

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);

    $user = User::where('email', 'test@example.com')->first();

    $this->assertDatabaseHas('user_notifications', [
        'user_id' => $user->id,
        'city' => 'Test City',
    ]);
});

it('subscribes an existing user', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    $response = $this->post('/', [
        'email' => 'test@example.com',
        'city' => 'Test City',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Subscription successful!');

    $this->assertDatabaseHas('user_notifications', [
        'user_id' => $user->id,
        'city' => 'Test City',
    ]);
});

it('does not duplicate user notifications', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    UserNotification::factory()->create([
        'user_id' => $user->id,
        'city' => 'Test City',
    ]);

    $response = $this->post('/', [
        'email' => 'test@example.com',
        'city' => 'Test City',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Subscription successful!');

    $this->assertCount(1, UserNotification::where('user_id', $user->id)->where('city', 'Test City')->get());
});
