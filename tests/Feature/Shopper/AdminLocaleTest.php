<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Shopper\Database\Seeders\AuthTableSeeder;
use Shopper\Livewire\Components\LocaleSwitcher;

uses(RefreshDatabase::class);

test('shopper translations return ukrainian text', function (): void {
    app()->setLocale('uk');

    expect(__('shopper::layout.sidebar.catalog'))->toBe('Каталог');
    expect(__('shopper::pages/auth.login.title'))->toBe('Увійти за допомогою email');
    expect(__('shopper-core::roles.admin.display_name'))->toBe('Адміністратор');
});

test('admin login page renders ukrainian copy when the admin locale is uk', function (): void {
    $this->withSession(['shopper_locale' => 'uk'])
        ->get(route('shopper.login'))
        ->assertSuccessful()
        ->assertSee('Увійти за допомогою email')
        ->assertSee('Увійдіть до адмінпанелі Shopper');
});

test('admin login page renders english copy when the admin locale is en', function (): void {
    $this->withSession(['shopper_locale' => 'en'])
        ->get(route('shopper.login'))
        ->assertSuccessful()
        ->assertSee('Sign in with email')
        ->assertDontSee('Увійти за допомогою email');
});

test('admin requests keep the selected admin locale in the session', function (): void {
    $this->withSession(['shopper_locale' => 'en', 'locale' => 'uk'])
        ->get(route('shopper.login'))
        ->assertSuccessful()
        ->assertSessionHas('shopper_locale', 'en')
        ->assertSee('Sign in with email');
});

test('locale switcher lists ukrainian among admin languages', function (): void {
    $this->seed(AuthTableSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole(config('shopper.admin.roles.admin'));

    Livewire::actingAs($admin)
        ->test(LocaleSwitcher::class)
        ->assertSee('Українська')
        ->assertSee('English');
});

test('switching the admin locale to ukrainian stores it in the session', function (): void {
    $this->seed(AuthTableSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole(config('shopper.admin.roles.admin'));

    $this->withSession(['shopper_locale' => 'en']);

    Livewire::actingAs($admin)
        ->test(LocaleSwitcher::class)
        ->call('switchLocale', 'uk');

    expect(session('shopper_locale'))->toBe('uk');
});
