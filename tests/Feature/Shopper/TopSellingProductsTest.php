<?php

declare(strict_types=1);

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use Shopper\Core\Enum\PaymentStatus;
use Shopper\Core\Models\Order;
use Shopper\Core\Models\OrderItem;

uses(RefreshDatabase::class);

test('renders current top sellers when a previous cache entry stores product models', function (): void {
    $camera = Product::factory()->standard()->create([
        'name' => 'Cached Camera',
        'slug' => 'cached-camera',
    ]);
    $pending = Product::factory()->standard()->create([
        'name' => 'Unpaid Lens',
        'slug' => 'unpaid-lens',
    ]);

    OrderItem::factory()->create([
        'product_type' => $camera::class,
        'product_id' => $camera->id,
        'quantity' => 4,
        'order_id' => Order::factory()->create([
            'payment_status' => PaymentStatus::Paid,
            'created_at' => now(),
        ])->id,
    ]);

    OrderItem::factory()->create([
        'product_type' => $pending::class,
        'product_id' => $pending->id,
        'quantity' => 9,
        'order_id' => Order::factory()->create([
            'payment_status' => PaymentStatus::Pending,
            'created_at' => now(),
        ])->id,
    ]);

    Cache::put('dashboard:top-selling-products', [[
        'product' => $camera,
        'sales' => 99,
        'reviews_count' => 0,
        'average_rating' => null,
    ]], 1800);
    Cache::put(
        'illuminate:cache:flexible:created:dashboard:top-selling-products',
        now()->getTimestamp(),
        1800,
    );

    $component = Livewire::test('shopper-dashboard.top-selling-products')
        ->assertSee('Cached Camera')
        ->assertDontSee('Unpaid Lens');

    expect($component->instance()->products)->toHaveCount(1)
        ->and($component->instance()->products->first())->toBe([
            'name' => 'Cached Camera',
            'thumbnail' => $camera->getThumbnailUrl(),
            'sales' => 4,
            'reviews_count' => 0,
            'average_rating' => null,
        ]);

    expect(Cache::get('dashboard:top-products'))->toBe([[
        'name' => 'Cached Camera',
        'thumbnail' => $camera->getThumbnailUrl(),
        'sales' => 4,
        'reviews_count' => 0,
        'average_rating' => null,
    ]]);
});
