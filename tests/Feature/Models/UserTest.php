<?php

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Shopper\Database\Seeders\AuthTableSeeder;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->seed(AuthTableSeeder::class);
});

test('an administrator reaches the onboarding page when the store is not configured', function () {
    $administrator = User::factory()->create();
    $administrator->assignRole(config('shopper.admin.roles.admin'));

    $this->actingAs($administrator)
        ->get(route('shopper.dashboard'))
        ->assertRedirectToRoute('shopper.initialize');

    $this->actingAs($administrator)
        ->get(route('shopper.initialize'))
        ->assertSuccessful();
});

test('a user without dashboard access reaches the forbidden page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('shopper.dashboard'))
        ->assertRedirectToRoute('shopper.forbidden');

    $this->actingAs($user)
        ->get(route('shopper.forbidden'))
        ->assertSuccessful();
});
