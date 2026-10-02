<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Shopper\Core\Models\Order;
use Shopper\Core\Models\OrderAddress;
use Shopper\Database\Seeders\AuthTableSeeder;
use Shopper\Livewire\Components\Orders\OrderCustomer;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed(AuthTableSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole(config('shopper.admin.roles.admin'));

    $this->actingAs($admin);
});

test('guest order shows the email and phone entered at checkout', function (): void {
    $shippingAddress = OrderAddress::query()->create([
        'customer_id' => null,
        'first_name' => 'Olena',
        'last_name' => 'Koval',
        'street_address' => 'Khreshchatyk 1',
        'city' => 'Kyiv',
        'postal_code' => '01001',
        'phone' => '0955807707',
        'country_name' => 'Ukraine',
    ]);

    $order = Order::factory()->create([
        'currency_code' => 'USD',
        'customer_id' => null,
        'email' => 'guest@example.com',
        'shipping_address_id' => $shippingAddress->id,
    ]);

    Livewire::test(OrderCustomer::class, ['order' => $order])
        ->assertSee('mailto:guest@example.com', false)
        ->assertSee('0955807707')
        ->assertDontSee(__('shopper::pages/orders.customer_infos_empty'));
});

test('guest order without an email shows the empty contact message', function (): void {
    $order = Order::factory()->create([
        'currency_code' => 'USD',
        'customer_id' => null,
        'email' => null,
    ]);

    Livewire::test(OrderCustomer::class, ['order' => $order])
        ->assertSee(__('shopper::pages/orders.customer_infos_empty'));
});
