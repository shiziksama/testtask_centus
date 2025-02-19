<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\UserNotification;

uses(RefreshDatabase::class);

it('shows the subscription page', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get('/');
    $response->assertStatus(200);
    $response->assertViewIs('subscription');
});
